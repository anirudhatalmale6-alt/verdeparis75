@extends('layouts.public')

@section('title', 'Contact - ' . Setting::get('site_name', 'VERDE PARIS 75'))

@section('content')
    <section class="hero hero-mini" style="background-image: url('https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1800&q=80');">
        <div class="container" style="text-align:center;">
            <h1>Contactez-nous</h1>
            <p style="margin:auto;">Nous sommes a votre ecoute pour tous vos projets</p>
        </div>
    </section>

    <section>
        <div class="contact-page-grid" style="max-width:1200px;margin:auto;">
            <div class="contact-form-card">
                <h3><i class="bi bi-envelope" style="margin-right:10px;"></i>Envoyez-nous un message</h3>
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;">
                        <div>
                            <label>Nom complet <span class="req">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Votre nom">
                        </div>
                        <div>
                            <label>Adresse e-mail <span class="req">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="votre@email.com">
                        </div>
                        <div>
                            <label>Telephone</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="01 23 45 67 89">
                        </div>
                        <div>
                            <label>Sujet</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Objet de votre message">
                        </div>
                    </div>
                    <label>Message <span class="req">*</span></label>
                    <textarea name="message" rows="5" required placeholder="Decrivez votre projet ou votre demande...">{{ old('message') }}</textarea>
                    <button type="submit" class="btn btn-green" style="margin-top:5px;">
                        <i class="bi bi-send" style="margin-right:8px;"></i>Envoyer le message
                    </button>
                </form>
            </div>

            <div class="contact-info-card">
                <h3><i class="bi bi-info-circle" style="margin-right:10px;"></i>Nos coordonnees</h3>

                @if(Setting::get('address'))
                <div class="info-item">
                    <div class="info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <div>
                        <div class="info-label">Adresse</div>
                        <div class="info-value">{{ Setting::get('address') }}</div>
                    </div>
                </div>
                @endif

                @if(Setting::get('phone'))
                <div class="info-item">
                    <div class="info-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div>
                        <div class="info-label">Telephone</div>
                        <div class="info-value"><a href="tel:{{ Setting::get('phone') }}">{{ Setting::get('phone') }}</a></div>
                    </div>
                </div>
                @endif

                @if(Setting::get('email'))
                <div class="info-item">
                    <div class="info-icon"><i class="bi bi-envelope-fill"></i></div>
                    <div>
                        <div class="info-label">E-mail</div>
                        <div class="info-value"><a href="mailto:{{ Setting::get('email') }}">{{ Setting::get('email') }}</a></div>
                    </div>
                </div>
                @endif

                @if(Setting::get('map_embed'))
                <div class="map-container">
                    {!! Setting::get('map_embed') !!}
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection
