@extends('layouts.public')

@section('title', ($project->meta_title ?? $project->title) . ' - ' . Setting::get('site_name', 'VerdeParis75'))

@if($project->meta_description)
@section('meta_description', $project->meta_description)
@endif

@section('content')
    {{-- ── Hero ── --}}
    <section class="hero-section hero-mini" style="background-image: url('{{ $project->cover_image ? asset('storage/' . $project->cover_image) : asset('images/projects-hero.jpg') }}');">
        <div class="container">
            <div class="hero-content text-center w-100">
                @if($project->category)
                <span class="badge-vp mb-3 d-inline-block">{{ $project->category }}</span>
                @endif
                <h1>{{ $project->title }}</h1>
            </div>
        </div>
    </section>

    {{-- ── Project Details ── --}}
    <section class="section-padding">
        <div class="container">
            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb" style="font-size: .85rem;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--vp-green);">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('projects') }}" class="text-decoration-none" style="color: var(--vp-green);">R&eacute;alisations</a></li>
                    <li class="breadcrumb-item active text-muted">{{ $project->title }}</li>
                </ol>
            </nav>

            <div class="row g-5">
                {{-- Main content --}}
                <div class="col-lg-8">
                    @if($project->cover_image)
                    <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->title }}" class="img-fluid rounded-3 shadow mb-4" style="width: 100%; max-height: 500px; object-fit: cover;">
                    @endif

                    <div class="content-body" style="line-height: 1.8;">
                        {!! $project->description !!}
                    </div>

                    {{-- Image Gallery --}}
                    @if($project->images->count())
                    <div class="mt-5">
                        <h4 style="color: var(--vp-green-dark); font-weight: 600;">Galerie du projet</h4>
                        <div class="row g-3 mt-2">
                            @foreach($project->images as $index => $image)
                            <div class="col-6 col-md-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal" onclick="showGalleryImage('{{ asset('storage/' . $image->image) }}', '{{ addslashes($image->caption ?? $project->title) }}')">
                                    <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->caption ?? $project->title }}" class="img-fluid rounded-2" style="width: 100%; height: 160px; object-fit: cover; cursor: pointer; transition: opacity .3s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    <div class="card card-vp p-4">
                        <h5 style="color: var(--vp-green-dark); font-weight: 600; margin-bottom: 20px;">
                            <i class="bi bi-info-circle me-2"></i>D&eacute;tails du projet
                        </h5>
                        <ul class="list-unstyled mb-0">
                            @if($project->client_name)
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-person me-3" style="color: var(--vp-green); font-size: 1.1rem; margin-top: 2px;"></i>
                                <div>
                                    <small class="text-muted d-block">Client</small>
                                    <span>{{ $project->client_name }}</span>
                                </div>
                            </li>
                            @endif
                            @if($project->location)
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-geo-alt me-3" style="color: var(--vp-green); font-size: 1.1rem; margin-top: 2px;"></i>
                                <div>
                                    <small class="text-muted d-block">Lieu</small>
                                    <span>{{ $project->location }}</span>
                                </div>
                            </li>
                            @endif
                            @if($project->project_date)
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-calendar-event me-3" style="color: var(--vp-green); font-size: 1.1rem; margin-top: 2px;"></i>
                                <div>
                                    <small class="text-muted d-block">Date</small>
                                    <span>{{ $project->project_date->translatedFormat('F Y') }}</span>
                                </div>
                            </li>
                            @endif
                            @if($project->category)
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-tag me-3" style="color: var(--vp-green); font-size: 1.1rem; margin-top: 2px;"></i>
                                <div>
                                    <small class="text-muted d-block">Cat&eacute;gorie</small>
                                    <span class="badge-vp">{{ $project->category }}</span>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('contact') }}" class="btn btn-vp w-100">
                            <i class="bi bi-envelope me-2"></i>Un projet similaire ?
                        </a>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('projects') }}" class="btn btn-vp-outline w-100">
                            <i class="bi bi-arrow-left me-2"></i>Toutes les r&eacute;alisations
                        </a>
                    </div>

                    {{-- Related projects --}}
                    @php
                        $related = \App\Models\Project::active()
                            ->where('id', '!=', $project->id)
                            ->when($project->category, fn($q) => $q->where('category', $project->category))
                            ->ordered()
                            ->take(3)
                            ->get();
                    @endphp
                    @if($related->count())
                    <div class="mt-5">
                        <h6 style="color: var(--vp-green-dark); font-weight: 600;">Projets similaires</h6>
                        @foreach($related as $rel)
                        <a href="{{ route('projects.show', $rel->slug) }}" class="text-decoration-none d-flex align-items-center mb-3 p-2 rounded-2" style="background: var(--vp-bg); transition: background .2s;" onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='var(--vp-bg)'">
                            @if($rel->cover_image)
                            <img src="{{ asset('storage/' . $rel->cover_image) }}" alt="{{ $rel->title }}" class="rounded-2 me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            @endif
                            <div>
                                <h6 class="mb-0" style="font-size: .85rem; color: var(--vp-green-dark);">{{ $rel->title }}</h6>
                                @if($rel->category)
                                <small class="text-muted">{{ $rel->category }}</small>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ── Gallery Lightbox Modal ── --}}
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark border-0">
                <div class="modal-header border-0">
                    <h6 class="modal-title text-white" id="galleryModalLabel"></h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body p-0 text-center">
                    <img id="galleryModalImage" src="" alt="" class="img-fluid" style="max-height: 75vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function showGalleryImage(src, caption) {
        document.getElementById('galleryModalImage').src = src;
        document.getElementById('galleryModalImage').alt = caption;
        document.getElementById('galleryModalLabel').textContent = caption;
    }
</script>
@endsection
