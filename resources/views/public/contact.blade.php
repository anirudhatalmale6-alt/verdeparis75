@extends('layouts.public')

@section('title', 'Contact - ' . Setting::get('site_name', 'VerdeParis75'))

@section('styles')
<style>
    .contact-info-card {
        background: var(--vp-green-dark);
        color: #fff;
        border-radius: 12px;
        padding: 35px 30px;
        height: 100%;
    }
    .contact-info-card h4 {
        color: var(--vp-gold);
        font-weight: 700;
        margin-bottom: 25px;
    }
    .contact-info-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
    }
    .contact-info-item .icon-box {
        width: 44px;
        height: 44px;
        min-width: 44px;
        background: rgba(255,255,255,.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: var(--vp-gold);
        font-size: 1.1rem;
    }
    .contact-info-item h6 {
        font-weight: 600;
        margin-bottom: 3px;
        font-size: .9rem;
    }
    .contact-info-item p {
        margin: 0;
        opacity: .8;
        font-size: .85rem;
    }
    .contact-info-item a {
        color: rgba(255,255,255,.8);
        text-decoration: none;
        transition: color .2s;
    }
    .contact-info-item a:hover {
        color: var(--vp-gold);
    }
    .contact-form-card {
        background: #fff;
        border-radius: 12px;
        padding: 35px 30px;
        box-shadow: 0 2px 15px rgba(0,0,0,.06);
    }
    .contact-form-card h4 {
        color: var(--vp-green-dark);
        font-weight: 700;
        margin-bottom: 25px;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--vp-green-light);
        box-shadow: 0 0 0 .2rem rgba(45,106,79,.15);
    }
    .map-container {
        border-radius: 12px;
        overflow: hidden;
        margin-top: 20px;
    }
    .map-container iframe {
        width: 100%;
        height: 200px;
        border: 0;
    }
</style>
@endsection

@section('content')
    {{-- ── Hero ── --}}
    <section class="hero-section hero-mini" style="background-image: url('{{ asset('images/contact-hero.jpg') }}');">
        <div class="container">
            <div class="hero-content text-center w-100">
                <h1>Contactez-nous</h1>
                <p>Nous sommes &agrave; votre &eacute;coute pour tous vos projets</p>
            </div>
        </div>
    </section>

    {{-- ── Contact Section ── --}}
    <section class="section-padding">
        <div class="container">
            {{-- Flash messages --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
            @endif

            <div class="row g-4">
                {{-- Contact Form --}}
                <div class="col-lg-7">
                    <div class="contact-form-card">
                        <h4><i class="bi bi-envelope me-2"></i>Envoyez-nous un message</h4>
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold" style="font-size: .85rem;">Nom complet <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Votre nom">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold" style="font-size: .85rem;">Adresse e-mail <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="votre@email.com">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-semibold" style="font-size: .85rem;">T&eacute;l&eacute;phone</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="01 23 45 67 89">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="subject" class="form-label fw-semibold" style="font-size: .85rem;">Sujet</label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject') }}" placeholder="Objet de votre message">
                                    @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label fw-semibold" style="font-size: .85rem;">Message <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required placeholder="D&eacute;crivez votre projet ou votre demande...">{{ old('message') }}</textarea>
                                    @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-vp btn-lg">
                                        <i class="bi bi-send me-2"></i>Envoyer le message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Contact Info --}}
                <div class="col-lg-5">
                    <div class="contact-info-card">
                        <h4><i class="bi bi-info-circle me-2"></i>Nos coordonn&eacute;es</h4>

                        @if(Setting::get('address'))
                        <div class="contact-info-item">
                            <div class="icon-box"><i class="bi bi-geo-alt-fill"></i></div>
                            <div>
                                <h6>Adresse</h6>
                                <p>{{ Setting::get('address') }}</p>
                            </div>
                        </div>
                        @endif

                        @if(Setting::get('phone'))
                        <div class="contact-info-item">
                            <div class="icon-box"><i class="bi bi-telephone-fill"></i></div>
                            <div>
                                <h6>T&eacute;l&eacute;phone</h6>
                                <p><a href="tel:{{ Setting::get('phone') }}">{{ Setting::get('phone') }}</a></p>
                            </div>
                        </div>
                        @endif

                        @if(Setting::get('email'))
                        <div class="contact-info-item">
                            <div class="icon-box"><i class="bi bi-envelope-fill"></i></div>
                            <div>
                                <h6>E-mail</h6>
                                <p><a href="mailto:{{ Setting::get('email') }}">{{ Setting::get('email') }}</a></p>
                            </div>
                        </div>
                        @endif

                        @if(Setting::get('hours'))
                        <div class="contact-info-item">
                            <div class="icon-box"><i class="bi bi-clock-fill"></i></div>
                            <div>
                                <h6>Horaires</h6>
                                <p>{{ Setting::get('hours') }}</p>
                            </div>
                        </div>
                        @endif

                        {{-- Map --}}
                        @if(Setting::get('map_embed'))
                        <div class="map-container">
                            {!! Setting::get('map_embed') !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
