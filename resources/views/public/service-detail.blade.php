@extends('layouts.public')

@section('title', ($service->meta_title ?? $service->title) . ' - ' . Setting::get('site_name', 'VERDE PARIS 75'))

@if($service->meta_description)
@section('meta_description', $service->meta_description)
@endif

@section('content')
    <section class="hero hero-mini" style="background-image: url('{{ $service->image ? asset('storage/' . $service->image) : 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&w=1800&q=80' }}');">
        <div class="container" style="text-align:center;">
            @if($service->icon)
            <i class="bi bi-{{ $service->icon }}" style="font-size:3rem;color:#d4a853;display:block;margin-bottom:15px;"></i>
            @endif
            <h1>{{ $service->title }}</h1>
            @if($service->short_description)
            <p style="margin:auto;">{{ $service->short_description }}</p>
            @endif
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb" style="font-size:.85rem;">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color:#0E7A32;">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('services') }}" style="color:#0E7A32;">Services</a></li>
                            <li class="breadcrumb-item active text-muted">{{ $service->title }}</li>
                        </ol>
                    </nav>

                    @if($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" class="img-fluid rounded-3 shadow mb-4" style="width:100%;max-height:450px;object-fit:cover;">
                    @endif

                    <div style="line-height:1.8;color:#1f2937;">
                        {!! $service->description !!}
                    </div>

                    <div class="mt-5 d-flex flex-wrap gap-3">
                        <a href="{{ route('services') }}" class="btn btn-outline">
                            <i class="bi bi-arrow-left" style="margin-right:5px;"></i> Tous les services
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-green">
                            <i class="bi bi-envelope" style="margin-right:5px;"></i> Demander un devis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
