@extends('layouts.public')

@section('title', 'Videos - ' . Setting::get('site_name', 'VERDE PARIS 75'))

@section('styles')
<style>
    .video-card{border:none;border-radius:12px;overflow:hidden;background:#fff;box-shadow:0 2px 15px rgba(0,0,0,.06);transition:transform .3s,box-shadow .3s}
    .video-card:hover{transform:translateY(-5px);box-shadow:0 10px 30px rgba(0,0,0,.1)}
    .video-thumb{position:relative;height:220px;overflow:hidden;cursor:pointer}
    .video-thumb img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
    .video-card:hover .video-thumb img{transform:scale(1.05)}
    .video-thumb .play-btn{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:60px;height:60px;background:#0E7A32;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.4rem;box-shadow:0 4px 15px rgba(0,0,0,.3);transition:background .3s,transform .3s}
    .video-thumb:hover .play-btn{background:#d4a853;transform:translate(-50%,-50%) scale(1.1)}
    .video-embed-wrapper{position:relative;padding-bottom:56.25%;height:0;overflow:hidden}
    .video-embed-wrapper iframe{position:absolute;top:0;left:0;width:100%;height:100%;border:0}
</style>
@endsection

@section('content')
    <section class="hero hero-mini" style="background-image: url('https://images.unsplash.com/photo-1605092676920-6fb7f258b9e2?auto=format&fit=crop&w=1800&q=80');">
        <div class="container" style="text-align:center;">
            <h1>Nos Videos</h1>
            <p style="margin:auto;">Decouvrez nos realisations en video</p>
        </div>
    </section>

    <section>
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
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,#0b5e25,#0E7A32);display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-play-circle" style="font-size:3rem;color:rgba(255,255,255,.4);"></i>
                            </div>
                            @endif
                            <div class="play-btn">
                                <i class="bi bi-play-fill"></i>
                            </div>
                        </div>
                        <div style="padding:15px;">
                            <h6 style="color:#0b5e25;font-weight:600;">{{ $video->title }}</h6>
                            @if($video->description)
                            <p style="color:#999;font-size:.85rem;margin:0;">{{ Str::limit($video->description, 100) }}</p>
                            @endif
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
                <p style="color:#999;margin-top:15px;">Les videos seront bientot disponibles.</p>
            </div>
            @endif
        </div>
    </section>

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
</script>
@endsection
