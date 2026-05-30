@extends('layouts.public')

@section('title', 'Nos Services - ' . Setting::get('site_name', 'VerdeParis75'))

@section('content')
    {{-- ── Hero ── --}}
    <section class="hero-section hero-mini" style="background-image: url('{{ asset('images/services-hero.jpg') }}');">
        <div class="container">
            <div class="hero-content text-center w-100">
                <h1>Nos Services</h1>
                <p>Des solutions compl&egrave;tes pour vos espaces verts</p>
            </div>
        </div>
    </section>

    {{-- ── Services Grid ── --}}
    <section class="section-padding">
        <div class="container">
            @if($services->count())
            <div class="row g-4">
                @foreach($services as $service)
                <div class="col-lg-4 col-md-6">
                    <div class="card card-vp h-100">
                        @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" alt="{{ $service->title }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                @if($service->icon)
                                <i class="bi bi-{{ $service->icon }} me-2" style="font-size: 1.5rem; color: var(--vp-green);"></i>
                                @endif
                                <h5 class="card-title mb-0">{{ $service->title }}</h5>
                            </div>
                            <p class="card-text flex-grow-1">{{ Str::limit($service->short_description ?? $service->description, 150) }}</p>
                            <a href="{{ route('services.show', $service->slug) }}" class="btn btn-vp-outline btn-sm mt-3 align-self-start">
                                En savoir plus <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-gear" style="font-size: 3rem; color: var(--vp-green-light); opacity: .4;"></i>
                <p class="text-muted mt-3">Nos services seront bient&ocirc;t disponibles.</p>
            </div>
            @endif
        </div>
    </section>

    {{-- ── CTA ── --}}
    <section class="cta-section">
        <div class="container">
            <h3>Besoin d'un service sur mesure ?</h3>
            <p>Contactez-nous pour discuter de votre projet.</p>
            <a href="{{ route('contact') }}" class="btn btn-vp-gold btn-lg">
                <i class="bi bi-envelope me-2"></i>Demander un Devis
            </a>
        </div>
    </section>
@endsection
