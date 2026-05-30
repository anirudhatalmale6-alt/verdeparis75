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
            --vp-green: #2d6a4f;
            --vp-green-light: #40916c;
            --vp-green-dark: #1b4332;
            --vp-gold: #d4a853;
            --vp-gold-light: #e8c47a;
            --vp-bg: #f9fafb;
            --vp-white: #ffffff;
            --vp-text: #333333;
            --vp-text-light: #6c757d;
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

        /* ── Navbar ── */
        .navbar-vp {
            background: var(--vp-green-dark);
            padding: 0;
            transition: background .3s, box-shadow .3s;
            z-index: 1040;
        }
        .navbar-vp.scrolled {
            background: var(--vp-green-dark);
            box-shadow: 0 2px 20px rgba(0,0,0,.25);
        }
        .navbar-vp .navbar-brand {
            color: var(--vp-gold);
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: .5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .navbar-vp .navbar-brand:hover {
            color: var(--vp-gold-light);
        }
        .navbar-vp .navbar-brand i {
            font-size: 1.5rem;
        }
        .navbar-vp .nav-link {
            color: rgba(255,255,255,.8) !important;
            font-size: .9rem;
            font-weight: 500;
            padding: 18px 14px !important;
            transition: color .2s, background .2s;
            position: relative;
        }
        .navbar-vp .nav-link:hover,
        .navbar-vp .nav-link.active {
            color: var(--vp-gold) !important;
            background: rgba(255,255,255,.05);
        }
        .navbar-vp .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 14px;
            right: 14px;
            height: 3px;
            background: var(--vp-gold);
            border-radius: 3px 3px 0 0;
        }
        .navbar-vp .navbar-toggler {
            border-color: rgba(255,255,255,.3);
            padding: 6px 10px;
        }
        .navbar-vp .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* ── Hero sections ── */
        .hero-section {
            min-height: 70vh;
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
            background: rgba(0,0,0,.5);
        }
        .hero-section .hero-content {
            position: relative;
            z-index: 2;
            color: #fff;
        }
        .hero-section h1 {
            font-size: 3rem;
            font-weight: 700;
            text-shadow: 0 2px 10px rgba(0,0,0,.3);
        }
        .hero-section p {
            font-size: 1.2rem;
            opacity: .9;
        }
        .hero-mini {
            min-height: 40vh;
        }
        .hero-mini h1 {
            font-size: 2.4rem;
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
            font-size: 2rem;
            font-weight: 700;
            color: var(--vp-green-dark);
            display: inline-block;
            position: relative;
            padding-bottom: 15px;
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
            color: var(--vp-text-light);
            font-size: 1.05rem;
            margin-top: 10px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* ── Cards ── */
        .card-vp {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            background: var(--vp-white);
            box-shadow: 0 2px 15px rgba(0,0,0,.06);
            transition: transform .3s, box-shadow .3s;
        }
        .card-vp:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,.1);
        }
        .card-vp .card-img-top {
            height: 220px;
            object-fit: cover;
        }
        .card-vp .card-body {
            padding: 20px;
        }
        .card-vp .card-title {
            font-weight: 600;
            color: var(--vp-green-dark);
        }
        .card-vp .card-text {
            color: var(--vp-text-light);
            font-size: .9rem;
        }

        /* ── Buttons ── */
        .btn-vp {
            background: var(--vp-green);
            color: #fff;
            border: none;
            padding: 10px 28px;
            border-radius: 6px;
            font-weight: 500;
            transition: background .3s, transform .2s;
        }
        .btn-vp:hover {
            background: var(--vp-green-light);
            color: #fff;
            transform: translateY(-1px);
        }
        .btn-vp-outline {
            border: 2px solid var(--vp-green);
            color: var(--vp-green);
            background: transparent;
            padding: 10px 28px;
            border-radius: 6px;
            font-weight: 500;
            transition: all .3s;
        }
        .btn-vp-outline:hover {
            background: var(--vp-green);
            color: #fff;
        }
        .btn-vp-gold {
            background: var(--vp-gold);
            color: var(--vp-green-dark);
            border: none;
            padding: 12px 32px;
            border-radius: 6px;
            font-weight: 600;
            transition: background .3s, transform .2s;
        }
        .btn-vp-gold:hover {
            background: var(--vp-gold-light);
            color: var(--vp-green-dark);
            transform: translateY(-1px);
        }

        /* ── Badges ── */
        .badge-vp {
            background: var(--vp-green);
            color: #fff;
            font-size: .75rem;
            font-weight: 500;
            padding: 5px 12px;
            border-radius: 20px;
        }

        /* ── Image overlays ── */
        .img-overlay-card {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
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
            background: linear-gradient(to top, rgba(27,67,50,.85) 0%, transparent 60%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 20px;
            color: #fff;
        }
        .img-overlay-card .overlay h5 {
            font-weight: 600;
            margin-bottom: 5px;
        }
        .img-overlay-card .overlay p {
            font-size: .85rem;
            opacity: .85;
            margin: 0;
        }

        /* ── CTA Section ── */
        .cta-section {
            background: linear-gradient(135deg, var(--vp-green-dark), var(--vp-green));
            color: #fff;
            padding: 60px 0;
            text-align: center;
        }
        .cta-section h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .cta-section p {
            font-size: 1.05rem;
            opacity: .9;
            margin-bottom: 25px;
        }

        /* ── Footer ── */
        .footer-vp {
            background: var(--vp-green-dark);
            color: rgba(255,255,255,.75);
            padding: 60px 0 0;
        }
        .footer-vp h5 {
            color: var(--vp-gold);
            font-weight: 600;
            font-size: 1rem;
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
            background: var(--vp-gold);
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
            color: var(--vp-gold);
        }
        .footer-vp ul {
            list-style: none;
            padding: 0;
        }
        .footer-vp ul li {
            padding: 3px 0;
        }
        .footer-vp ul li i {
            color: var(--vp-gold);
            margin-right: 8px;
            font-size: .8rem;
        }
        .footer-vp .footer-contact i {
            color: var(--vp-gold);
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
            height: 76px;
        }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            .hero-section h1 { font-size: 2rem; }
            .hero-section p { font-size: 1rem; }
            .section-padding { padding: 50px 0; }
            .section-title { margin-bottom: 30px; }
            .section-title h2 { font-size: 1.6rem; }
            .navbar-vp .nav-link { padding: 10px 14px !important; }
            .navbar-vp .nav-link.active::after { display: none; }
        }
        @media (max-width: 767px) {
            .hero-section { min-height: 50vh; }
            .hero-mini { min-height: 30vh; }
            .section-padding { padding: 40px 0; }
            .footer-vp { padding: 40px 0 0; }
            .card-vp .card-img-top { height: 180px; }
        }
    </style>
    @yield('styles')
</head>
<body>
    {{-- ── Navbar ── --}}
    <nav class="navbar navbar-expand-lg navbar-dark navbar-vp fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-tree-fill"></i> {{ Setting::get('site_name', 'VerdeParis75') }}
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
                {{-- About column --}}
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5><i class="bi bi-tree-fill me-2"></i>{{ Setting::get('site_name', 'VerdeParis75') }}</h5>
                    <p>{{ Setting::get('site_tagline', 'Sp&eacute;cialiste des espaces verts &agrave; Paris et en &Icirc;le-de-France. Am&eacute;nagement paysager, entretien de jardins et cr&eacute;ation d\'espaces verts sur mesure.') }}</p>
                </div>
                {{-- Quick links column --}}
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5>Liens rapides</h5>
                    <ul>
                        <li><a href="{{ route('home') }}"><i class="bi bi-chevron-right"></i> Accueil</a></li>
                        <li><a href="{{ route('services') }}"><i class="bi bi-chevron-right"></i> Nos services</a></li>
                        <li><a href="{{ route('projects') }}"><i class="bi bi-chevron-right"></i> R&eacute;alisations</a></li>
                        <li><a href="{{ route('gallery') }}"><i class="bi bi-chevron-right"></i> Galerie</a></li>
                        <li><a href="{{ route('contact') }}"><i class="bi bi-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
                {{-- Contact info column --}}
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
                        @if(Setting::get('hours'))
                        <p><i class="bi bi-clock-fill"></i> <span>{{ Setting::get('hours') }}</span></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                &copy; {{ date('Y') }} {{ Setting::get('site_name', 'VerdeParis75') }}. Tous droits r&eacute;serv&eacute;s.
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
