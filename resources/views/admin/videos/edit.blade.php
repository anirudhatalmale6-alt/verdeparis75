@extends('layouts.admin')
@section('title', 'Modifier la video')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.videos.update', $video) }}" enctype="multipart/form-data" id="uploadForm">
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
                <label for="video_url" class="form-label">URL de la video</label>
                <input type="url" name="video_url" id="video_url" class="form-control" value="{{ old('video_url', $video->video_url) }}" placeholder="https://www.youtube.com/watch?v=...">
                <small class="text-muted">YouTube, Vimeo, ou lien direct vers un fichier video</small>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="video_type" class="form-label">Type de video <span class="text-danger">*</span></label>
                    <select name="video_type" id="video_type" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        <option value="youtube" {{ old('video_type', $video->video_type) == 'youtube' ? 'selected' : '' }}>YouTube</option>
                        <option value="vimeo" {{ old('video_type', $video->video_type) == 'vimeo' ? 'selected' : '' }}>Vimeo</option>
                        <option value="mp4" {{ old('video_type', $video->video_type) == 'mp4' ? 'selected' : '' }}>MP4 / MOV / WEBM</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">Categorie</label>
                    <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $video->category) }}" placeholder="ex: Chantier, Tutoriel">
                </div>
            </div>

            <div class="mb-3">
                <label for="video_file" class="form-label">Fichier video (optionnel)</label>
                <input type="file" name="video_file" id="video_file" class="form-control" accept="video/mp4,video/quicktime,video/webm,video/x-msvideo,.mp4,.mov,.webm,.avi">
                <small class="text-muted">MP4, MOV (iPhone), WEBM, AVI - Max 500 Mo - Remplace la video actuelle</small>
                <div id="videoPreview" class="mt-2" style="display:none;">
                    <video id="previewVideo" controls style="max-height:200px;max-width:100%;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,.15);"></video>
                    <div class="mt-1"><small class="text-muted" id="videoFileInfo"></small></div>
                </div>
            </div>

            <div class="mb-3">
                <label for="thumbnail" class="form-label">Miniature</label>
                @if($video->thumbnail)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $video->thumbnail) }}" class="img-thumb" alt="{{ $video->title }}">
                    </div>
                    <small class="text-muted d-block mb-1">Laisser vide pour garder l'image actuelle</small>
                @endif
                <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/jpeg,image/png,image/webp,.jpg,.jpeg,.png,.webp">
                <div id="thumbPreview" class="mt-2" style="display:none;">
                    <img id="previewThumb" src="" alt="Apercu miniature" style="max-height:150px;max-width:100%;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,.15);">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="sort_order" class="form-label">Ordre d'affichage</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $video->sort_order) }}" min="0">
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $video->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Actif</label>
                    </div>
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ old('is_featured', $video->is_featured) ? 'checked' : '' }}>
                        <label for="is_featured" class="form-check-label">Mise en avant</label>
                    </div>
                </div>
            </div>

            <div id="uploadProgress" style="display:none;" class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <small class="fw-bold">Envoi en cours...</small>
                    <small id="progressPercent">0%</small>
                </div>
                <div class="progress" style="height:8px;">
                    <div id="progressBar" class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width:0%"></div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-vp" id="submitBtn">
                    <i class="bi bi-check-circle me-1"></i> Mettre a jour
                </button>
                <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    #videoPreview, #thumbPreview { animation: fadeIn .3s; }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
</style>
@endsection

@section('scripts')
<script>
document.getElementById('video_file').addEventListener('change', function(e) {
    var file = e.target.files[0];
    if (!file) { document.getElementById('videoPreview').style.display = 'none'; return; }
    var url = URL.createObjectURL(file);
    document.getElementById('previewVideo').src = url;
    document.getElementById('videoPreview').style.display = 'block';
    var size = (file.size / 1024 / 1024).toFixed(2);
    document.getElementById('videoFileInfo').textContent = file.name + ' (' + size + ' Mo)';
});

document.getElementById('thumbnail').addEventListener('change', function(e) {
    var file = e.target.files[0];
    if (!file) { document.getElementById('thumbPreview').style.display = 'none'; return; }
    var reader = new FileReader();
    reader.onload = function(ev) {
        document.getElementById('previewThumb').src = ev.target.result;
        document.getElementById('thumbPreview').style.display = 'block';
    };
    reader.readAsDataURL(file);
});

document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = this;
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();
    document.getElementById('uploadProgress').style.display = 'block';
    document.getElementById('submitBtn').disabled = true;
    document.getElementById('submitBtn').innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Envoi...';
    xhr.upload.addEventListener('progress', function(ev) {
        if (ev.lengthComputable) {
            var pct = Math.round((ev.loaded / ev.total) * 100);
            document.getElementById('progressBar').style.width = pct + '%';
            document.getElementById('progressPercent').textContent = pct + '%';
        }
    });
    xhr.addEventListener('load', function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            window.location.href = '{{ route("admin.videos.index") }}';
        } else {
            document.getElementById('submitBtn').disabled = false;
            document.getElementById('submitBtn').innerHTML = '<i class="bi bi-check-circle me-1"></i> Mettre a jour';
            document.getElementById('uploadProgress').style.display = 'none';
            alert('Erreur lors de l\'envoi. Veuillez reessayer.');
        }
    });
    xhr.addEventListener('error', function() {
        document.getElementById('submitBtn').disabled = false;
        document.getElementById('submitBtn').innerHTML = '<i class="bi bi-check-circle me-1"></i> Mettre a jour';
        document.getElementById('uploadProgress').style.display = 'none';
        alert('Erreur de connexion. Veuillez reessayer.');
    });
    xhr.open('POST', form.action);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send(formData);
});
</script>
@endsection
