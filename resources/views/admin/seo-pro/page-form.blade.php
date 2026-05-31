@extends('layouts.admin')
@section('title', $page->exists ? 'Modifier la page SEO' : 'Nouvelle page SEO')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $page->exists ? route('admin.seo-pro.pages.update', $page) : route('admin.seo-pro.pages.store') }}">
            @csrf
            @if($page->exists) @method('PUT') @endif

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $page->title) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="slug" class="form-label">Slug URL <span class="text-danger">*</span></label>
                    <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $page->slug) }}" required placeholder="terrassement-paris">
                </div>
            </div>

            <div class="mb-3">
                <label for="seo_title" class="form-label">Titre SEO (balise title)</label>
                <input type="text" name="seo_title" id="seo_title" class="form-control" value="{{ old('seo_title', $page->seo_title) }}" placeholder="Entreprise de terrassement a Paris | VERDE PARIS 75">
                <small class="text-muted">Apparait dans l'onglet du navigateur et les resultats Google</small>
            </div>

            <div class="mb-3">
                <label for="meta_description" class="form-label">Meta description</label>
                <textarea name="meta_description" id="meta_description" class="form-control" rows="3" maxlength="500">{{ old('meta_description', $page->meta_description) }}</textarea>
                <small class="text-muted">Description affichee dans les resultats Google (max 160 caracteres recommande)</small>
            </div>

            <div class="mb-3">
                <label for="h1" class="form-label">Titre H1</label>
                <input type="text" name="h1" id="h1" class="form-control" value="{{ old('h1', $page->h1) }}" placeholder="Titre principal de la page">
            </div>

            <div class="mb-3">
                <label for="sections" class="form-label">Sections de contenu (JSON)</label>
                <textarea name="sections" id="sections" class="form-control" rows="10" placeholder='[{"title":"Titre H2","content":"Texte du paragraphe"}]'>{{ old('sections', json_encode($page->sections, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)) }}</textarea>
                <small class="text-muted">Format: [{"title":"Titre","content":"Texte"}, ...]</small>
            </div>

            <div class="mb-3">
                <label for="keywords" class="form-label">Mots-cles (separes par des virgules)</label>
                <input type="text" name="keywords" id="keywords" class="form-control" value="{{ old('keywords', implode(', ', $page->keywords ?? [])) }}" placeholder="terrassement Paris, VRD Essonne">
            </div>

            <div class="mb-3">
                <label for="canonical_url" class="form-label">URL canonique (optionnel)</label>
                <input type="text" name="canonical_url" id="canonical_url" class="form-control" value="{{ old('canonical_url', $page->canonical_url) }}">
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="sort_order" class="form-label">Ordre</label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $page->sort_order ?? 0) }}" min="0">
                </div>
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_indexable" id="is_indexable" class="form-check-input" value="1" {{ old('is_indexable', $page->is_indexable ?? true) ? 'checked' : '' }}>
                        <label for="is_indexable" class="form-check-label">Indexable par Google</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Active</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-vp">
                    <i class="bi bi-check-circle me-1"></i> {{ $page->exists ? 'Mettre a jour' : 'Creer' }}
                </button>
                <a href="{{ route('admin.seo-pro.pages.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
