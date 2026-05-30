@extends('layouts.admin')
@section('title', 'Ajouter une photo')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.photos.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Categorie</label>
                <input type="text" name="category" id="category" class="form-control" value="{{ old('category') }}" placeholder="ex: Jardin, Terrasse, Balcon">
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
                <a href="{{ route('admin.photos.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
