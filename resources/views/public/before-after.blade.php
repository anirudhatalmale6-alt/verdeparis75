@extends('layouts.public')

@section('title', 'Avant / Apres - ' . Setting::get('site_name', 'VERDE PARIS 75'))

@section('content')
    <section class="hero hero-mini" style="background-image: url('https://images.unsplash.com/photo-1590496793929-36417d3117de?auto=format&fit=crop&w=1800&q=80');">
        <div class="container" style="text-align:center;">
            <h1>Avant / Apres</h1>
            <p style="margin:auto;">La transformation de vos espaces verts en images</p>
        </div>
    </section>

    <section>
        <div style="max-width:1100px;margin:auto;">
            @if($items->count())
                @foreach($items as $item)
                <div class="ba-grid" style="margin-bottom:40px;">
                    <div class="ba-item">
                        <span class="ba-label">AVANT</span>
                        <img src="{{ asset('storage/' . $item->before_image) }}" alt="Avant - {{ $item->title }}">
                    </div>
                    <div class="ba-item">
                        <span class="ba-label" style="background:#d4a853;">APRES</span>
                        <img src="{{ asset('storage/' . $item->after_image) }}" alt="Apres - {{ $item->title }}">
                    </div>
                </div>
                @if($item->title || $item->description)
                <div style="text-align:center;margin-bottom:50px;">
                    @if($item->title)
                    <h3 style="color:#0E7A32;font-weight:700;margin:0 0 5px;">{{ $item->title }}</h3>
                    @endif
                    @if($item->description)
                    <p style="color:#555;font-size:15px;">{{ $item->description }}</p>
                    @endif
                </div>
                @endif
                @endforeach
            @else
                <div style="text-align:center;padding:60px 0;">
                    <i class="bi bi-arrows-angle-expand" style="font-size:3rem;color:#0E7A32;opacity:.3;"></i>
                    <p style="color:#999;margin-top:15px;">Les transformations seront bientot disponibles.</p>
                </div>
            @endif
        </div>
    </section>

    <section class="cta-section">
        <h3>Envie d'une transformation similaire ?</h3>
        <p>Contactez-nous pour donner vie a votre projet.</p>
        <a href="{{ route('contact') }}" class="btn btn-gold">
            <i class="bi bi-envelope" style="margin-right:8px;"></i>Nous Contacter
        </a>
    </section>
@endsection
