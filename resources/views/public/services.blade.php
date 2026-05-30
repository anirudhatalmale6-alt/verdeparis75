@extends('layouts.public')

@section('title', 'Nos Services - ' . Setting::get('site_name', 'VERDE PARIS 75'))

@section('content')
    <section class="hero hero-mini" style="background-image: url('https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&w=1800&q=80');">
        <div class="container" style="text-align:center;">
            <h1>Nos Services</h1>
            <p style="margin:auto;">Des solutions completes pour vos projets VRD et espaces verts</p>
        </div>
    </section>

    <section>
        <div class="container">
            @if($services->count())
            <div class="row g-4">
                @foreach($services as $service)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('services.show', $service->slug) }}" style="text-decoration:none;color:inherit;">
                        <div class="card h-100">
                            @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" style="height:210px;object-fit:cover;">
                            @endif
                            <div class="card-content">
                                <div style="display:flex;align-items:center;margin-bottom:12px;">
                                    @if($service->icon)
                                    <i class="bi bi-{{ $service->icon }}" style="font-size:1.5rem;color:#0E7A32;margin-right:10px;"></i>
                                    @endif
                                    <h3 style="margin:0;">{{ $service->title }}</h3>
                                </div>
                                <p>{{ Str::limit($service->short_description ?? $service->description, 150) }}</p>
                                <span class="btn btn-outline btn-sm">En savoir plus <i class="bi bi-arrow-right" style="margin-left:5px;"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @else
            <div style="text-align:center;padding:60px 0;">
                <i class="bi bi-gear" style="font-size:3rem;color:#0E7A32;opacity:.3;"></i>
                <p style="color:#999;margin-top:15px;">Nos services seront bientot disponibles.</p>
            </div>
            @endif
        </div>
    </section>

    <section class="cta-section">
        <h3>Besoin d'un service sur mesure ?</h3>
        <p>Contactez-nous pour discuter de votre projet.</p>
        <a href="{{ route('contact') }}" class="btn btn-gold">
            <i class="bi bi-envelope" style="margin-right:8px;"></i>Demander un Devis
        </a>
    </section>
@endsection
