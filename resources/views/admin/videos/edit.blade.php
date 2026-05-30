@extends('layouts.admin')
@section('title', 'Modifier la video')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.videos.update', $video) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $video->title) }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $video->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="video_url" class="form-label">URL de la video <span class="text-danger">*</span></label>
                <input type="url" name="video_url" id="video_url" class="form-control" value="{{ old('video_url', $video->video_url) }}" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="video_type" class="form-label">Type de video <span class="text-danger">*</span></label>
                    <select name="video_type" id="video_type" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <option value="youtube" {{ old('video_type', $video->video_type) == 'youtube' ? 'selected' : '' }}>YouTube</option>
                        <option value="vimeo" {{ old('video_type', $video->video_type) == 'vimeo' ? 'selected' : '' }}>Vimeo</option>
                        <option value="mp4" {{ old('video_type', $video->video_type) == 'mp4' ? 'selected' : '' }}>MP4</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">Categorie</label>
                    <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $video->category) }}" placeholder="ex: Chantier, Tutoriel">
                </div>
            </div>

            <div class="mb-3">
                <label for="thumbnail" class="form-label">Miniature</label>
                @if($video->thumbnail)
                    <div class="mb-2">
                        <img src="{{ asset('storage/uploads/videos/' . $video->thumbnail) }}" class="img-thumb" alt="{{ $video->title }}">
                    </div>
                    <small class="text-muted d-block mb-1">Laisser vide pour garder l'image actuelle</small>
                @endif
                <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="sort_order" class="form-label">Ordre d'affichage</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $video->sort_order) }}" min="0">
                </div>
                <div class="col-md-6 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $video->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Actif</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-vp">
                    <i class="bi bi-check-circle me-1"></i> Mettre a jour
                </button>
                <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
