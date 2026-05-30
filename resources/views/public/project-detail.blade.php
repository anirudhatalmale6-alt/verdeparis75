@extends('layouts.public')

@section('title', ($project->meta_title ?? $project->title) . ' - ' . Setting::get('site_name', 'VERDE PARIS 75'))

@if($project->meta_description)
@section('meta_description', $project->meta_description)
@endif

@section('content')
    <section class="hero hero-mini" style="background-image: url('{{ $project->cover_image ? asset('storage/' . $project->cover_image) : 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1800&q=80' }}');">
        <div class="container" style="text-align:center;">
            @if($project->category)
            <span class="badge-vp" style="margin-bottom:15px;display:inline-block;">{{ $project->category }}</span>
            @endif
            <h1>{{ $project->title }}</h1>
        </div>
    </section>

    <section>
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb" style="font-size:.85rem;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color:#0E7A32;">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('projects') }}" style="color:#0E7A32;">Realisations</a></li>
                    <li class="breadcrumb-item active text-muted">{{ $project->title }}</li>
                </ol>
            </nav>

            <div class="row g-5">
                <div class="col-lg-8">
                    @if($project->cover_image)
                    <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->title }}" class="img-fluid rounded-3 shadow mb-4" style="width:100%;max-height:500px;object-fit:cover;">
                    @endif

                    <div style="line-height:1.8;">
                        {!! $project->description !!}
                    </div>

                    @if($project->images->count())
                    <div class="mt-5">
                        <h4 style="color:#0b5e25;font-weight:600;">Galerie du projet</h4>
                        <div class="row g-3 mt-2">
                            @foreach($project->images as $image)
                            <div class="col-6 col-md-4">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#galleryModal" onclick="showGalleryImage('{{ asset('storage/' . $image->image) }}', '{{ addslashes($image->caption ?? $project->title) }}')">
                                    <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->caption ?? $project->title }}" class="img-fluid rounded-2" style="width:100%;height:160px;object-fit:cover;cursor:pointer;transition:opacity .3s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="card" style="padding:24px;">
                        <h5 style="color:#0b5e25;font-weight:600;margin-bottom:20px;">
                            <i class="bi bi-info-circle" style="margin-right:8px;"></i>Details du projet
                        </h5>
                        <ul class="list-unstyled mb-0">
                            @if($project->client_name)
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-person" style="color:#0E7A32;font-size:1.1rem;margin-right:12px;margin-top:2px;"></i>
                                <div>
                                    <small class="text-muted d-block">Client</small>
                                    <span>{{ $project->client_name }}</span>
                                </div>
                            </li>
                            @endif
                            @if($project->location)
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-geo-alt" style="color:#0E7A32;font-size:1.1rem;margin-right:12px;margin-top:2px;"></i>
                                <div>
                                    <small class="text-muted d-block">Lieu</small>
                                    <span>{{ $project->location }}</span>
                                </div>
                            </li>
                            @endif
                            @if($project->project_date)
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-calendar-event" style="color:#0E7A32;font-size:1.1rem;margin-right:12px;margin-top:2px;"></i>
                                <div>
                                    <small class="text-muted d-block">Date</small>
                                    <span>{{ $project->project_date->translatedFormat('F Y') }}</span>
                                </div>
                            </li>
                            @endif
                            @if($project->category)
                            <li class="mb-3 d-flex align-items-start">
                                <i class="bi bi-tag" style="color:#0E7A32;font-size:1.1rem;margin-right:12px;margin-top:2px;"></i>
                                <div>
                                    <small class="text-muted d-block">Categorie</small>
                                    <span class="badge-vp">{{ $project->category }}</span>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('contact') }}" class="btn btn-green w-100">
                            <i class="bi bi-envelope" style="margin-right:8px;"></i>Un projet similaire ?
                        </a>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('projects') }}" class="btn btn-outline w-100">
                            <i class="bi bi-arrow-left" style="margin-right:8px;"></i>Toutes les realisations
                        </a>
                    </div>

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
                        <h6 style="color:#0b5e25;font-weight:600;">Projets similaires</h6>
                        @foreach($related as $rel)
                        <a href="{{ route('projects.show', $rel->slug) }}" class="d-flex align-items-center mb-3 p-2 rounded-2" style="text-decoration:none;color:inherit;background:#f5f7f5;transition:background .2s;" onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='#f5f7f5'">
                            @if($rel->cover_image)
                            <img src="{{ asset('storage/' . $rel->cover_image) }}" alt="{{ $rel->title }}" class="rounded-2 me-3" style="width:60px;height:60px;object-fit:cover;">
                            @endif
                            <div>
                                <h6 class="mb-0" style="font-size:.85rem;color:#0b5e25;">{{ $rel->title }}</h6>
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

    <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark border-0">
                <div class="modal-header border-0">
                    <h6 class="modal-title text-white" id="galleryModalLabel"></h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body p-0 text-center">
                    <img id="galleryModalImage" src="" alt="" class="img-fluid" style="max-height:75vh;object-fit:contain;">
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
