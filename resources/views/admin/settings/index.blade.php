@extends('layouts.admin')
@section('title', 'Parametres')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="accordion" id="settingsAccordion">
        {{-- Groupe : General --}}
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral">
                    <i class="bi bi-gear me-2"></i> General
                </button>
            </h2>
            <div id="collapseGeneral" class="accordion-collapse collapse show" data-bs-parent="#settingsAccordion">
                <div class="accordion-body">
                    @foreach($settings->where('group', 'general') as $setting)
                        <div class="mb-3">
                            <label for="setting_{{ $setting->key }}" class="form-label">{{ $setting->label }}</label>
                            @if($setting->type === 'textarea')
                                <textarea name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}" class="form-control" rows="3">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                            @elseif($setting->type === 'image')
                                @if($setting->value)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $setting->value) }}" class="img-thumb" alt="{{ $setting->label }}">
                                    </div>
                                    <small class="text-muted d-block mb-1">Laisser vide pour garder l'image actuelle</small>
                                @endif
                                <input type="file" name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}" class="form-control" accept="image/*">
                            @elseif($setting->type === 'checkbox')
                                <div class="form-check">
                                    <input type="checkbox" name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}" class="form-check-input" value="1" {{ $setting->value ? 'checked' : '' }}>
                                    <label for="setting_{{ $setting->key }}" class="form-check-label">Activer</label>
                                </div>
                            @else
                                <input type="text" name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}" class="form-control" value="{{ old('settings.' . $setting->key, $setting->value) }}">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Groupe : Contact --}}
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContact">
                    <i class="bi bi-telephone me-2"></i> Contact
                </button>
            </h2>
            <div id="collapseContact" class="accordion-collapse collapse" data-bs-parent="#settingsAccordion">
                <div class="accordion-body">
                    @foreach($settings->where('group', 'contact') as $setting)
                        <div class="mb-3">
                            <label for="setting_{{ $setting->key }}" class="form-label">{{ $setting->label }}</label>
                            @if($setting->type === 'textarea')
                                <textarea name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}" class="form-control" rows="3">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                            @else
                                <input type="text" name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}" class="form-control" value="{{ old('settings.' . $setting->key, $setting->value) }}">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Groupe : Social --}}
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSocial">
                    <i class="bi bi-share me-2"></i> Reseaux sociaux
                </button>
            </h2>
            <div id="collapseSocial" class="accordion-collapse collapse" data-bs-parent="#settingsAccordion">
                <div class="accordion-body">
                    @foreach($settings->where('group', 'social') as $setting)
                        <div class="mb-3">
                            <label for="setting_{{ $setting->key }}" class="form-label">{{ $setting->label }}</label>
                            <input type="text" name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}" class="form-control" value="{{ old('settings.' . $setting->key, $setting->value) }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Groupe : Widget Visiteurs --}}
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseVisitorWidget">
                    <i class="bi bi-people me-2"></i> Widget Visiteurs en ligne
                </button>
            </h2>
            <div id="collapseVisitorWidget" class="accordion-collapse collapse" data-bs-parent="#settingsAccordion">
                <div class="accordion-body">
                    @foreach($settings->where('group', 'visitor_widget') as $setting)
                        <div class="mb-3">
                            <label for="setting_{{ $setting->key }}" class="form-label">{{ $setting->label }}</label>
                            @if($setting->type === 'checkbox')
                                <div class="form-check">
                                    <input type="checkbox" name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}" class="form-check-input" value="1" {{ $setting->value ? 'checked' : '' }}>
                                    <label for="setting_{{ $setting->key }}" class="form-check-label">Activer</label>
                                </div>
                            @else
                                <input type="text" name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}" class="form-control" value="{{ old('settings.' . $setting->key, $setting->value) }}">
                            @endif
                            @if($setting->key === 'visitor_widget_position')
                                <small class="text-muted">Options: after_hero, before_footer, floating</small>
                            @endif
                            @if($setting->key === 'visitor_widget_color')
                                <small class="text-muted">Code couleur hex (ex: #0E7A32)</small>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Groupe : Footer --}}
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFooter">
                    <i class="bi bi-layout-three-columns me-2"></i> Pied de page
                </button>
            </h2>
            <div id="collapseFooter" class="accordion-collapse collapse" data-bs-parent="#settingsAccordion">
                <div class="accordion-body">
                    @foreach($settings->where('group', 'footer') as $setting)
                        <div class="mb-3">
                            <label for="setting_{{ $setting->key }}" class="form-label">{{ $setting->label }}</label>
                            @if($setting->type === 'textarea')
                                <textarea name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}" class="form-control" rows="3">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                            @elseif($setting->type === 'checkbox')
                                <div class="form-check">
                                    <input type="checkbox" name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}" class="form-check-input" value="1" {{ $setting->value ? 'checked' : '' }}>
                                    <label for="setting_{{ $setting->key }}" class="form-check-label">Activer</label>
                                </div>
                            @else
                                <input type="text" name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}" class="form-control" value="{{ old('settings.' . $setting->key, $setting->value) }}">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-vp btn-lg">
            <i class="bi bi-check-circle me-1"></i> Enregistrer tous les parametres
        </button>
    </div>
</form>
@endsection
