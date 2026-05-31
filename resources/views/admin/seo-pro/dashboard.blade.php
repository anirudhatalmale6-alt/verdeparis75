@extends('layouts.admin')
@section('title', 'SEO Pro')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <h5 class="mb-1">SEO Pro - VERDE PARIS 75</h5>
        <p class="text-muted mb-0">Pages SEO locales, sitemap XML, robots.txt, redirections 301/302 et schema JSON-LD.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-file-earmark-text"></i></div>
            <div class="stat-value">{{ $stats['pages'] }}</div>
            <div class="stat-label">Pages SEO</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
            <div class="stat-value">{{ $stats['active_pages'] }}</div>
            <div class="stat-label">Pages actives</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-exclamation-triangle"></i></div>
            <div class="stat-value">{{ $stats['missing_meta'] }}</div>
            <div class="stat-label">Meta manquantes</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-arrow-repeat"></i></div>
            <div class="stat-value">{{ $stats['redirects'] }}</div>
            <div class="stat-label">Redirections</div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 flex-wrap">
    <a href="{{ route('admin.seo-pro.pages.index') }}" class="btn btn-vp">
        <i class="bi bi-file-earmark-text me-1"></i> Gerer les pages SEO
    </a>
    <a href="{{ route('admin.seo-pro.redirects.index') }}" class="btn btn-vp-outline">
        <i class="bi bi-arrow-repeat me-1"></i> Redirections
    </a>
    <a href="/sitemap.xml" class="btn btn-vp-outline" target="_blank">
        <i class="bi bi-diagram-3 me-1"></i> Voir sitemap.xml
    </a>
    <a href="/robots.txt" class="btn btn-vp-outline" target="_blank">
        <i class="bi bi-robot me-1"></i> Voir robots.txt
    </a>
</div>
@endsection
