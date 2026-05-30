<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', Setting::get('site_name', 'VerdeParis75'))</title>
    @hasSection('meta_description')
    <meta name="description" content="@yield('meta_description')">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --vp-green: #0E7A32;
            --vp-green-light: #39A845;
            --vp-green-dark: #0b5e25;
            --vp-gold: #d4a853;
            --vp-gold-light: #e8c47a;
            --vp-bg: #f5f7f5;
            --vp-white: #ffffff;
            --vp-text: #1f2937;
            --vp-text-light: #6c757d;
            --vp-dark: #111827;
            --vp-footer: #0b1610;
        }

        * { box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--vp-text);
            background: var(--vp-bg);
            margin: 0;
            padding: 0;
        }

        /* ── Topbar ── */
        .vp-topbar {
            background: var(--vp-green);
            color: #fff;
            text-align: center;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: .3px;
        }

        /* ── Navbar ── */
        .navbar-vp {
            background: #fff;
            padding: 0;
            transition: box-shadow .3s;
            z-index: 1040;
            box-shadow: 0 2px 16px rgba(0,0,0,.08);
        }
        .navbar-vp.scrolled {
            box-shadow: 0 2px 20px rgba(0,0,0,.15);
        }
        .navbar-vp .navbar-brand {
            color: var(--vp-green);
            font-weight: 900;
            font-size: 1.5rem;
            letter-spacing: .5px;
            display: flex;
            flex-direction: column;
            line-height: 1;
        }
        .navbar-vp .navbar-brand:hover {
            color: var(--vp-green-dark);
        }
        .navbar-vp .brand-sub {
            font-size: .65rem;
            color: var(--vp-text);
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 4px;
        }
        .navbar-vp .nav-link {
            color: var(--vp-text) !important;
            font-size: .85rem;
            font-weight: 700;
            padding: 20px 14px !important;
            transition: color .2s;
            position: relative;
            text-transform: uppercase;
            letter-spacing: .3px;
        }
        .navbar-vp .nav-link:hover,
        .navbar-vp .nav-link.active {
            color: var(--vp-green) !important;
        }
        .navbar-vp .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 14px;
            right: 14px;
            height: 3px;
            background: var(--vp-green);
            border-radius: 3px 3px 0 0;
        }
        .navbar-vp .navbar-toggler {
            border-color: var(--vp-green);
            padding: 6px 10px;
        }
        .navbar-vp .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%230E7A32' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* ── Hero sections ── */
        .hero-section {
            min-height: 680px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            position: relative;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(rgba(0,0,0,.58), rgba(0,0,0,.58));
        }
        .hero-section .hero-content {
            position: relative;
            z-index: 2;
            color: #fff;
        }
        .hero-section h1 {
            font-size: 4.5rem;
            font-weight: 900;
            text-shadow: 0 2px 10px rgba(0,0,0,.3);
            margin-bottom: 12px;
        }
        .hero-section .hero-subtitle {
            font-size: 2.1rem;
            color: #d7ffd8;
            font-weight: 600;
            margin-bottom: 18px;
        }
        .hero-section p {
            font-size: 1.25rem;
            line-height: 1.6;
            max-width: 720px;
        }
        .hero-mini {
            min-height: 40vh;
        }
        .hero-mini h1 {
            font-size: 2.8rem;
        }

        /* ── Hero buttons ── */
        .hero-btns {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        /* ── Section styles ── */
        .section-padding {
            padding: 80px 0;
        }
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        .section-title h2 {
            font-size: 2.6rem;
            font-weight: 700;
            color: var(--vp-green);
            display: inline-block;
            position: relative;
            padding-bottom: 15px;
            margin: 0;
        }
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--vp-green);
            border-radius: 2px;
        }
        .section-title p {
            color: #555;
            font-size: 1.1rem;
            margin-top: 12px;
            max-width: 650px;
            margin-left: auto;
            margin-right: auto;
        }

        /* ── Cards ── */
        .card-vp {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            background: var(--vp-white);
            box-shadow: 0 10px 28px rgba(0,0,0,.08);
            transition: transform .3s, box-shadow .3s;
        }
        .card-vp:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 40px rgba(0,0,0,.12);
        }
        .card-vp .card-img-top {
            height: 210px;
            object-fit: cover;
        }
        .card-vp .card-body {
            padding: 24px;
        }
        .card-vp .card-title {
            font-weight: 700;
            color: var(--vp-green);
            font-size: 1.3rem;
        }
        .card-vp .card-text {
            color: var(--vp-text-light);
            font-size: .95rem;
        }

        /* ── Buttons ── */
        .btn-vp {
            background: var(--vp-green);
            color: #fff;
            border: none;
            padding: 15px 28px;
            border-radius: 50px;
            font-weight: 900;
            transition: background .3s, transform .2s;
        }
        .btn-vp:hover {
            background: var(--vp-green-light);
            color: #fff;
            transform: translateY(-2px);
        }
        .btn-vp-outline {
            border: 2px solid var(--vp-green);
            color: var(--vp-green);
            background: transparent;
            padding: 13px 28px;
            border-radius: 50px;
            font-weight: 700;
            transition: all .3s;
        }
        .btn-vp-outline:hover {
            background: var(--vp-green);
            color: #fff;
        }
        .btn-vp-white {
            background: #fff;
            color: var(--vp-green);
            border: none;
            padding: 15px 28px;
            border-radius: 50px;
            font-weight: 900;
            transition: background .3s, transform .2s;
        }
        .btn-vp-white:hover {
            background: #f0f0f0;
            color: var(--vp-green-dark);
            transform: translateY(-2px);
        }
        .btn-vp-gold {
            background: var(--vp-gold);
            color: var(--vp-green-dark);
            border: none;
            padding: 15px 32px;
            border-radius: 50px;
            font-weight: 900;
            transition: background .3s, transform .2s;
        }
        .btn-vp-gold:hover {
            background: var(--vp-gold-light);
            color: var(--vp-green-dark);
            transform: translateY(-2px);
        }

        /* ── Badges ── */
        .badge-vp {
            background: var(--vp-green);
            color: #fff;
            font-size: .75rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 50px;
        }

        /* ── Image overlays ── */
        .img-overlay-card {
            position: relative;
            overflow: hidden;
            border-radius: 18px;
        }
        .img-overlay-card img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            transition: transform .5s;
        }
        .img-overlay-card:hover img {
            transform: scale(1.05);
        }
        .img-overlay-card .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(11,22,16,.85) 0%, transparent 60%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 24px;
            color: #fff;
        }
        .img-overlay-card .overlay h5 {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 1.2rem;
        }
        .img-overlay-card .overlay p {
            font-size: .9rem;
            opacity: .85;
            margin: 0;
        }

        /* ── Stats Section ── */
        .stats-section {
            background: var(--vp-green);
            color: #fff;
            padding: 80px 0;
        }
        .stats-section .stat-box {
            background: rgba(255,255,255,.12);
            padding: 30px;
            border-radius: 18px;
            text-align: center;
        }
        .stats-section .stat-value {
            font-size: 2.6rem;
            font-weight: 900;
            display: block;
        }
        .stats-section .stat-label {
            font-size: .9rem;
            opacity: .85;
            margin-top: 5px;
        }

        /* ── CTA Section ── */
        .cta-section {
            background: linear-gradient(135deg, var(--vp-green-dark), var(--vp-green));
            color: #fff;
            padding: 70px 0;
            text-align: center;
        }
        .cta-section h3 {
            font-size: 2.2rem;
            font-weight: 900;
            margin-bottom: 15px;
        }
        .cta-section p {
            font-size: 1.1rem;
            opacity: .9;
            margin-bottom: 30px;
        }

        /* ── Before/After labels ── */
        .ba-label {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--vp-green);
            color: #fff;
            padding: 8px 14px;
            border-radius: 50px;
            font-weight: 900;
            font-size: .8rem;
            z-index: 2;
        }

        /* ── Contact Section (dark) ── */
        .contact-dark {
            background: var(--vp-dark);
            color: #fff;
            padding: 80px 0;
        }
        .contact-dark h2 {
            color: var(--vp-green-light);
            font-weight: 900;
        }
        .contact-dark input,
        .contact-dark textarea {
            width: 100%;
            padding: 15px;
            border: 0;
            border-radius: 10px;
            margin-bottom: 12px;
            font-size: .95rem;
        }

        /* ── Partners ── */
        .partner-box {
            background: #fff;
            border-radius: 14px;
            padding: 30px;
            text-align: center;
            font-weight: 900;
            color: var(--vp-green);
            box-shadow: 0 8px 20px rgba(0,0,0,.07);
            transition: transform .3s;
        }
        .partner-box:hover {
            transform: translateY(-3px);
        }

        /* ── Footer ── */
        .footer-vp {
            background: var(--vp-footer);
            color: rgba(255,255,255,.75);
            padding: 60px 0 0;
        }
        .footer-vp h5 {
            color: var(--vp-green-light);
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        .footer-vp h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 2px;
            background: var(--vp-green-light);
        }
        .footer-vp p, .footer-vp li {
            font-size: .9rem;
            line-height: 1.8;
        }
        .footer-vp a {
            color: rgba(255,255,255,.75);
            text-decoration: none;
            transition: color .2s;
        }
        .footer-vp a:hover {
            color: var(--vp-green-light);
        }
        .footer-vp ul {
            list-style: none;
            padding: 0;
        }
        .footer-vp ul li {
            padding: 3px 0;
        }
        .footer-vp ul li i {
            color: var(--vp-green-light);
            margin-right: 8px;
            font-size: .8rem;
        }
        .footer-vp .footer-contact i {
            color: var(--vp-green-light);
            margin-right: 10px;
            width: 18px;
            text-align: center;
        }
        .footer-vp .footer-contact p {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
        }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,.1);
            margin-top: 40px;
            padding: 20px 0;
            text-align: center;
            font-size: .8rem;
            color: rgba(255,255,255,.45);
        }

        /* ── Misc ── */
        .page-hero-spacer {
            height: 100px;
        }

        /* ── About section ── */
        .about-img {
            width: 100%;
            border-radius: 22px;
            box-shadow: 0 12px 28px rgba(0,0,0,.12);
        }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            .hero-section h1 { font-size: 2.6rem; }
            .hero-section .hero-subtitle { font-size: 1.5rem; }
            .hero-section p { font-size: 1rem; }
            .hero-section { min-height: 500px; }
            .section-padding { padding: 50px 0; }
            .section-title { margin-bottom: 30px; }
            .section-title h2 { font-size: 2rem; }
            .navbar-vp .nav-link { padding: 10px 14px !important; }
            .navbar-vp .nav-link.active::after { display: none; }
        }
        @media (max-width: 767px) {
            .hero-section { min-height: 450px; }
            .hero-section h1 { font-size: 2rem; }
            .hero-section .hero-subtitle { font-size: 1.2rem; }
            .hero-mini { min-height: 30vh; }
            .section-padding { padding: 40px 0; }
            .section-title h2 { font-size: 1.6rem; }
            .footer-vp { padding: 40px 0 0; }
            .card-vp .card-img-top { height: 180px; }
            .stats-section .stat-value { font-size: 2rem; }
            .vp-topbar { font-size: 12px; }
        }
    </style>
    @yield('styles')
</head>
<body>
    {{-- ── Topbar ── --}}
    <div class="vp-topbar">
        {{ Setting::get('site_name', 'VERDE PARIS 75') }} &mdash; {{ Setting::get('site_tagline', 'Etude et travaux Batiment, VRD & Espaces verts') }}
    </div>

    {{-- ── Navbar ── --}}
    <nav class="navbar navbar-expand-lg navbar-vp sticky-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                {{ Setting::get('site_name', 'VERDE PARIS 75') }}
                <span class="brand-sub">Batiment &bull; VRD &bull; Espaces Verts</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('services*') ? 'active' : '' }}" href="{{ route('services') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('projects*') ? 'active' : '' }}" href="{{ route('projects') }}">R&eacute;alisations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('before-after') ? 'active' : '' }}" href="{{ route('before-after') }}">Avant/Apr&egrave;s</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}" href="{{ route('gallery') }}">Galerie</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('videos') ? 'active' : '' }}" href="{{ route('videos') }}">Vid&eacute;os</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('partners') ? 'active' : '' }}" href="{{ route('partners') }}">Partenaires</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- ── Main Content ── --}}
    <main>
        @yield('content')
    </main>

    {{-- ── Footer ── --}}
    <footer class="footer-vp">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5>{{ Setting::get('site_name', 'VERDE PARIS 75') }}</h5>
                    <p>{{ Setting::get('footer_text', Setting::get('site_tagline', 'Etude et Travaux Batiment, VRD, Assainissement et Espaces Verts en Ile-de-France.')) }}</p>
                    <div class="d-flex gap-3 mt-3">
                        @if(Setting::get('facebook'))
                        <a href="{{ Setting::get('facebook') }}" target="_blank"><i class="bi bi-facebook" style="font-size:1.2rem;"></i></a>
                        @endif
                        @if(Setting::get('instagram'))
                        <a href="{{ Setting::get('instagram') }}" target="_blank"><i class="bi bi-instagram" style="font-size:1.2rem;"></i></a>
                        @endif
                        @if(Setting::get('linkedin'))
                        <a href="{{ Setting::get('linkedin') }}" target="_blank"><i class="bi bi-linkedin" style="font-size:1.2rem;"></i></a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5>Liens rapides</h5>
                    <ul>
                        <li><a href="{{ route('home') }}"><i class="bi bi-chevron-right"></i> Accueil</a></li>
                        <li><a href="{{ route('services') }}"><i class="bi bi-chevron-right"></i> Nos services</a></li>
                        <li><a href="{{ route('projects') }}"><i class="bi bi-chevron-right"></i> Realisations</a></li>
                        <li><a href="{{ route('gallery') }}"><i class="bi bi-chevron-right"></i> Galerie</a></li>
                        <li><a href="{{ route('contact') }}"><i class="bi bi-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-12 mb-4">
                    <h5>Contact</h5>
                    <div class="footer-contact">
                        @if(Setting::get('address'))
                        <p><i class="bi bi-geo-alt-fill"></i> <span>{{ Setting::get('address') }}</span></p>
                        @endif
                        @if(Setting::get('phone'))
                        <p><i class="bi bi-telephone-fill"></i> <a href="tel:{{ Setting::get('phone') }}">{{ Setting::get('phone') }}</a></p>
                        @endif
                        @if(Setting::get('email'))
                        <p><i class="bi bi-envelope-fill"></i> <a href="mailto:{{ Setting::get('email') }}">{{ Setting::get('email') }}</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                {{ Setting::get('footer_copyright', '&copy; ' . date('Y') . ' VERDE PARIS 75 — Tous droits reserves.') }}
                <span class="d-block d-md-inline ms-md-3 mt-2 mt-md-0">
                    <a href="{{ url('/page/mentions-legales') }}">Mentions legales</a> &bull;
                    <a href="{{ url('/page/politique-confidentialite') }}">Politique de confidentialite</a>
                </span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        (function() {
            var navbar = document.getElementById('mainNavbar');
            function onScroll() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        })();
    </script>
    @yield('scripts')
</body>
</html>
