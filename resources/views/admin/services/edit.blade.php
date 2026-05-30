@extends('layouts.admin')
@section('title', 'Modifier le service')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $service->title) }}" required>
            </div>

            <div class="mb-3">
                <label for="short_description" class="form-label">Description courte</label>
                <textarea name="short_description" id="short_description" class="form-control" rows="3">{{ old('short_description', $service->short_description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="6">{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="icon" class="form-label">Icone (classe Bootstrap Icons)</label>
                <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon', $service->icon) }}" placeholder="ex: bi-tree">
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                @if($service->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/uploads/services/' . $service->image) }}" class="img-thumb" alt="{{ $service->title }}">
                    </div>
                    <small class="text-muted d-block mb-1">Laisser vide pour garder l'image actuelle</small>
                @endif
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="sort_order" class="form-label">Ordre d'affichage</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $service->sort_order) }}" min="0">
                </div>
                <div class="col-md-6 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Actif</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-vp">
                    <i class="bi bi-check-circle me-1"></i> Mettre a jour
                </button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
