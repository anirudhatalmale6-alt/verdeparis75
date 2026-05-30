@extends('layouts.admin')
@section('title', 'Modifier la comparaison Avant/Apres')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.before-after.update', $item) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $item->title) }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $item->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="before_image" class="form-label">Image Avant</label>
                    @if($item->before_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $item->before_image) }}" class="img-thumb" alt="Avant">
                        </div>
                        <small class="text-muted d-block mb-1">Laisser vide pour garder l'image actuelle</small>
                    @endif
                    <input type="file" name="before_image" id="before_image" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="after_image" class="form-label">Image Apres</label>
                    @if($item->after_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $item->after_image) }}" class="img-thumb" alt="Apres">
                        </div>
                        <small class="text-muted d-block mb-1">Laisser vide pour garder l'image actuelle</small>
                    @endif
                    <input type="file" name="after_image" id="after_image" class="form-control" accept="image/*">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="category" class="form-label">Categorie</label>
                    <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $item->category) }}" placeholder="ex: Jardin, Terrasse">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="sort_order" class="form-label">Ordre d'affichage</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $item->sort_order) }}" min="0">
                </div>
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Actif</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-vp">
                    <i class="bi bi-check-circle me-1"></i> Mettre a jour
                </button>
                <a href="{{ route('admin.before-after.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
