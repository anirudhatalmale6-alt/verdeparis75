@extends('layouts.admin')
@section('title', 'SEO — ' . ($pageLabel ?? $page))

@section('actions')
    <a href="{{ route('admin.seo.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.seo.update', $page) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="meta_title" class="form-label">Meta titre</label>
                <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title', $seo->meta_title ?? '') }}" maxlength="70">
                <small class="text-muted">Recommande : 50-60 caracteres</small>
            </div>

            <div class="mb-3">
                <label for="meta_description" class="form-label">Meta description</label>
                <textarea name="meta_description" id="meta_description" class="form-control" rows="3" maxlength="160">{{ old('meta_description', $seo->meta_description ?? '') }}</textarea>
                <small class="text-muted">Recommande : 150-160 caracteres</small>
            </div>

            <div class="mb-3">
                <label for="meta_keywords" class="form-label">Meta mots-cles</label>
                <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ old('meta_keywords', $seo->meta_keywords ?? '') }}" placeholder="paysagiste, jardin, Paris, amenagement">
                <small class="text-muted">Separes par des virgules</small>
            </div>

            <hr>
            <h6 class="text-muted mb-3">Open Graph (reseaux sociaux)</h6>

            <div class="mb-3">
                <label for="og_title" class="form-label">OG Titre</label>
                <input type="text" name="og_title" id="og_title" class="form-control" value="{{ old('og_title', $seo->og_title ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="og_description" class="form-label">OG Description</label>
                <textarea name="og_description" id="og_description" class="form-control" rows="2">{{ old('og_description', $seo->og_description ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="og_image" class="form-label">OG Image</label>
                @if(isset($seo->og_image) && $seo->og_image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $seo->og_image) }}" class="img-thumb" alt="OG Image">
                    </div>
                    <small class="text-muted d-block mb-1">Laisser vide pour garder l'image actuelle</small>
                @endif
                <input type="file" name="og_image" id="og_image" class="form-control" accept="image/*">
                <small class="text-muted">Taille recommandee : 1200x630px</small>
            </div>

            <hr>
            <h6 class="text-muted mb-3">Code personnalise</h6>

            <div class="mb-3">
                <label for="custom_head" class="form-label">Code personnalise (head)</label>
                <textarea name="custom_head" id="custom_head" class="form-control font-monospace" rows="5" style="font-size:.85rem;">{{ old('custom_head', $seo->custom_head ?? '') }}</textarea>
                <small class="text-muted">Scripts ou balises a inserer dans la section &lt;head&gt;</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-vp">
                    <i class="bi bi-check-circle me-1"></i> Enregistrer
                </button>
                <a href="{{ route('admin.seo.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
