@extends('layouts.public')

@section('title', 'Accueil - ' . Setting::get('site_name', 'VERDE PARIS 75'))

@section('content')
    {{-- ── Hero ── --}}
    <section class="hero" style="background-image: url('{{ isset($sections['hero']) && $sections['hero']->image ? asset('storage/' . $sections['hero']->image) : 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1800&q=80' }}');">
        <div class="container">
            <h1>{{ $sections['hero']->title ?? 'VERDE PARIS 75' }}</h1>
            <div class="hero-sub">{{ $sections['hero']->subtitle ?? 'Etudes et Travaux Batiment, VRD & Espaces Verts' }}</div>
            <p>{{ $sections['hero']->content ?? 'Installee a Charenton-le-Pont depuis 2014, VERDE PARIS 75 accompagne les projets publics et prives : VRD, assainissement, terrassement, reseaux divers, mobilier urbain et espaces verts.' }}</p>
            <div class="hero-btns">
                <a class="btn btn-green" href="{{ route('contact') }}">{{ $sections['hero']->button_text ?? 'Demander un devis' }}</a>
                <a class="btn btn-white" href="{{ route('projects') }}">Voir nos realisations</a>
            </div>
        </div>
    </section>

    {{-- ── About ── --}}
    <section>
        <div class="about-grid">
            <img src="{{ isset($sections['about']) && $sections['about']->image ? asset('storage/' . $sections['about']->image) : 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?auto=format&fit=crop&w=1200&q=80' }}" alt="Chantier VERDE PARIS 75">
            <div>
                <h2>{{ $sections['about']->title ?? 'Votre partenaire VRD & Espaces Verts' }}</h2>
                @if(isset($sections['about']) && $sections['about']->subtitle)
                <p style="color:#999;margin-bottom:15px;font-weight:600;">{{ $sections['about']->subtitle }}</p>
                @endif
                <div>{!! $sections['about']->content ?? '<p>VERDE PARIS 75 est specialisee dans l\'etude et la realisation de travaux de voiries et reseaux divers, ainsi que dans la creation et l\'entretien des espaces verts.</p><p>Nos equipes disposent d\'un parc d\'engins et de moyens techniques adaptes pour assurer la bonne execution des travaux, dans le respect des normes et de la securite.</p>' !!}</div>
                @if(isset($sections['about']) && $sections['about']->button_text)
                <a href="{{ $sections['about']->button_url ?? route('projects') }}" class="btn btn-green">{{ $sections['about']->button_text }}</a>
                @endif
            </div>
        </div>
    </section>

    {{-- ── Services ── --}}
    <section id="services" style="background:linear-gradient(rgba(255,255,255,0.92),rgba(255,255,255,0.92)),url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1800&q=80');background-size:cover;background-position:center;background-attachment:fixed;">
        <div class="section-title">
            <h2>Nos Services</h2>
            <p>Des prestations completes pour vos projets VRD, batiment et espaces verts.</p>
        </div>
        @php
            $defaultImages = [
                'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1610477865545-40de0ad8e9e6?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1601683319450-1744b7a8b0cb?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1584467541268-b040f83be3fd?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1605092676920-6fb7f258b9e2?auto=format&fit=crop&w=900&q=80',
            ];
        @endphp
        <div class="grid">
            @foreach($services->take(6) as $i => $service)
            <a href="{{ route('services.show', $service->slug) }}" style="text-decoration:none;color:inherit;">
                <div class="card">
                    <img src="{{ $service->image ? asset('storage/' . $service->image) : ($defaultImages[$i] ?? $defaultImages[0]) }}" alt="{{ $service->title }}">
                    <div class="card-content">
                        <h3>{{ $service->title }}</h3>
                        <p>{{ Str::limit($service->short_description ?? $service->description, 120) }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @if($services->count() > 6)
        <div class="text-center mt-4">
            <a href="{{ route('services') }}" class="btn btn-green">Voir tous nos services</a>
        </div>
        @endif
    </section>

    {{-- ── Stats ── --}}
    <section class="bg-green">
        @php
            $stats = isset($sections['stats']) ? ($sections['stats']->extra_data ?? []) : [];
            if (empty($stats)) {
                $stats = [
                    ['value' => '2014', 'label' => 'Depuis'],
                    ['value' => '8', 'label' => 'Domaines metier'],
                    ['value' => '100%', 'label' => 'Administrable'],
                    ['value' => 'IDF', 'label' => 'Intervention'],
                ];
            }
        @endphp
        <div class="stats-grid">
            @foreach($stats as $stat)
            <div class="stat">
                <strong>{{ $stat['value'] }}</strong>
                <span>{{ $stat['label'] }}</span>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ── Before / After ── --}}
    @php
        $baItems = \App\Models\BeforeAfter::active()->ordered()->take(3)->get();
    @endphp
    <section id="avantapres">
        <div class="section-title">
            <h2>Avant / Apres</h2>
            <p>Comparatif visuel des realisations.</p>
        </div>
        @if($baItems->count())
            @foreach($baItems as $item)
            <div class="ba-grid" style="margin-bottom:30px;">
                <div class="ba-item">
                    <span class="ba-label">AVANT</span>
                    <img src="{{ asset('storage/' . $item->before_image) }}" alt="Avant - {{ $item->title }}">
                </div>
                <div class="ba-item">
                    <span class="ba-label">APRES</span>
                    <img src="{{ asset('storage/' . $item->after_image) }}" alt="Apres - {{ $item->title }}">
                </div>
            </div>
            @endforeach
        @else
            <div class="ba-grid">
                <div class="ba-item">
                    <span class="ba-label">AVANT</span>
                    <img src="https://images.unsplash.com/photo-1590496793929-36417d3117de?auto=format&fit=crop&w=900&q=80" alt="Avant">
                </div>
                <div class="ba-item">
                    <span class="ba-label">APRES</span>
                    <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=900&q=80" alt="Apres">
                </div>
            </div>
        @endif
        <div class="text-center mt-4">
            <a href="{{ route('before-after') }}" class="btn btn-outline">Voir toutes les transformations</a>
        </div>
    </section>

    {{-- ── Realisations ── --}}
    <section id="realisations" class="bg-white">
        <div class="section-title">
            <h2>Nos Realisations</h2>
            <p>Photos et videos de nos chantiers</p>
        </div>
        @php
            $defaultProjectImages = [
                'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1581094288338-2314dddb7ece?auto=format&fit=crop&w=900&q=80',
                'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?auto=format&fit=crop&w=900&q=80',
            ];
        @endphp
        @if($projects->count())
        <div class="grid">
            @foreach($projects->take(6) as $i => $project)
            <a href="{{ route('projects.show', $project->slug) }}" style="text-decoration:none;">
                <div class="img-overlay">
                    <img src="{{ $project->cover_image ? asset('storage/' . $project->cover_image) : ($defaultProjectImages[$i % 3]) }}" alt="{{ $project->title }}">
                    <div class="overlay">
                        @if($project->category)
                        <span class="badge-vp">{{ $project->category }}</span>
                        @endif
                        <h5>{{ $project->title }}</h5>
                        <p>{{ Str::limit($project->short_description, 80) }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <div class="grid">
            <div class="card"><img src="{{ $defaultProjectImages[0] }}"><div class="card-content"><h3>Voirie</h3><p>Travaux de revetement et amenagement.</p></div></div>
            <div class="card"><img src="{{ $defaultProjectImages[1] }}"><div class="card-content"><h3>Reseaux</h3><p>Pose de reseaux et chambres de tirage.</p></div></div>
            <div class="card"><img src="{{ $defaultProjectImages[2] }}"><div class="card-content"><h3>Espaces verts</h3><p>Creation et entretien paysager.</p></div></div>
        </div>
        @endif
        <div class="text-center mt-4">
            <a href="{{ route('projects') }}" class="btn btn-green">Voir toutes nos realisations</a>
        </div>
    </section>

    {{-- ── Testimonials ── --}}
    @if($testimonials->count())
    <section>
        <div class="section-title">
            <h2>Temoignages</h2>
            <p>Ce que disent nos clients</p>
        </div>
        <div style="position:relative;max-width:900px;margin:auto;">
            <div id="testimonials">
                @foreach($testimonials as $index => $t)
                <div class="testimonial-card" style="{{ $index > 0 ? 'display:none;' : '' }}" data-slide="{{ $index }}">
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $i <= ($t->rating ?? 5) ? '-fill' : '' }}"></i>
                        @endfor
                    </div>
                    <blockquote>"{{ $t->content }}"</blockquote>
                    <div class="author">{{ $t->client_name }}</div>
                    @if($t->client_location)
                    <div class="location">{{ $t->client_location }}</div>
                    @endif
                </div>
                @endforeach
            </div>
            @if($testimonials->count() > 1)
            <button class="carousel-btn prev" onclick="slideTestimonial(-1)"><i class="bi bi-chevron-left"></i></button>
            <button class="carousel-btn next" onclick="slideTestimonial(1)"><i class="bi bi-chevron-right"></i></button>
            @endif
        </div>
    </section>
    @endif

    {{-- ── Partners ── --}}
    <section class="bg-white">
        <div class="section-title">
            <h2>Nos Partenaires</h2>
            <p>Logos modifiables depuis l'admin.</p>
        </div>
        @if($partners->count())
        <div class="partners-grid">
            @foreach($partners as $p)
            <div class="partner">
                @if($p->website)<a href="{{ $p->website }}" target="_blank" rel="noopener" style="text-decoration:none;color:inherit;">@endif
                @if($p->logo)
                    <img src="{{ asset('storage/' . $p->logo) }}" alt="{{ $p->name }}">
                @else
                    {{ $p->name }}
                @endif
                @if($p->website)</a>@endif
            </div>
            @endforeach
        </div>
        @else
        <div class="partners-grid">
            <div class="partner">PARTENAIRE</div>
            <div class="partner">PARTENAIRE</div>
            <div class="partner">PARTENAIRE</div>
            <div class="partner">PARTENAIRE</div>
            <div class="partner">PARTENAIRE</div>
        </div>
        @endif
    </section>

    {{-- ── Contact (dark section) ── --}}
    <section class="bg-dark" id="contact">
        <div class="contact-wrap">
            <div>
                <h2>Contact</h2>
                <p>Demandez une etude ou un rendez-vous pour vos travaux VRD, batiment et espaces verts.</p>
                <p style="margin-top:20px;">
                    @if(Setting::get('address'))
                    <i class="bi bi-geo-alt-fill" style="color:#39A845;margin-right:8px;"></i> {{ Setting::get('address') }}<br><br>
                    @endif
                    @if(Setting::get('phone'))
                    <i class="bi bi-telephone-fill" style="color:#39A845;margin-right:8px;"></i> <a href="tel:{{ Setting::get('phone') }}" style="color:rgba(255,255,255,.8);">{{ Setting::get('phone') }}</a><br><br>
                    @endif
                    @if(Setting::get('email'))
                    <i class="bi bi-envelope-fill" style="color:#39A845;margin-right:8px;"></i> <a href="mailto:{{ Setting::get('email') }}" style="color:rgba(255,255,255,.8);">{{ Setting::get('email') }}</a>
                    @endif
                </p>
            </div>
            <form method="POST" action="{{ route('contact.submit') }}">
                @csrf
                <input type="text" name="name" placeholder="Nom" required>
                <input type="tel" name="phone" placeholder="Telephone">
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="message" rows="5" placeholder="Message" required></textarea>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    </section>

    {{-- ── Visitor Counters ── --}}
    <section style="background:#0b5e25;color:white;padding:50px 24px;">
        <div style="max-width:900px;margin:auto;display:grid;grid-template-columns:repeat(3,1fr);gap:24px;text-align:center;">
            <div class="stat">
                <strong>{{ number_format($totalVisitors ?? 0) }}</strong>
                <span><i class="bi bi-people" style="margin-right:5px;"></i> Visiteurs</span>
            </div>
            <div class="stat">
                <strong>{{ number_format($totalPageViews ?? 0) }}</strong>
                <span><i class="bi bi-eye" style="margin-right:5px;"></i> Pages vues</span>
            </div>
            <div class="stat">
                <strong>{{ $onlineNow ?? 0 }}</strong>
                <span><i class="bi bi-circle-fill" style="color:#39A845;margin-right:5px;font-size:10px;"></i> En ligne</span>
            </div>
        </div>
    </section>

    {{-- ── CTA ── --}}
    <section class="cta-section">
        <h3>{{ $sections['cta']->title ?? 'Un projet VRD ou espaces verts ?' }}</h3>
        <p>{{ $sections['cta']->subtitle ?? 'Demandez une etude ou un rendez-vous pour vos travaux' }}</p>
        <a href="{{ route('contact') }}" class="btn btn-gold">
            <i class="bi bi-envelope" style="margin-right:8px;"></i>{{ $sections['cta']->button_text ?? 'Demander un devis' }}
        </a>
    </section>
@endsection

@section('scripts')
<script>
var currentSlide = 0;
function slideTestimonial(dir) {
    var slides = document.querySelectorAll('[data-slide]');
    if (!slides.length) return;
    slides[currentSlide].style.display = 'none';
    currentSlide = (currentSlide + dir + slides.length) % slides.length;
    slides[currentSlide].style.display = 'block';
}
setInterval(function(){ slideTestimonial(1); }, 6000);
</script>
@endsection
