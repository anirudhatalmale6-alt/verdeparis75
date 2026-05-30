@extends('layouts.admin')
@section('title', 'Modifier le partenaire')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.partners.update', $partner) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $partner->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                @if($partner->logo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/uploads/partners/' . $partner->logo) }}" class="img-thumb" alt="{{ $partner->name }}">
                    </div>
                    <small class="text-muted d-block mb-1">Laisser vide pour garder l'image actuelle</small>
                @endif
                <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="website" class="form-label">Site web</label>
                <input type="url" name="website" id="website" class="form-control" value="{{ old('website', $partner->website) }}" placeholder="https://...">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $partner->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="sort_order" class="form-label">Ordre d'affichage</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $partner->sort_order) }}" min="0">
                </div>
                <div class="col-md-6 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $partner->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Actif</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-vp">
                    <i class="bi bi-check-circle me-1"></i> Mettre a jour
                </button>
                <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
