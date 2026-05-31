<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - VERDE PARIS 75</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --vp-green: #0E7A32;
            --vp-green-light: #39A845;
            --vp-green-dark: #0b5e25;
            --vp-gold: #d4a853;
            --vp-bg: #f8f9fa;
            --vp-sidebar: #0b1610;
        }
        body { background: var(--vp-bg); font-family: 'Segoe UI', system-ui, sans-serif; }
        .admin-sidebar {
            position: fixed; top: 0; left: 0; bottom: 0; width: 260px;
            background: var(--vp-sidebar); color: #fff; overflow-y: auto; z-index: 1000;
            transition: transform .3s;
        }
        .admin-sidebar .brand {
            padding: 20px; text-align: center; border-bottom: 1px solid rgba(255,255,255,.1);
        }
        .admin-sidebar .brand h4 { color: var(--vp-gold); margin: 0; font-weight: 700; }
        .admin-sidebar .brand small { color: rgba(255,255,255,.6); font-size: .75rem; }
        .admin-sidebar .nav-section { padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,.05); }
        .admin-sidebar .nav-section-title {
            padding: 5px 20px; font-size: .65rem; text-transform: uppercase;
            letter-spacing: 1px; color: rgba(255,255,255,.35); font-weight: 600;
        }
        .admin-sidebar .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 20px; color: rgba(255,255,255,.7);
            text-decoration: none; font-size: .85rem; transition: all .2s;
        }
        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: #fff; background: rgba(255,255,255,.1);
        }
        .admin-sidebar .nav-link.active { border-left: 3px solid var(--vp-gold); }
        .admin-sidebar .nav-link i { font-size: 1rem; width: 20px; text-align: center; }
        .admin-content { margin-left: 260px; padding: 20px 30px; min-height: 100vh; }
        .admin-topbar {
            display: flex; justify-content: space-between; align-items: center;
            padding: 15px 0; margin-bottom: 20px; border-bottom: 1px solid #dee2e6;
        }
        .admin-topbar h1 { font-size: 1.4rem; font-weight: 600; color: var(--vp-green-dark); margin: 0; }
        .btn-vp { background: var(--vp-green); color: #fff; border: none; }
        .btn-vp:hover { background: var(--vp-green-light); color: #fff; }
        .btn-vp-outline { border: 1px solid var(--vp-green); color: var(--vp-green); background: transparent; }
        .btn-vp-outline:hover { background: var(--vp-green); color: #fff; }
        .card { border: none; box-shadow: 0 1px 3px rgba(0,0,0,.08); border-radius: 8px; }
        .card-header { background: #fff; border-bottom: 1px solid #eee; font-weight: 600; }
        .stat-card { text-align: center; padding: 20px; }
        .stat-card .stat-value { font-size: 2rem; font-weight: 700; color: var(--vp-green); }
        .stat-card .stat-label { font-size: .8rem; color: #666; text-transform: uppercase; letter-spacing: .5px; }
        .stat-card .stat-icon { font-size: 2.5rem; color: var(--vp-green-light); opacity: .3; }
        .badge-vp { background: var(--vp-green); color: #fff; }
        .table th { font-size: .8rem; text-transform: uppercase; color: #666; font-weight: 600; letter-spacing: .5px; }
        .img-thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; }
        .sidebar-toggle { display: none; position: fixed; top: 15px; left: 15px; z-index: 1100; background: var(--vp-green); color: #fff; border: none; border-radius: 6px; padding: 8px 12px; }
        @media (max-width: 768px) {
            .admin-sidebar { transform: translateX(-260px); }
            .admin-sidebar.open { transform: translateX(0); }
            .admin-content { margin-left: 0; padding: 15px; }
            .sidebar-toggle { display: block; }
        }
        .alert { border-radius: 8px; }
    </style>
    @yield('styles')
</head>
<body>
    <button class="sidebar-toggle" onclick="document.querySelector('.admin-sidebar').classList.toggle('open')">
        <i class="bi bi-list"></i>
    </button>

    <nav class="admin-sidebar">
        <div class="brand">
            <h4><i class="bi bi-building"></i> VERDE PARIS 75</h4>
            <small>Administration</small>
        </div>

        <div class="nav-section">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Tableau de bord
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Contenu</div>
            <a href="{{ route('admin.homepage.index') }}" class="nav-link {{ request()->routeIs('admin.homepage.*') ? 'active' : '' }}">
                <i class="bi bi-house"></i> Page d'accueil
            </a>
            <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i> Services
            </a>
            <a href="{{ route('admin.projects.index') }}" class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <i class="bi bi-briefcase"></i> Realisations
            </a>
            <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                <i class="bi bi-chat-quote"></i> Temoignages
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Medias</div>
            <a href="{{ route('admin.before-after.index') }}" class="nav-link {{ request()->routeIs('admin.before-after.*') ? 'active' : '' }}">
                <i class="bi bi-arrows-angle-expand"></i> Avant / Apres
            </a>
            <a href="{{ route('admin.photos.index') }}" class="nav-link {{ request()->routeIs('admin.photos.*') ? 'active' : '' }}">
                <i class="bi bi-images"></i> Galerie Photos
            </a>
            <a href="{{ route('admin.videos.index') }}" class="nav-link {{ request()->routeIs('admin.videos.*') ? 'active' : '' }}">
                <i class="bi bi-play-circle"></i> Videos
            </a>
            <a href="{{ route('admin.partners.index') }}" class="nav-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Partenaires
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Communication</div>
            <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i> Messages
                @php $unread = \App\Models\ContactMessage::unread()->count(); @endphp
                @if($unread > 0)
                    <span class="badge bg-danger ms-auto">{{ $unread }}</span>
                @endif
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Configuration</div>
            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-sliders"></i> Parametres
            </a>
            <a href="{{ route('admin.seo.index') }}" class="nav-link {{ request()->routeIs('admin.seo.*') && !request()->routeIs('admin.seo-pro.*') ? 'active' : '' }}">
                <i class="bi bi-search"></i> SEO
            </a>
            <a href="{{ route('admin.seo-pro.dashboard') }}" class="nav-link {{ request()->routeIs('admin.seo-pro.*') ? 'active' : '' }}">
                <i class="bi bi-rocket-takeoff"></i> SEO Pro
            </a>
            <a href="{{ route('admin.legal-pages.index') }}" class="nav-link {{ request()->routeIs('admin.legal-pages.*') ? 'active' : '' }}">
                <i class="bi bi-file-text"></i> Pages Legales
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Systeme</div>
            <a href="{{ route('admin.analytics.index') }}" class="nav-link {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                <i class="bi bi-graph-up"></i> Analytics
            </a>
            <a href="{{ route('admin.security.index') }}" class="nav-link {{ request()->routeIs('admin.security.*') ? 'active' : '' }}">
                <i class="bi bi-shield-check"></i> Securite
            </a>
            <a href="{{ route('admin.backups.index') }}" class="nav-link {{ request()->routeIs('admin.backups.*') ? 'active' : '' }}">
                <i class="bi bi-cloud-arrow-down"></i> Sauvegardes
            </a>
        </div>

        <div class="nav-section" style="padding: 15px 20px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light w-100">
                    <i class="bi bi-box-arrow-left"></i> Deconnexion
                </button>
            </form>
        </div>
    </nav>

    <div class="admin-content">
        <div class="admin-topbar">
            <h1>@yield('title', 'Tableau de bord')</h1>
            <div>@yield('actions')</div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
