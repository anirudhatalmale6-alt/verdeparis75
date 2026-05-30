@extends('layouts.public')

@section('title', 'Nos Partenaires - ' . Setting::get('site_name', 'VERDE PARIS 75'))

@section('styles')
<style>
    .partner-card{border:none;border-radius:12px;overflow:hidden;background:#fff;box-shadow:0 2px 15px rgba(0,0,0,.06);transition:transform .3s,box-shadow .3s;text-align:center;padding:30px 20px}
    .partner-card:hover{transform:translateY(-5px);box-shadow:0 10px 30px rgba(0,0,0,.1)}
    .partner-logo{height:80px;display:flex;align-items:center;justify-content:center;margin-bottom:15px}
    .partner-logo img{max-height:80px;max-width:100%;object-fit:contain;filter:grayscale(30%);transition:filter .3s}
    .partner-card:hover .partner-logo img{filter:none}
</style>
@endsection

@section('content')
    <section class="hero hero-mini" style="background-image: url('https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=1800&q=80');">
        <div class="container" style="text-align:center;">
            <h1>Nos Partenaires</h1>
            <p style="margin:auto;">Ils nous font confiance</p>
        </div>
    </section>

    <section>
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
                            <i class="bi bi-building" style="font-size:3rem;color:#39A845;opacity:.5;"></i>
                            @endif
                        </div>
                        <h6 style="color:#0b5e25;font-weight:600;">{{ $partner->name }}</h6>
                        @if($partner->description)
                        <p style="color:#999;font-size:.8rem;margin-bottom:8px;">{{ Str::limit($partner->description, 80) }}</p>
                        @endif
                        @if($partner->website)
                        <a href="{{ $partner->website }}" target="_blank" rel="noopener noreferrer" style="font-size:.85rem;color:#0E7A32;">
                            <i class="bi bi-box-arrow-up-right" style="margin-right:5px;"></i>Visiter le site
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div style="text-align:center;padding:60px 0;">
                <i class="bi bi-people" style="font-size:3rem;color:#0E7A32;opacity:.3;"></i>
                <p style="color:#999;margin-top:15px;">Nos partenaires seront bientot listes ici.</p>
            </div>
            @endif
        </div>
    </section>

    <section class="cta-section">
        <h3>Devenir partenaire ?</h3>
        <p>Rejoignez notre reseau de professionnels du paysage.</p>
        <a href="{{ route('contact') }}" class="btn btn-gold">
            <i class="bi bi-envelope" style="margin-right:8px;"></i>Nous Contacter
        </a>
    </section>
@endsection
