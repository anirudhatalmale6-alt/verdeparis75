<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', Setting::get('site_name', 'VERDE PARIS 75'))</title>
    @hasSection('meta_description')
    <meta name="description" content="@yield('meta_description')">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Arial,Helvetica,sans-serif;color:#1f2937;background:#f5f7f5}
        a{text-decoration:none}

        /* ── Header ── */
        header{position:sticky;top:0;z-index:50;background:white;box-shadow:0 2px 16px rgba(0,0,0,.08)}
        .topbar{background:#0E7A32;color:white;text-align:center;padding:8px;font-size:14px}
        .header-nav{max-width:1200px;margin:auto;display:flex;align-items:center;justify-content:space-between;padding:16px 24px}
        .logo{font-weight:900;color:#0E7A32;font-size:24px;line-height:1;text-decoration:none}
        .logo span{display:block;color:#2D2D2D;font-size:11px;font-weight:600;margin-top:4px;letter-spacing:1px}
        .main-nav{display:flex;align-items:center;gap:0}
        .main-nav a{margin-left:18px;color:#2D2D2D;font-weight:700;font-size:14px;transition:color .2s}
        .main-nav a:hover,.main-nav a.active{color:#0E7A32}
        .nav-toggle{display:none;background:none;border:2px solid #0E7A32;color:#0E7A32;padding:6px 10px;border-radius:6px;font-size:1.3rem;cursor:pointer}

        /* ── Hero ── */
        .hero{min-height:680px;background-size:cover;background-position:center;display:flex;align-items:center;color:white;position:relative}
        .hero::before{content:'';position:absolute;inset:0;background:linear-gradient(rgba(0,0,0,.58),rgba(0,0,0,.58))}
        .container{max-width:1200px;margin:auto;padding:70px 24px;width:100%;position:relative;z-index:2}
        .hero h1{font-size:72px;margin:0 0 12px;font-weight:900}
        .hero .hero-sub{font-size:34px;margin:0 0 18px;color:#d7ffd8;font-weight:600}
        .hero p{font-size:20px;max-width:720px;line-height:1.6}
        .hero-btns{display:flex;gap:14px;flex-wrap:wrap;margin-top:30px}
        .btn{display:inline-block;padding:15px 24px;border-radius:50px;font-weight:900;font-size:16px;border:none;cursor:pointer;transition:transform .2s,opacity .2s}
        .btn:hover{transform:translateY(-2px);opacity:.9}
        .btn-green{background:#0E7A32;color:white}
        .btn-white{background:white;color:#0E7A32}
        .btn-gold{background:#d4a853;color:#0b5e25}
        .btn-outline{border:2px solid #0E7A32;color:#0E7A32;background:transparent;padding:13px 24px}
        .btn-outline:hover{background:#0E7A32;color:white}
        .btn-sm{padding:10px 20px;font-size:14px}

        /* ── Hero Mini (subpages) ── */
        .hero-mini{min-height:350px}
        .hero-mini h1{font-size:48px}
        .hero-mini p{font-size:18px}

        /* ── Sections ── */
        section{padding:80px 24px}
        .section-title{text-align:center;margin-bottom:45px}
        .section-title h2{font-size:42px;margin:0;color:#0E7A32;font-weight:900}
        .section-title p{font-size:18px;color:#555;margin-top:8px}
        .bg-white{background:white}
        .bg-green{background:#0E7A32;color:white}
        .bg-dark{background:#111827;color:white}

        /* ── About ── */
        .about-grid{max-width:1200px;margin:auto;display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:center}
        .about-grid img{width:100%;border-radius:22px;box-shadow:0 12px 28px rgba(0,0,0,.12)}
        .about-grid h2{font-size:42px;color:#0E7A32;margin:0 0 15px;font-weight:900}
        .about-grid p{font-size:18px;line-height:1.8;color:#555}
        .about-grid .btn{margin-top:20px}

        /* ── Cards Grid ── */
        .grid{max-width:1200px;margin:auto;display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
        .card{background:white;border-radius:18px;overflow:hidden;box-shadow:0 10px 28px rgba(0,0,0,.08);transition:transform .3s,box-shadow .3s}
        .card:hover{transform:translateY(-6px);box-shadow:0 16px 40px rgba(0,0,0,.12)}
        .card img{width:100%;height:210px;object-fit:cover}
        .card-content{padding:24px}
        .card h3{margin:0 0 10px;color:#0E7A32;font-size:24px;font-weight:700}
        .card p{color:#555;line-height:1.6;font-size:15px}
        .card .btn{margin-top:15px}

        /* ── Service card (icon-based) ── */
        .card-icon{text-align:center;padding:30px 24px}
        .card-icon .icon{font-size:2.5rem;color:#0E7A32;margin-bottom:15px}
        .card-icon h3{margin:0 0 10px}

        /* ── Stats ── */
        .stats-grid{max-width:1200px;margin:auto;display:grid;grid-template-columns:repeat(4,1fr);gap:24px;text-align:center}
        .stat{background:rgba(255,255,255,.12);padding:30px;border-radius:18px}
        .stat strong{display:block;font-size:42px;font-weight:900}
        .stat span{font-size:15px;opacity:.85;margin-top:5px;display:block}

        /* ── Before/After ── */
        .ba-grid{max-width:1050px;margin:auto;display:grid;grid-template-columns:1fr 1fr;gap:20px}
        .ba-item{position:relative;border-radius:18px;overflow:hidden;box-shadow:0 10px 26px rgba(0,0,0,.12)}
        .ba-item img{width:100%;height:330px;object-fit:cover;display:block}
        .ba-label{position:absolute;top:15px;left:15px;background:#0E7A32;color:white;padding:8px 14px;border-radius:50px;font-weight:900;font-size:14px}

        /* ── Image overlay cards ── */
        .img-overlay{position:relative;overflow:hidden;border-radius:18px}
        .img-overlay img{width:100%;height:280px;object-fit:cover;transition:transform .5s}
        .img-overlay:hover img{transform:scale(1.05)}
        .img-overlay .overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(11,22,16,.85) 0%,transparent 60%);display:flex;flex-direction:column;justify-content:flex-end;padding:24px;color:#fff}
        .img-overlay .overlay h5{font-weight:700;font-size:1.2rem;margin:0 0 5px}
        .img-overlay .overlay p{font-size:.9rem;opacity:.85;margin:0}
        .badge-vp{background:#0E7A32;color:white;padding:6px 14px;border-radius:50px;font-size:.75rem;font-weight:700;display:inline-block;margin-bottom:8px}

        /* ── Partners ── */
        .partners-grid{max-width:1200px;margin:auto;display:grid;grid-template-columns:repeat(5,1fr);gap:16px}
        .partner{background:white;border-radius:14px;padding:30px;text-align:center;font-weight:900;color:#0E7A32;box-shadow:0 8px 20px rgba(0,0,0,.07);transition:transform .3s}
        .partner:hover{transform:translateY(-3px)}
        .partner img{max-height:70px;width:auto;filter:grayscale(30%);transition:filter .3s}
        .partner:hover img{filter:none}

        /* ── Contact (dark section) ── */
        .contact-wrap{max-width:1100px;margin:auto;display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:start}
        .contact-wrap h2{color:#39A845;font-size:36px;margin:0 0 15px;font-weight:900}
        .contact-wrap p{font-size:16px;line-height:1.8;color:rgba(255,255,255,.8)}
        .contact-wrap form input,
        .contact-wrap form textarea{width:100%;padding:15px;border:0;border-radius:10px;margin-bottom:12px;font-size:15px;font-family:inherit}
        .contact-wrap form button{border:0;background:#39A845;color:white;padding:15px 26px;border-radius:50px;font-weight:900;cursor:pointer;font-size:16px;transition:background .3s}
        .contact-wrap form button:hover{background:#2d8a38}

        /* ── Contact page layout ── */
        .contact-page-grid{max-width:1200px;margin:auto;display:grid;grid-template-columns:7fr 5fr;gap:30px;align-items:start}
        .contact-form-card{background:white;border-radius:18px;padding:30px;box-shadow:0 10px 28px rgba(0,0,0,.08)}
        .contact-form-card h3{color:#0E7A32;font-size:24px;margin:0 0 20px;font-weight:700}
        .contact-form-card label{display:block;font-weight:700;font-size:14px;margin-bottom:6px;color:#1f2937}
        .contact-form-card label .req{color:#dc3545}
        .contact-form-card input,
        .contact-form-card textarea{width:100%;padding:12px 15px;border:1px solid #dee2e6;border-radius:10px;margin-bottom:15px;font-size:15px;font-family:inherit}
        .contact-form-card input:focus,
        .contact-form-card textarea:focus{outline:none;border-color:#0E7A32;box-shadow:0 0 0 3px rgba(14,122,50,.1)}
        .contact-info-card{background:#0b5e25;color:white;border-radius:18px;padding:30px;box-shadow:0 10px 28px rgba(0,0,0,.12)}
        .contact-info-card h3{color:#d4a853;font-size:22px;margin:0 0 25px;font-weight:700}
        .contact-info-card .info-item{display:flex;gap:15px;margin-bottom:20px;align-items:flex-start}
        .contact-info-card .info-icon{width:42px;height:42px;background:rgba(255,255,255,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .contact-info-card .info-icon i{color:#d4a853;font-size:1.1rem}
        .contact-info-card .info-label{font-weight:700;font-size:15px;margin-bottom:2px}
        .contact-info-card .info-value{font-size:14px;opacity:.85}
        .contact-info-card .info-value a{color:rgba(255,255,255,.85);text-decoration:none}
        .contact-info-card .info-value a:hover{color:#d4a853}
        .map-container{margin-top:20px;border-radius:12px;overflow:hidden;height:200px}
        .map-container iframe{width:100%;height:100%;border:0}

        /* ── CTA ── */
        .cta-section{background:linear-gradient(135deg,#0b5e25,#0E7A32);color:white;padding:70px 24px;text-align:center}
        .cta-section h3{font-size:36px;font-weight:900;margin:0 0 15px}
        .cta-section p{font-size:18px;opacity:.9;margin:0 auto 30px;max-width:600px}

        /* ── Testimonials ── */
        .testimonial-card{background:white;border-radius:18px;padding:40px;text-align:center;box-shadow:0 10px 28px rgba(0,0,0,.08);max-width:800px;margin:auto}
        .testimonial-card .stars{color:#d4a853;font-size:1.2rem;margin-bottom:15px}
        .testimonial-card blockquote{font-size:17px;line-height:1.7;color:#1f2937;margin:0 0 20px;font-style:italic}
        .testimonial-card .author{font-weight:700;color:#0E7A32}
        .testimonial-card .location{font-size:14px;color:#999}
        .carousel-btn{background:rgba(0,0,0,.15);border:none;width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;position:absolute;top:50%;transform:translateY(-50%)}
        .carousel-btn:hover{background:rgba(0,0,0,.25)}
        .carousel-btn.prev{left:-50px}
        .carousel-btn.next{right:-50px}
        .carousel-btn i{color:#0E7A32;font-size:1.2rem}

        /* ── Footer ── */
        footer{background:#0b1610;color:white;padding:50px 24px;text-align:center}
        footer h2{color:#39A845;font-size:28px;margin:0 0 10px;font-weight:900}
        footer p{font-size:15px;color:rgba(255,255,255,.7);line-height:1.8;margin:5px 0}
        footer a{color:rgba(255,255,255,.7);text-decoration:none;transition:color .2s}
        footer a:hover{color:#39A845}
        footer .legal-links{margin-top:15px}
        footer .legal-links a{margin:0 8px}
        footer .copyright{margin-top:15px;font-size:13px;color:rgba(255,255,255,.45)}
        footer .social-links{margin-top:15px;display:flex;justify-content:center;gap:15px}
        footer .social-links a{font-size:1.2rem;color:rgba(255,255,255,.6)}
        footer .social-links a:hover{color:#39A845}

        /* ── Alerts ── */
        .alert{padding:15px 20px;border-radius:10px;margin-bottom:20px;font-size:15px}
        .alert-success{background:#d1f2d9;color:#0b5e25;border:1px solid #a3e4b3}
        .alert-danger{background:#f8d7da;color:#842029;border:1px solid #f1aeb5}
        .alert-close{float:right;background:none;border:none;font-size:18px;cursor:pointer;opacity:.5}

        /* ── Page spacer ── */
        .page-spacer{height:90px}

        /* ── Misc ── */
        .text-center{text-align:center}
        .mt-4{margin-top:30px}

        /* ── Responsive ── */
        @media(max-width:991px){
            .hero h1{font-size:48px}
            .hero .hero-sub{font-size:24px}
            .hero p{font-size:16px}
            .hero{min-height:500px}
            .hero-mini{min-height:280px}
            .hero-mini h1{font-size:36px}
            .section-title h2{font-size:32px}
            .about-grid h2{font-size:32px}
            .stats-grid{grid-template-columns:repeat(2,1fr)}
            .partners-grid{grid-template-columns:repeat(3,1fr)}
            .contact-page-grid{grid-template-columns:1fr}
        }
        @media(max-width:850px){
            .main-nav{display:none;position:absolute;top:100%;left:0;right:0;background:white;flex-direction:column;padding:15px 24px;box-shadow:0 8px 20px rgba(0,0,0,.1)}
            .main-nav.open{display:flex}
            .main-nav a{margin:8px 0;font-size:16px}
            .nav-toggle{display:block}
            .hero h1{font-size:42px}
            .hero .hero-sub{font-size:24px}
            .grid{grid-template-columns:1fr}
            .about-grid{grid-template-columns:1fr}
            .stats-grid{grid-template-columns:1fr 1fr}
            .ba-grid{grid-template-columns:1fr}
            .ba-item img{height:250px}
            .partners-grid{grid-template-columns:1fr 1fr}
            .contact-wrap{grid-template-columns:1fr}
            .container{padding:55px 22px}
        }
        @media(max-width:480px){
            .hero h1{font-size:32px}
            .hero .hero-sub{font-size:20px}
            .hero{min-height:400px}
            .section-title h2{font-size:26px}
            .stat strong{font-size:30px}
            .topbar{font-size:12px}
            .partners-grid{grid-template-columns:1fr}
        }
    </style>
    @yield('styles')
</head>
<body>
    {{-- ── Header ── --}}
    <header>
        <div class="topbar">{{ Setting::get('site_name', 'VERDE PARIS 75') }} &mdash; {{ Setting::get('site_tagline', 'Etude et travaux Batiment, VRD & Espaces verts') }}</div>
        <div class="header-nav">
            <a href="{{ route('home') }}" class="logo">
                {{ Setting::get('site_name', 'VERDE PARIS 75') }}
                <span>BATIMENT &bull; VRD &bull; ESPACES VERTS</span>
            </a>
            <button class="nav-toggle" onclick="document.querySelector('.main-nav').classList.toggle('open')">
                <i class="bi bi-list"></i>
            </button>
            <nav class="main-nav">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
                <a href="{{ route('services') }}" class="{{ request()->routeIs('services*') ? 'active' : '' }}">Services</a>
                <a href="{{ route('projects') }}" class="{{ request()->routeIs('projects*') ? 'active' : '' }}">Realisations</a>
                <a href="{{ route('before-after') }}" class="{{ request()->routeIs('before-after') ? 'active' : '' }}">Avant/Apres</a>
                <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active' : '' }}">Galerie</a>
                <a href="{{ route('videos') }}" class="{{ request()->routeIs('videos') ? 'active' : '' }}">Videos</a>
                <a href="{{ route('partners') }}" class="{{ request()->routeIs('partners') ? 'active' : '' }}">Partenaires</a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
            </nav>
        </div>
    </header>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
    <div style="max-width:1200px;margin:20px auto;padding:0 24px;">
        <div class="alert alert-success">
            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
            {{ session('success') }}
        </div>
    </div>
    @endif
    @if(session('error'))
    <div style="max-width:1200px;margin:20px auto;padding:0 24px;">
        <div class="alert alert-danger">
            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
            {{ session('error') }}
        </div>
    </div>
    @endif
    @if($errors->any())
    <div style="max-width:1200px;margin:20px auto;padding:0 24px;">
        <div class="alert alert-danger">
            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
            <ul style="margin:0;padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- ── Main Content ── --}}
    <main>
        @yield('content')
    </main>

    {{-- ── Footer ── --}}
    <footer>
        <h2>{{ Setting::get('site_name', 'VERDE PARIS 75') }}</h2>
        <p>{{ Setting::get('footer_text', Setting::get('site_tagline', 'Etude et Travaux Batiment, VRD, Assainissement et Espaces Verts')) }}</p>
        @if(Setting::get('facebook') || Setting::get('instagram') || Setting::get('linkedin'))
        <div class="social-links">
            @if(Setting::get('facebook'))<a href="{{ Setting::get('facebook') }}" target="_blank"><i class="bi bi-facebook"></i></a>@endif
            @if(Setting::get('instagram'))<a href="{{ Setting::get('instagram') }}" target="_blank"><i class="bi bi-instagram"></i></a>@endif
            @if(Setting::get('linkedin'))<a href="{{ Setting::get('linkedin') }}" target="_blank"><i class="bi bi-linkedin"></i></a>@endif
        </div>
        @endif
        <div class="legal-links">
            <a href="{{ url('/page/mentions-legales') }}">Mentions legales</a> &bull;
            <a href="{{ url('/page/politique-confidentialite') }}">Politique de confidentialite</a> &bull;
            <a href="{{ url('/page/conditions-utilisation') }}">CGU</a>
        </div>
        <p class="copyright">{{ Setting::get('footer_copyright', '© ' . date('Y') . ' VERDE PARIS 75 — Tous droits reserves') }}</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
