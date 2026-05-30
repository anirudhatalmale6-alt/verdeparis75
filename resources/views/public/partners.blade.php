@extends('layouts.public')

@section('title', 'Nos Partenaires - ' . Setting::get('site_name', 'VerdeParis75'))

@section('styles')
<style>
    .partner-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 15px rgba(0,0,0,.06);
        transition: transform .3s, box-shadow .3s;
        text-align: center;
        padding: 30px 20px;
    }
    .partner-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,.1);
    }
    .partner-logo {
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }
    .partner-logo img {
        max-height: 80px;
        max-width: 100%;
        object-fit: contain;
        filter: grayscale(30%);
        transition: filter .3s;
    }
    .partner-card:hover .partner-logo img {
        filter: none;
    }
</style>
@endsection

@section('content')
    {{-- ── Hero ── --}}
    <section class="hero-section hero-mini" style="background-image: url('{{ asset('images/partners-hero.jpg') }}');">
        <div class="container">
            <div class="hero-content text-center w-100">
                <h1>Nos Partenaires</h1>
                <p>Ils nous font confiance</p>
            </div>
        </div>
    </section>

    {{-- ── Partners Grid ── --}}
    <section class="section-padding">
        <div class="container">
            @if($partners->count())
            <div class="row g-4">
                @foreach($partners as $partner)
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="partner-card h-100">
                        <div class="partner-logo">
                            @if($partner->logo)
                            <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}">
                            @else
                            <i class="bi bi-building" style="font-size: 3rem; color: var(--vp-green-light); opacity: .5;"></i>
                            @endif
                        </div>
                        <h6 style="color: var(--vp-green-dark); font-weight: 600;">{{ $partner->name }}</h6>
                        @if($partner->description)
                        <p class="text-muted mb-2" style="font-size: .8rem;">{{ Str::limit($partner->description, 80) }}</p>
                        @endif
                        @if($partner->website)
                        <a href="{{ $partner->website }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none" style="font-size: .85rem; color: var(--vp-green);">
                            <i class="bi bi-box-arrow-up-right me-1"></i>Visiter le site
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-people" style="font-size: 3rem; color: var(--vp-green-light); opacity: .4;"></i>
                <p class="text-muted mt-3">Nos partenaires seront bient&ocirc;t list&eacute;s ici.</p>
            </div>
            @endif
        </div>
    </section>

    {{-- ── CTA ── --}}
    <section class="cta-section">
        <div class="container">
            <h3>Devenir partenaire ?</h3>
            <p>Rejoignez notre r&eacute;seau de professionnels du paysage.</p>
            <a href="{{ route('contact') }}" class="btn btn-vp-gold btn-lg">
                <i class="bi bi-envelope me-2"></i>Nous Contacter
            </a>
        </div>
    </section>
@endsection
