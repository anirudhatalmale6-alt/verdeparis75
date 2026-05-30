@extends('layouts.public')

@section('title', ($service->meta_title ?? $service->title) . ' - ' . Setting::get('site_name', 'VerdeParis75'))

@if($service->meta_description)
@section('meta_description', $service->meta_description)
@endif

@section('content')
    {{-- ── Hero ── --}}
    <section class="hero-section hero-mini" style="background-image: url('{{ $service->image ? asset('storage/' . $service->image) : asset('images/services-hero.jpg') }}');">
        <div class="container">
            <div class="hero-content text-center w-100">
                @if($service->icon)
                <i class="bi bi-{{ $service->icon }}" style="font-size: 3rem; color: var(--vp-gold); display: block; margin-bottom: 15px;"></i>
                @endif
                <h1>{{ $service->title }}</h1>
                @if($service->short_description)
                <p>{{ $service->short_description }}</p>
                @endif
            </div>
        </div>
    </section>

    {{-- ── Content ── --}}
    <section class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    {{-- Breadcrumb --}}
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb" style="font-size: .85rem;">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--vp-green);">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('services') }}" class="text-decoration-none" style="color: var(--vp-green);">Services</a></li>
                            <li class="breadcrumb-item active text-muted">{{ $service->title }}</li>
                        </ol>
                    </nav>

                    @if($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="img-fluid rounded-3 shadow mb-4" style="width: 100%; max-height: 450px; object-fit: cover;">
                    @endif

                    <div class="content-body" style="line-height: 1.8; color: var(--vp-text);">
                        {!! $service->description !!}
                    </div>

                    <div class="mt-5 d-flex flex-wrap gap-3">
                        <a href="{{ route('services') }}" class="btn btn-vp-outline">
                            <i class="bi bi-arrow-left me-1"></i> Tous les services
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-vp">
                            <i class="bi bi-envelope me-1"></i> Demander un devis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
