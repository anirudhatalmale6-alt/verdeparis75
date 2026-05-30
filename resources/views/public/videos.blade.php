@extends('layouts.public')

@section('title', 'Vid&eacute;os - ' . Setting::get('site_name', 'VerdeParis75'))

@section('styles')
<style>
    .video-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 15px rgba(0,0,0,.06);
        transition: transform .3s, box-shadow .3s;
    }
    .video-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,.1);
    }
    .video-thumb {
        position: relative;
        height: 220px;
        overflow: hidden;
        cursor: pointer;
    }
    .video-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s;
    }
    .video-card:hover .video-thumb img {
        transform: scale(1.05);
    }
    .video-thumb .play-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        background: var(--vp-green);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.4rem;
        box-shadow: 0 4px 15px rgba(0,0,0,.3);
        transition: background .3s, transform .3s;
    }
    .video-thumb:hover .play-btn {
        background: var(--vp-gold);
        transform: translate(-50%, -50%) scale(1.1);
    }
    .video-embed-wrapper {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
    }
    .video-embed-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
</style>
@endsection

@section('content')
    {{-- ── Hero ── --}}
    <section class="hero-section hero-mini" style="background-image: url('{{ asset('images/videos-hero.jpg') }}');">
        <div class="container">
            <div class="hero-content text-center w-100">
                <h1>Nos Vid&eacute;os</h1>
                <p>D&eacute;couvrez nos r&eacute;alisations en vid&eacute;o</p>
            </div>
        </div>
    </section>

    {{-- ── Videos Grid ── --}}
    <section class="section-padding">
        <div class="container">
            @if($videos->count())
            <div class="row g-4">
                @foreach($videos as $video)
                <div class="col-lg-4 col-md-6">
                    <div class="video-card h-100">
                        <div class="video-thumb" data-bs-toggle="modal" data-bs-target="#videoModal" onclick="playVideo('{{ $video->embed_url }}', '{{ addslashes($video->title) }}')">
                            @if($video->thumbnail)
                            <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->title }}">
                            @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--vp-green-dark), var(--vp-green)); display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-play-circle" style="font-size: 3rem; color: rgba(255,255,255,.4);"></i>
                            </div>
                            @endif
                            <div class="play-btn">
                                <i class="bi bi-play-fill"></i>
                            </div>
                        </div>
                        <div class="p-3">
                            <h6 style="color: var(--vp-green-dark); font-weight: 600;">{{ $video->title }}</h6>
                            @if($video->description)
                            <p class="text-muted mb-0" style="font-size: .85rem;">{{ Str::limit($video->description, 100) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-5">
                {{ $videos->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-play-circle" style="font-size: 3rem; color: var(--vp-green-light); opacity: .4;"></i>
                <p class="text-muted mt-3">Les vid&eacute;os seront bient&ocirc;t disponibles.</p>
            </div>
            @endif
        </div>
    </section>

    {{-- ── Video Modal ── --}}
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

    // Stop video when modal closes
    document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('videoFrame').src = '';
    });
</script>
@endsection
