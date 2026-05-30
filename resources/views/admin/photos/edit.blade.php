@extends('layouts.admin')
@section('title', 'Modifier la photo')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.photos.update', $photo) }}" enctype="multipart/form-data" id="uploadForm">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $photo->title) }}" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                @if($photo->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $photo->image) }}" class="img-thumb" alt="{{ $photo->title }}">
                    </div>
                    <small class="text-muted d-block mb-1">Laisser vide pour garder l'image actuelle</small>
                @endif
                <input type="file" name="image" id="image" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif,.jpg,.jpeg,.png,.webp,.gif">
                <div id="imagePreview" class="mt-2" style="display:none;">
                    <img id="previewImg" src="" alt="Apercu" style="max-height:200px;max-width:100%;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,.15);">
                    <div class="mt-1"><small class="text-muted" id="fileInfo"></small></div>
                </div>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Categorie</label>
                <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $photo->category) }}" placeholder="ex: Jardin, Terrasse, Balcon">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $photo->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="sort_order" class="form-label">Ordre d'affichage</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $photo->sort_order) }}" min="0">
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $photo->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Actif</label>
                    </div>
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ old('is_featured', $photo->is_featured) ? 'checked' : '' }}>
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
                <a href="{{ route('admin.photos.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    #imagePreview { animation: fadeIn .3s; }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
</style>
@endsection

@section('scripts')
<script>
document.getElementById('image').addEventListener('change', function(e) {
    var file = e.target.files[0];
    if (!file) { document.getElementById('imagePreview').style.display = 'none'; return; }
    var reader = new FileReader();
    reader.onload = function(ev) {
        document.getElementById('previewImg').src = ev.target.result;
        document.getElementById('imagePreview').style.display = 'block';
        var size = (file.size / 1024 / 1024).toFixed(2);
        document.getElementById('fileInfo').textContent = file.name + ' (' + size + ' Mo)';
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
            window.location.href = '{{ route("admin.photos.index") }}';
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
