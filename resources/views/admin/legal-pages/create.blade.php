@extends('layouts.admin')
@section('title', 'Ajouter une page legale')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.legal-pages.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                    <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" placeholder="ex: mentions-legales" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Contenu <span class="text-danger">*</span></label>
                <textarea name="content" id="content" class="form-control" rows="15" required>{{ old('content') }}</textarea>
            </div>

            <div class="mb-3 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">Actif</label>
                </div>
            </div>

            <hr>
            <h6 class="text-muted mb-3">SEO</h6>

            <div class="mb-3">
                <label for="meta_title" class="form-label">Meta titre</label>
                <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title') }}">
            </div>

            <div class="mb-3">
                <label for="meta_description" class="form-label">Meta description</label>
                <textarea name="meta_description" id="meta_description" class="form-control" rows="2">{{ old('meta_description') }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-vp">
                    <i class="bi bi-check-circle me-1"></i> Enregistrer
                </button>
                <a href="{{ route('admin.legal-pages.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
