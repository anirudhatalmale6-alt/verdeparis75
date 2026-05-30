@extends('layouts.public')

@section('title', 'Galerie Photos - ' . Setting::get('site_name', 'VERDE PARIS 75'))

@section('styles')
<style>
    .kicker{display:inline-block;background:rgba(57,168,69,.20);border:1px solid rgba(57,168,69,.55);padding:9px 15px;border-radius:999px;font-weight:900;letter-spacing:.08em;margin-bottom:18px}
    .filters{display:flex;justify-content:center;flex-wrap:wrap;gap:10px;margin:0 auto 20px;max-width:1100px}
    .filters a{text-decoration:none;background:white;color:#1f2937;padding:11px 17px;border-radius:999px;font-weight:900;box-shadow:0 7px 18px rgba(0,0,0,.07);transition:background .2s,color .2s}
    .filters a.active,.filters a:hover{background:#0E7A32;color:white}
    .sortbar{display:flex;justify-content:center;gap:10px;flex-wrap:wrap;margin:0 auto 35px}
    .sortbar a{text-decoration:none;border:2px solid #0E7A32;color:#0E7A32;background:white;padding:10px 16px;border-radius:999px;font-weight:900;transition:background .2s,color .2s}
    .sortbar a.active,.sortbar a:hover{background:#0E7A32;color:white}
    .featured-grid{max-width:1200px;margin:0 auto 35px;display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
    .featured-card{position:relative;border-radius:24px;overflow:hidden;min-height:350px;box-shadow:0 15px 36px rgba(0,0,0,.16);text-decoration:none;color:white;background:#111;display:block}
    .featured-card img{width:100%;height:350px;object-fit:cover;display:block;transition:transform .4s}
    .featured-card:hover img{transform:scale(1.06)}
    .featured-info{position:absolute;left:18px;right:18px;bottom:18px;padding:20px;border-radius:18px;background:linear-gradient(180deg,rgba(0,0,0,.05),rgba(0,0,0,.78))}
    .featured-info span{font-size:12px;color:#d9ffd9;font-weight:900;text-transform:uppercase}
    .featured-info h3{font-size:25px;margin:6px 0 12px}
    .statsline{display:flex;gap:10px;flex-wrap:wrap}
    .stat-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.16);padding:7px 11px;border-radius:999px;font-size:13px;font-weight:900}
    .photo-card{background:white;border-radius:22px;overflow:hidden;box-shadow:0 13px 32px rgba(0,0,0,.10);position:relative}
    .photo-card img{width:100%;height:255px;object-fit:cover;display:block;transition:transform .35s;cursor:pointer}
    .photo-card:hover img{transform:scale(1.05)}
    .photo-card .card-content{padding:22px}
    .photo-card .card-content .cat{color:#0E7A32;font-size:12px;text-transform:uppercase;font-weight:900}
    .photo-card .card-content h3{font-size:23px;margin:7px 0 8px;color:#1f2937}
    .photo-card .card-content p{margin:0 0 14px;color:#666}
    .card-actions{display:flex;justify-content:space-between;align-items:center;border-top:1px solid #eef2ee;padding-top:14px}
    .like-btn{border:0;background:#f0f8f2;color:#0E7A32;border-radius:999px;padding:9px 13px;font-weight:900;cursor:pointer;transition:background .2s,color .2s}
    .like-btn:hover,.like-btn.active{background:#0E7A32;color:white}
    .views-count{font-weight:900;color:#374151}
    @media(max-width:991px){.featured-grid{grid-template-columns:1fr 1fr}.grid{grid-template-columns:1fr 1fr}}
    @media(max-width:575px){.featured-grid{grid-template-columns:1fr}.grid{grid-template-columns:1fr}.filters{gap:6px}.filters a{padding:8px 12px;font-size:13px}}
</style>
@endsection

@section('content')
    <section class="hero" style="background:linear-gradient(90deg,rgba(0,0,0,.76),rgba(0,0,0,.38)),url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1800&q=80') center/cover;">
        <div class="container">
            <span class="kicker">VERDE PARIS 75</span>
            <h1>Photos</h1>
            <div class="hero-sub">Nos plus belles realisations en images</div>
            <div class="hero-btns">
                <a class="btn btn-green" href="#galerie">Voir la galerie</a>
                <a class="btn btn-white" href="{{ route('contact') }}">Demander un devis</a>
            </div>
        </div>
    </section>

    <section id="galerie">
        <div class="section-title">
            <h2>Nos realisations</h2>
            <p>Decouvrez une selection de chantiers realises par VERDE PARIS 75 : VRD, terrassement, assainissement, reseaux divers, espaces verts, mobilier urbain et revetements.</p>
        </div>

        {{-- Category filters --}}
        <div class="filters">
            <a href="{{ route('gallery', array_merge(request()->except('category', 'page'), [])) }}" class="{{ !$category ? 'active' : '' }}">Tous</a>
            @foreach($categories as $cat)
            <a href="{{ route('gallery', array_merge(request()->except('page'), ['category' => $cat])) }}" class="{{ $category == $cat ? 'active' : '' }}">{{ $cat }}</a>
            @endforeach
        </div>

        {{-- Sort bar --}}
        <div class="sortbar">
            <a href="{{ route('gallery', array_merge(request()->except('sort', 'page'), ['sort' => 'recent'])) }}" class="{{ $sort == 'recent' ? 'active' : '' }}">Plus recentes</a>
            <a href="{{ route('gallery', array_merge(request()->except('sort', 'page'), ['sort' => 'views'])) }}" class="{{ $sort == 'views' ? 'active' : '' }}">Plus vues</a>
            <a href="{{ route('gallery', array_merge(request()->except('sort', 'page'), ['sort' => 'likes'])) }}" class="{{ $sort == 'likes' ? 'active' : '' }}">Plus aimees</a>
            <a href="{{ route('gallery', array_merge(request()->except('sort', 'page'), ['sort' => 'featured'])) }}" class="{{ $sort == 'featured' ? 'active' : '' }}">Mises en avant</a>
        </div>

        {{-- Featured photos --}}
        @if($featured->count() && !$category && $sort == 'recent')
        <div class="featured-grid">
            @foreach($featured as $feat)
            <a class="featured-card" href="#" data-bs-toggle="modal" data-bs-target="#photoModal" onclick="showPhoto('{{ asset('storage/' . $feat->image) }}', '{{ addslashes($feat->title ?? '') }}', '{{ addslashes($feat->description ?? '') }}'); trackView({{ $feat->id }})">
                <img src="{{ asset('storage/' . ($feat->thumbnail ?? $feat->image)) }}" alt="{{ $feat->title }}">
                <div class="featured-info">
                    @if($feat->category)
                    <span>{{ $feat->category }}</span>
                    @endif
                    <h3>{{ $feat->title ?? 'Photo' }}</h3>
                    <div class="statsline">
                        <b class="stat-badge"><i class="bi bi-eye"></i> {{ number_format($feat->views) }} vues</b>
                        <b class="stat-badge"><i class="bi bi-heart-fill"></i> {{ number_format($feat->likes) }} likes</b>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @endif

        {{-- Photo grid --}}
        @if($photos->count())
        <div class="grid">
            @foreach($photos as $photo)
            <div class="photo-card">
                <img src="{{ asset('storage/' . ($photo->thumbnail ?? $photo->image)) }}" alt="{{ $photo->title ?? 'Photo' }}" data-bs-toggle="modal" data-bs-target="#photoModal" onclick="showPhoto('{{ asset('storage/' . $photo->image) }}', '{{ addslashes($photo->title ?? '') }}', '{{ addslashes($photo->description ?? '') }}'); trackView({{ $photo->id }})">
                <div class="card-content">
                    @if($photo->category)
                    <span class="cat">{{ $photo->category }}</span>
                    @endif
                    <h3>{{ $photo->title ?? 'Photo' }}</h3>
                    @if($photo->description)
                    <p>{{ Str::limit($photo->description, 80) }}</p>
                    @endif
                    <div class="card-actions">
                        <button class="like-btn" onclick="likePhoto({{ $photo->id }}, this)" data-photo="{{ $photo->id }}">
                            <i class="bi bi-heart-fill"></i> <span>{{ $photo->likes > 0 ? $photo->likes : "J'aime" }}</span>
                        </button>
                        <b class="views-count"><i class="bi bi-eye"></i> {{ number_format($photo->views) }}</b>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $photos->links() }}
        </div>
        @else
        <div style="text-align:center;padding:60px 0;">
            <i class="bi bi-images" style="font-size:3rem;color:#0E7A32;opacity:.3;"></i>
            <p style="color:#999;margin-top:15px;">Aucune photo dans cette categorie.</p>
        </div>
        @endif
    </section>

    <section class="cta-section">
        <h3>Vous avez un projet VRD ou espaces verts ?</h3>
        <p>Contactez VERDE PARIS 75 pour une etude personnalisee.</p>
        <a href="{{ route('contact') }}" class="btn btn-white" style="color:#0E7A32;">Demander un devis</a>
    </section>

    {{-- Photo lightbox modal --}}
    <div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark border-0">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title text-white" id="photoTitle"></h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body text-center p-2">
                    <img id="photoImage" src="" alt="" class="img-fluid rounded" style="max-height:75vh;object-fit:contain;">
                    <p id="photoDesc" class="text-white-50 mt-2 mb-0" style="font-size:.9rem;"></p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function showPhoto(src, title, desc) {
        document.getElementById('photoImage').src = src;
        document.getElementById('photoImage').alt = title;
        document.getElementById('photoTitle').textContent = title;
        document.getElementById('photoDesc').textContent = desc;
        document.getElementById('photoDesc').style.display = desc ? '' : 'none';
    }

    function likePhoto(id, btn) {
        fetch('/galerie/' + id + '/like', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            btn.classList.add('active');
            btn.querySelector('span').textContent = data.likes;
        });
    }

    function trackView(id) {
        fetch('/galerie/' + id + '/view', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
    }
</script>
@endsection
