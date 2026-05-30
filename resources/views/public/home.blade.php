@extends('layouts.public')

@section('title', 'Accueil - ' . Setting::get('site_name', 'VERDE PARIS 75'))

@section('content')
    {{-- ── Hero Section ── --}}
    @if(isset($sections['hero']) && $sections['hero']->is_active)
    <section class="hero-section" style="background-image: url('{{ $sections['hero']->image ? asset('storage/' . $sections['hero']->image) : 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1800&q=80' }}');">
        <div class="container">
            <div class="hero-content">
                <h1>{{ $sections['hero']->title ?? 'VERDE PARIS 75' }}</h1>
                <div class="hero-subtitle">{{ $sections['hero']->subtitle ?? 'Etudes et Travaux Batiment, VRD & Espaces Verts' }}</div>
                <p>{{ $sections['hero']->content ?? '' }}</p>
                <div class="hero-btns">
                    @if($sections['hero']->button_text)
                    <a href="{{ $sections['hero']->button_url ?? route('contact') }}" class="btn btn-vp btn-lg">
                        {{ $sections['hero']->button_text }}
                    </a>
                    @endif
                    <a href="{{ route('projects') }}" class="btn btn-vp-white btn-lg">Voir nos realisations</a>
                </div>
            </div>
        </div>
    </section>
    @else
    <section class="hero-section" style="background-image: url('https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1800&q=80');">
        <div class="container">
            <div class="hero-content">
                <h1>VERDE PARIS 75</h1>
                <div class="hero-subtitle">Etudes et Travaux Batiment, VRD & Espaces Verts</div>
                <p>Installee a Charenton-le-Pont depuis 2014, nous accompagnons les projets publics et prives.</p>
                <div class="hero-btns">
                    <a href="{{ route('contact') }}" class="btn btn-vp btn-lg">Demander un devis</a>
                    <a href="{{ route('projects') }}" class="btn btn-vp-white btn-lg">Voir nos realisations</a>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ── About Section ── --}}
    @if(isset($sections['about']) && $sections['about']->is_active)
    <section class="section-padding bg-white">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <img src="{{ $sections['about']->image ? asset('storage/' . $sections['about']->image) : 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $sections['about']->title }}" class="about-img">
                </div>
                <div class="col-lg-6">
                    <h2 style="font-size:2.6rem;color:var(--vp-green);font-weight:700;margin:0 0 15px;">{{ $sections['about']->title ?? 'A Propos' }}</h2>
                    @if($sections['about']->subtitle)
                    <p class="lead text-muted mb-3">{{ $sections['about']->subtitle }}</p>
                    @endif
                    <div style="font-size:1.1rem;line-height:1.8;color:#555;">{!! $sections['about']->content !!}</div>
                    @if($sections['about']->button_text)
                    <a href="{{ $sections['about']->button_url ?? route('projects') }}" class="btn btn-vp mt-3">
                        {{ $sections['about']->button_text }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ── Services Preview ── --}}
    @if($services->count())
    <section class="section-padding">
        <div class="container">
            <div class="section-title">
                <h2>Nos Services</h2>
                <p>Des prestations completes pour vos projets VRD, batiment et espaces verts</p>
            </div>
            <div class="row g-4">
                @foreach($services->take(6) as $service)
                <div class="col-lg-4 col-md-6">
                    <div class="card card-vp h-100 text-center">
                        @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" alt="{{ $service->title }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            @if($service->icon)
                            <div class="mb-3">
                                <i class="bi bi-{{ $service->icon }}" style="font-size: 2.5rem; color: var(--vp-green);"></i>
                            </div>
                            @endif
                            <h5 class="card-title">{{ $service->title }}</h5>
                            <p class="card-text flex-grow-1">{{ Str::limit($service->short_description ?? $service->description, 120) }}</p>
                            <a href="{{ route('services.show', $service->slug) }}" class="btn btn-vp-outline btn-sm mt-auto">En savoir plus</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @if($services->count() > 6)
            <div class="text-center mt-4">
                <a href="{{ route('services') }}" class="btn btn-vp">Voir tous nos services</a>
            </div>
            @endif
        </div>
    </section>
    @endif

    {{-- ── Stats Section (green background) ── --}}
    @if(isset($sections['stats']) && $sections['stats']->is_active)
    <section class="stats-section">
        <div class="container">
            @if($sections['stats']->title)
            <div class="text-center mb-5">
                <h2 style="font-size:2.4rem;font-weight:900;color:#fff;margin:0;">{{ $sections['stats']->title }}</h2>
            </div>
            @endif
            <div class="row g-4">
                @php
                    $stats = $sections['stats']->extra_data ?? [];
                    $defaultStats = [
                        ['value' => '2014', 'label' => 'Depuis', 'icon' => 'calendar-check'],
                        ['value' => '8', 'label' => 'Domaines metier', 'icon' => 'briefcase'],
                        ['value' => '100%', 'label' => 'Administrable', 'icon' => 'gear'],
                        ['value' => 'IDF', 'label' => 'Zone d\'intervention', 'icon' => 'geo-alt'],
                    ];
                    if (empty($stats)) $stats = $defaultStats;
                @endphp
                @foreach($stats as $stat)
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <span class="stat-value">{{ $stat['value'] }}</span>
                        <div class="stat-label">{{ $stat['label'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ── Projects Preview ── --}}
    @if($projects->count())
    <section class="section-padding bg-white">
        <div class="container">
            <div class="section-title">
                <h2>Nos Realisations</h2>
                <p>Photos et videos de nos chantiers</p>
            </div>
            <div class="row g-4">
                @foreach($projects->take(6) as $project)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('projects.show', $project->slug) }}" class="text-decoration-none">
                        <div class="img-overlay-card">
                            <img src="{{ $project->cover_image ? asset('storage/' . $project->cover_image) : 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=900&q=80' }}" alt="{{ $project->title }}">
                            <div class="overlay">
                                @if($project->category)
                                <span class="badge-vp mb-2 align-self-start">{{ $project->category }}</span>
                                @endif
                                <h5>{{ $project->title }}</h5>
                                <p>{{ Str::limit($project->short_description, 80) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('projects') }}" class="btn btn-vp">Voir toutes nos realisations</a>
            </div>
        </div>
    </section>
    @endif

    {{-- ── Before/After Teaser ── --}}
    @php
        $beforeAfterItems = \App\Models\BeforeAfter::active()->ordered()->take(3)->get();
    @endphp
    @if($beforeAfterItems->count())
    <section class="section-padding">
        <div class="container">
            <div class="section-title">
                <h2>Avant / Apres</h2>
                <p>Comparatif visuel des realisations</p>
            </div>
            <div class="row g-4">
                @foreach($beforeAfterItems as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="card card-vp h-100">
                        <div class="row g-0" style="height: 200px;">
                            <div class="col-6 position-relative">
                                <span class="ba-label">AVANT</span>
                                <img src="{{ asset('storage/' . $item->before_image) }}" alt="Avant" style="width: 100%; height: 200px; object-fit: cover; border-radius: 18px 0 0 0;">
                            </div>
                            <div class="col-6 position-relative">
                                <span class="ba-label" style="background:var(--vp-green-light);">APRES</span>
                                <img src="{{ asset('storage/' . $item->after_image) }}" alt="Apres" style="width: 100%; height: 200px; object-fit: cover; border-radius: 0 18px 0 0;">
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h6 class="card-title mb-1">{{ $item->title }}</h6>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('before-after') }}" class="btn btn-vp-outline">Voir toutes les transformations</a>
            </div>
        </div>
    </section>
    @endif

    {{-- ── Testimonials ── --}}
    @if($testimonials->count())
    <section class="section-padding bg-white">
        <div class="container">
            <div class="section-title">
                <h2>Temoignages</h2>
                <p>Ce que disent nos clients</p>
            </div>
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    @foreach($testimonials as $index => $testimonial)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="card card-vp text-center p-4 p-md-5">
                                    <div class="mb-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= ($testimonial->rating ?? 5) ? '-fill' : '' }}" style="color: var(--vp-gold); font-size: 1.2rem;"></i>
                                        @endfor
                                    </div>
                                    <blockquote class="mb-4" style="font-size: 1.05rem; line-height: 1.7; color: var(--vp-text);">
                                        <i class="bi bi-quote" style="font-size: 2rem; color: var(--vp-green-light); opacity: .4;"></i><br>
                                        {{ $testimonial->content }}
                                    </blockquote>
                                    <div>
                                        @if($testimonial->image)
                                        <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->client_name }}" class="rounded-circle mb-2" style="width: 60px; height: 60px; object-fit: cover;">
                                        @endif
                                        <h6 class="mb-0" style="color: var(--vp-green-dark);">{{ $testimonial->client_name }}</h6>
                                        @if($testimonial->client_location)
                                        <small class="text-muted">{{ $testimonial->client_location }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($testimonials->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev" style="width: 5%;">
                    <span class="bg-dark bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-chevron-left" style="color: var(--vp-green); font-size: 1.2rem;"></i>
                    </span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next" style="width: 5%;">
                    <span class="bg-dark bg-opacity-25 rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-chevron-right" style="color: var(--vp-green); font-size: 1.2rem;"></i>
                    </span>
                </button>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- ── Partners ── --}}
    @if($partners->count())
    <section class="section-padding">
        <div class="container">
            <div class="section-title">
                <h2>Nos Partenaires</h2>
            </div>
            <div class="row align-items-center justify-content-center g-4">
                @foreach($partners as $partner)
                <div class="col-6 col-md-3 col-lg-2 text-center">
                    @if($partner->website)
                    <a href="{{ $partner->website }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
                    @endif
                        @if($partner->logo)
                        <div class="partner-box p-3">
                            <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="img-fluid" style="max-height: 70px; filter: grayscale(30%); transition: all .3s;" onmouseover="this.style.filter='none';" onmouseout="this.style.filter='grayscale(30%)';">
                        </div>
                        @else
                        <div class="partner-box">{{ $partner->name }}</div>
                        @endif
                    @if($partner->website)
                    </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ── CTA Section ── --}}
    @if(isset($sections['cta']) && $sections['cta']->is_active)
    <section class="cta-section">
        <div class="container">
            <h3>{{ $sections['cta']->title ?? 'Un projet VRD ou espaces verts ?' }}</h3>
            <p class="mx-auto" style="max-width: 600px;">{{ $sections['cta']->subtitle ?? 'Demandez une etude ou un rendez-vous pour vos travaux' }}</p>
            <a href="{{ $sections['cta']->button_url ?? route('contact') }}" class="btn btn-vp-gold btn-lg">
                <i class="bi bi-envelope me-2"></i>{{ $sections['cta']->button_text ?? 'Demander un devis' }}
            </a>
        </div>
    </section>
    @else
    <section class="cta-section">
        <div class="container">
            <h3>Un projet VRD ou espaces verts ?</h3>
            <p class="mx-auto" style="max-width: 600px;">Demandez une etude ou un rendez-vous pour vos travaux</p>
            <a href="{{ route('contact') }}" class="btn btn-vp-gold btn-lg">
                <i class="bi bi-envelope me-2"></i>Demander un devis
            </a>
        </div>
    </section>
    @endif
@endsection
