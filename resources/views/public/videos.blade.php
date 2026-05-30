@extends('layouts.public')

@section('title', 'Videos - ' . Setting::get('site_name', 'VERDE PARIS 75'))

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
    .play-overlay{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:72px;height:72px;border-radius:50%;background:rgba(14,122,50,.92);display:flex;align-items:center;justify-content:center;font-size:28px;color:white;box-shadow:0 10px 28px rgba(0,0,0,.32);transition:transform .3s}
    .play-overlay.small{width:54px;height:54px;font-size:20px}
    .featured-card:hover .play-overlay,.video-card:hover .play-overlay{transform:translate(-50%,-50%) scale(1.1)}
    .video-card{background:white;border-radius:22px;overflow:hidden;box-shadow:0 13px 32px rgba(0,0,0,.10);position:relative}
    .video-card .thumb{position:relative;overflow:hidden;cursor:pointer;display:block}
    .video-card img{width:100%;height:255px;object-fit:cover;display:block;transition:transform .35s}
    .video-card:hover img{transform:scale(1.05)}
    .video-card .card-content{padding:22px}
    .video-card .card-content .cat{color:#0E7A32;font-size:12px;text-transform:uppercase;font-weight:900}
    .video-card .card-content h3{font-size:23px;margin:7px 0 8px;color:#1f2937}
    .video-card .card-content p{margin:0 0 14px;color:#666}
    .card-actions{display:flex;justify-content:space-between;align-items:center;border-top:1px solid #eef2ee;padding-top:14px}
    .like-btn{border:0;background:#f0f8f2;color:#0E7A32;border-radius:999px;padding:9px 13px;font-weight:900;cursor:pointer;transition:background .2s,color .2s}
    .like-btn:hover,.like-btn.active{background:#0E7A32;color:white}
    .views-count{font-weight:900;color:#374151}
    .video-embed-wrapper{position:relative;padding-bottom:56.25%;height:0;overflow:hidden}
    .video-embed-wrapper iframe{position:absolute;top:0;left:0;width:100%;height:100%;border:0}
    @media(max-width:991px){.featured-grid{grid-template-columns:1fr 1fr}.grid{grid-template-columns:1fr 1fr}}
    @media(max-width:575px){.featured-grid{grid-template-columns:1fr}.grid{grid-template-columns:1fr}.filters{gap:6px}.filters a{padding:8px 12px;font-size:13px}}
</style>
@endsection

@section('content')
    <section class="hero" style="background:linear-gradient(90deg,rgba(0,0,0,.76),rgba(0,0,0,.38)),url('https://images.unsplash.com/photo-1605092676920-6fb7f258b9e2?auto=format&fit=crop&w=1800&q=80') center/cover;">
        <div class="container">
            <span class="kicker">VERDE PARIS 75</span>
            <h1>Nos Videos</h1>
            <div class="hero-sub">Decouvrez nos realisations en video</div>
            <div class="hero-btns">
                <a class="btn btn-green" href="#videos">Voir les videos</a>
                <a class="btn btn-white" href="{{ route('contact') }}">Demander un devis</a>
            </div>
        </div>
    </section>

    <section id="videos">
        <div class="section-title">
            <h2>Realisations en video</h2>
            <p>Decouvrez nos chantiers et interventions : VRD, terrassement, assainissement, reseaux divers, espaces verts et mobilier urbain.</p>
        </div>

        {{-- Category filters --}}
        <div class="filters">
            <a href="{{ route('videos', array_merge(request()->except('category', 'page'), [])) }}" class="{{ !$category ? 'active' : '' }}">Tous</a>
            @foreach($categories as $cat)
            <a href="{{ route('videos', array_merge(request()->except('page'), ['category' => $cat])) }}" class="{{ $category == $cat ? 'active' : '' }}">{{ $cat }}</a>
            @endforeach
        </div>

        {{-- Sort bar --}}
        <div class="sortbar">
            <a href="{{ route('videos', array_merge(request()->except('sort', 'page'), ['sort' => 'recent'])) }}" class="{{ $sort == 'recent' ? 'active' : '' }}">Plus recentes</a>
            <a href="{{ route('videos', array_merge(request()->except('sort', 'page'), ['sort' => 'views'])) }}" class="{{ $sort == 'views' ? 'active' : '' }}">Plus vues</a>
            <a href="{{ route('videos', array_merge(request()->except('sort', 'page'), ['sort' => 'likes'])) }}" class="{{ $sort == 'likes' ? 'active' : '' }}">Plus aimees</a>
            <a href="{{ route('videos', array_merge(request()->except('sort', 'page'), ['sort' => 'featured'])) }}" class="{{ $sort == 'featured' ? 'active' : '' }}">Mises en avant</a>
        </div>

        {{-- Featured videos --}}
        @if($featured->count() && !$category && $sort == 'recent')
        <div class="featured-grid">
            @foreach($featured as $feat)
            <a class="featured-card" href="#" data-bs-toggle="modal" data-bs-target="#videoModal" onclick="playVideo('{{ $feat->embed_url }}', '{{ addslashes($feat->title ?? '') }}'); trackVideoView({{ $feat->id }})">
                @if($feat->thumbnail)
                <img src="{{ asset('storage/' . $feat->thumbnail) }}" alt="{{ $feat->title }}">
                @else
                <div style="width:100%;height:350px;background:linear-gradient(135deg,#0b5e25,#0E7A32);"></div>
                @endif
                <div class="play-overlay"><i class="bi bi-play-fill"></i></div>
                <div class="featured-info">
                    @if($feat->category)
                    <span>{{ $feat->category }}</span>
                    @endif
                    <h3>{{ $feat->title ?? 'Video' }}</h3>
                    <div class="statsline">
                        <b class="stat-badge"><i class="bi bi-eye"></i> {{ number_format($feat->views) }} vues</b>
                        <b class="stat-badge"><i class="bi bi-heart-fill"></i> {{ number_format($feat->likes) }} likes</b>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @endif

        {{-- Video grid --}}
        @if($videos->count())
        <div class="grid">
            @foreach($videos as $video)
            <div class="video-card">
                <div class="thumb" data-bs-toggle="modal" data-bs-target="#videoModal" onclick="playVideo('{{ $video->embed_url }}', '{{ addslashes($video->title ?? '') }}'); trackVideoView({{ $video->id }})">
                    @if($video->thumbnail)
                    <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->title ?? 'Video' }}">
                    @else
                    <div style="width:100%;height:255px;background:linear-gradient(135deg,#0b5e25,#0E7A32);display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-play-circle" style="font-size:3rem;color:rgba(255,255,255,.4);"></i>
                    </div>
                    @endif
                    <div class="play-overlay small"><i class="bi bi-play-fill"></i></div>
                </div>
                <div class="card-content">
                    @if($video->category)
                    <span class="cat">{{ $video->category }}</span>
                    @endif
                    <h3>{{ $video->title ?? 'Video' }}</h3>
                    @if($video->description)
                    <p>{{ Str::limit($video->description, 80) }}</p>
                    @endif
                    <div class="card-actions">
                        <button class="like-btn" onclick="likeVideo({{ $video->id }}, this)" data-video="{{ $video->id }}">
                            <i class="bi bi-heart-fill"></i> <span>{{ $video->likes > 0 ? $video->likes : "J'aime" }}</span>
                        </button>
                        <b class="views-count"><i class="bi bi-eye"></i> {{ number_format($video->views) }}</b>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $videos->links() }}
        </div>
        @else
        <div style="text-align:center;padding:60px 0;">
            <i class="bi bi-play-circle" style="font-size:3rem;color:#0E7A32;opacity:.3;"></i>
            <p style="color:#999;margin-top:15px;">Aucune video dans cette categorie.</p>
        </div>
        @endif
    </section>

    <section class="cta-section">
        <h3>Vous avez un projet VRD ou espaces verts ?</h3>
        <p>Contactez VERDE PARIS 75 pour une etude personnalisee.</p>
        <a href="{{ route('contact') }}" class="btn btn-white" style="color:#0E7A32;">Demander un devis</a>
    </section>

    {{-- Video player modal --}}
    <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark border-0">
                <div class="modal-header border-0">
                    <h6 class="modal-title text-white" id="videoTitle"></h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="video-embed-wrapper">
                        <iframe id="videoFrame" src="" allowfullscreen allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function playVideo(url, title) {
        document.getElementById('videoFrame').src = url + '?autoplay=1';
        document.getElementById('videoTitle').textContent = title;
    }

    document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('videoFrame').src = '';
    });

    function likeVideo(id, btn) {
        fetch('/videos/' + id + '/like', {
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

    function trackVideoView(id) {
        fetch('/videos/' + id + '/view', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });
    }
</script>
@endsection
