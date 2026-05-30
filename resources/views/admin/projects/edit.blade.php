@extends('layouts.admin')
@section('title', 'Modifier la realisation')

@section('content')
<div class="card mb-4">
    <div class="card-header">Informations du projet</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $project->title) }}" required>
            </div>

            <div class="mb-3">
                <label for="short_description" class="form-label">Description courte</label>
                <textarea name="short_description" id="short_description" class="form-control" rows="3">{{ old('short_description', $project->short_description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="6">{{ old('description', $project->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="client_name" class="form-label">Nom du client</label>
                    <input type="text" name="client_name" id="client_name" class="form-control" value="{{ old('client_name', $project->client_name) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="location" class="form-label">Lieu</label>
                    <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $project->location) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="project_date" class="form-label">Date du projet</label>
                    <input type="date" name="project_date" id="project_date" class="form-control" value="{{ old('project_date', $project->project_date ? $project->project_date->format('Y-m-d') : '') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">Categorie</label>
                    <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $project->category) }}" placeholder="ex: Jardin, Terrasse, Balcon">
                </div>
            </div>

            <div class="mb-3">
                <label for="cover_image" class="form-label">Image de couverture</label>
                @if($project->cover_image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/uploads/projects/' . $project->cover_image) }}" class="img-thumb" alt="{{ $project->title }}">
                    </div>
                    <small class="text-muted d-block mb-1">Laisser vide pour garder l'image actuelle</small>
                @endif
                <input type="file" name="cover_image" id="cover_image" class="form-control" accept="image/*">
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="sort_order" class="form-label">Ordre d'affichage</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $project->sort_order) }}" min="0">
                </div>
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}>
                        <label for="is_featured" class="form-check-label">Vedette</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $project->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Actif</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-vp">
                    <i class="bi bi-check-circle me-1"></i> Mettre a jour
                </button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

{{-- Section de gestion des images du projet --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-images me-2"></i>Images du projet</span>
        <button type="button" class="btn btn-sm btn-vp" data-bs-toggle="modal" data-bs-target="#addImageModal">
            <i class="bi bi-plus-circle me-1"></i> Ajouter des images
        </button>
    </div>
    <div class="card-body">
        @if(isset($project->images) && $project->images->count())
            <div class="row g-3">
                @foreach($project->images as $image)
                    <div class="col-6 col-md-3">
                        <div class="position-relative">
                            <img src="{{ asset('storage/uploads/projects/gallery/' . $image->filename) }}" class="img-fluid rounded" alt="{{ $image->title ?? '' }}" style="width:100%; height:150px; object-fit:cover;">
                            <form method="POST" action="{{ route('admin.projects.images.destroy', [$project, $image]) }}" class="position-absolute top-0 end-0 m-1" onsubmit="return confirm('Supprimer cette image ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger rounded-circle" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted text-center py-3">Aucune image supplementaire</p>
        @endif
    </div>
</div>

{{-- Modal ajout d'images --}}
<div class="modal fade" id="addImageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.projects.images.store', $project) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter des images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="images" class="form-label">Selectionner des images</label>
                        <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-vp">
                        <i class="bi bi-upload me-1"></i> Telecharger
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
