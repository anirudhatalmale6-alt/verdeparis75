@extends('layouts.public')

@section('title', 'Accueil - ' . Setting::get('site_name', 'VerdeParis75'))

@section('content')
    {{-- ── Hero Section ── --}}
    @if(isset($sections['hero']) && $sections['hero']->is_active)
    <section class="hero-section" style="background-image: url('{{ $sections['hero']->image ? asset('storage/' . $sections['hero']->image) : '' }}');">
        <div class="container">
            <div class="hero-content text-center w-100">
                <h1 class="mb-3">{{ $sections['hero']->title ?? 'Votre Paysagiste de Confiance' }}</h1>
                <p class="mb-4 mx-auto" style="max-width: 650px;">{{ $sections['hero']->subtitle ?? 'Am&eacute;nagement paysager et entretien d\'espaces verts &agrave; Paris' }}</p>
                @if($sections['hero']->button_text)
                <a href="{{ $sections['hero']->button_url ?? route('contact') }}" class="btn btn-vp-gold btn-lg">
                    {{ $sections['hero']->button_text }}
                </a>
                @endif
            </div>
        </div>
    </section>
    @else
    <section class="hero-section" style="background-image: url('{{ asset('images/hero-default.jpg') }}');">
        <div class="container">
            <div class="hero-content text-center w-100">
                <h1 class="mb-3">Votre Paysagiste de Confiance &agrave; Paris</h1>
                <p class="mb-4 mx-auto" style="max-width: 650px;">Cr&eacute;ation, am&eacute;nagement et entretien d'espaces verts pour particuliers et professionnels</p>
                <a href="{{ route('contact') }}" class="btn btn-vp-gold btn-lg">Demander un Devis</a>
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
                    @if($sections['about']->image)
                    <img src="{{ asset('storage/' . $sections['about']->image) }}" alt="{{ $sections['about']->title }}" class="img-fluid rounded-3 shadow" style="width: 100%; height: 400px; object-fit: cover;">
                    @endif
                </div>
                <div class="col-lg-6">
                    <div class="section-title text-start">
                        <h2>{{ $sections['about']->title ?? '&Agrave; Propos' }}</h2>
                    </div>
                    @if($sections['about']->subtitle)
                    <p class="lead text-muted mb-3">{{ $sections['about']->subtitle }}</p>
                    @endif
                    <div class="text-muted">{!! $sections['about']->content !!}</div>
                    @if($sections['about']->button_text)
                    <a href="{{ $sections['about']->button_url ?? route('contact') }}" class="btn btn-vp mt-3">
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
                <p>Des solutions professionnelles pour tous vos besoins en espaces verts</p>
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

    {{-- ── Projects Preview ── --}}
    @if($projects->count())
    <section class="section-padding bg-white">
        <div class="container">
            <div class="section-title">
                <h2>Nos R&eacute;alisations</h2>
                <p>D&eacute;couvrez nos projets d'am&eacute;nagement paysager</p>
            </div>
            <div class="row g-4">
                @foreach($projects->take(6) as $project)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('projects.show', $project->slug) }}" class="text-decoration-none">
                        <div class="img-overlay-card">
                            <img src="{{ $project->cover_image ? asset('storage/' . $project->cover_image) : asset('images/placeholder.jpg') }}" alt="{{ $project->title }}">
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
                <a href="{{ route('projects') }}" class="btn btn-vp">Voir toutes nos r&eacute;alisations</a>
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
                <h2>Avant / Apr&egrave;s</h2>
                <p>La transformation de vos espaces verts en images</p>
            </div>
            <div class="row g-4">
                @foreach($beforeAfterItems as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="card card-vp h-100">
                        <div class="row g-0" style="height: 200px;">
                            <div class="col-6">
                                <img src="{{ asset('storage/' . $item->before_image) }}" alt="Avant" style="width: 100%; height: 200px; object-fit: cover; border-radius: 12px 0 0 0;">
                            </div>
                            <div class="col-6">
                                <img src="{{ asset('storage/' . $item->after_image) }}" alt="Apr&egrave;s" style="width: 100%; height: 200px; object-fit: cover; border-radius: 0 12px 0 0;">
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h6 class="card-title mb-1">{{ $item->title }}</h6>
                            <small class="text-muted">Avant &rarr; Apr&egrave;s</small>
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
                <h2>T&eacute;moignages</h2>
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
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="img-fluid" style="max-height: 70px; filter: grayscale(50%); opacity: .7; transition: all .3s;" onmouseover="this.style.filter='none';this.style.opacity='1';" onmouseout="this.style.filter='grayscale(50%)';this.style.opacity='.7';">
                        @else
                        <span class="text-muted fw-bold">{{ $partner->name }}</span>
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

    {{-- ── Stats Section ── --}}
    @if(isset($sections['stats']) && $sections['stats']->is_active)
    <section class="section-padding bg-white">
        <div class="container">
            <div class="row text-center g-4">
                @php
                    $stats = $sections['stats']->extra_data ?? [];
                    $defaultStats = [
                        ['value' => '15+', 'label' => 'Ann&eacute;es d\'exp&eacute;rience', 'icon' => 'calendar-check'],
                        ['value' => '500+', 'label' => 'Projets r&eacute;alis&eacute;s', 'icon' => 'briefcase'],
                        ['value' => '300+', 'label' => 'Clients satisfaits', 'icon' => 'people'],
                        ['value' => '100%', 'label' => 'Engagement qualit&eacute;', 'icon' => 'award'],
                    ];
                    if (empty($stats)) $stats = $defaultStats;
                @endphp
                @foreach($stats as $stat)
                <div class="col-6 col-md-3">
                    <div class="p-3">
                        <i class="bi bi-{{ $stat['icon'] ?? 'star' }}" style="font-size: 2rem; color: var(--vp-gold); display: block; margin-bottom: 10px;"></i>
                        <div style="font-size: 2.2rem; font-weight: 700; color: var(--vp-green-dark);">{{ $stat['value'] }}</div>
                        <div style="font-size: .85rem; color: var(--vp-text-light); text-transform: uppercase; letter-spacing: .5px;">{{ $stat['label'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ── CTA Section ── --}}
    <section class="cta-section">
        <div class="container">
            <h3>Pr&ecirc;t &agrave; transformer votre espace vert ?</h3>
            <p class="mx-auto" style="max-width: 550px;">Contactez-nous d&egrave;s aujourd'hui pour un devis gratuit et personnalis&eacute;.</p>
            <a href="{{ route('contact') }}" class="btn btn-vp-gold btn-lg">
                <i class="bi bi-envelope me-2"></i>Nous Contacter
            </a>
        </div>
    </section>
@endsection
