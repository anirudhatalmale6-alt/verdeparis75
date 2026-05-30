@extends('layouts.admin')
@section('title', 'Ajouter un partenaire')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="website" class="form-label">Site web</label>
                <input type="url" name="website" id="website" class="form-control" value="{{ old('website') }}" placeholder="https://...">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="sort_order" class="form-label">Ordre d'affichage</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                </div>
                <div class="col-md-6 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Actif</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-vp">
                    <i class="bi bi-check-circle me-1"></i> Enregistrer
                </button>
                <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
