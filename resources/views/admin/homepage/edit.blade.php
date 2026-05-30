@extends('layouts.admin')
@section('title', "Modifier la section — " . ($sectionLabel ?? $sectionKey))

@section('actions')
    <a href="{{ route('admin.homepage.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.homepage.update', $sectionKey) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $section->title ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="subtitle" class="form-label">Sous-titre</label>
                <textarea name="subtitle" id="subtitle" class="form-control" rows="2">{{ old('subtitle', $section->subtitle ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Contenu</label>
                <textarea name="content" id="content" class="form-control" rows="6">{{ old('content', $section->content ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                @if(isset($section->image) && $section->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $section->image) }}" class="img-thumb" alt="Image de section">
                    </div>
                    <small class="text-muted d-block mb-1">Laisser vide pour garder l'image actuelle</small>
                @endif
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="button_text" class="form-label">Texte du bouton</label>
                    <input type="text" name="button_text" id="button_text" class="form-control" value="{{ old('button_text', $section->button_text ?? '') }}" placeholder="ex: Decouvrir nos services">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="button_url" class="form-label">URL du bouton</label>
                    <input type="text" name="button_url" id="button_url" class="form-control" value="{{ old('button_url', $section->button_url ?? '') }}" placeholder="ex: /services">
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $section->is_active ?? true) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">Actif</label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-vp">
                    <i class="bi bi-check-circle me-1"></i> Enregistrer
                </button>
                <a href="{{ route('admin.homepage.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
