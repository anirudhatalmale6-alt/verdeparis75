@extends('layouts.public')

@section('title', 'Galerie Photos - ' . Setting::get('site_name', 'VerdeParis75'))

@section('styles')
<style>
    .gallery-grid {
        columns: 3;
        column-gap: 16px;
    }
    .gallery-item {
        break-inside: avoid;
        margin-bottom: 16px;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        cursor: pointer;
    }
    .gallery-item img {
        width: 100%;
        display: block;
        transition: transform .5s;
    }
    .gallery-item:hover img {
        transform: scale(1.05);
    }
    .gallery-item .gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(27,67,50,.7) 0%, transparent 50%);
        opacity: 0;
        transition: opacity .3s;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 15px;
        color: #fff;
    }
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    .gallery-item .gallery-overlay h6 {
        font-weight: 600;
        margin-bottom: 2px;
        font-size: .9rem;
    }
    .gallery-item .gallery-overlay small {
        opacity: .8;
        font-size: .75rem;
    }
    @media (max-width: 991px) {
        .gallery-grid { columns: 2; }
    }
    @media (max-width: 575px) {
        .gallery-grid { columns: 1; }
    }
</style>
@endsection

@section('content')
    {{-- ── Hero ── --}}
    <section class="hero-section hero-mini" style="background-image: url('{{ asset('images/gallery-hero.jpg') }}');">
        <div class="container">
            <div class="hero-content text-center w-100">
                <h1>Galerie Photos</h1>
                <p>Nos plus belles r&eacute;alisations en images</p>
            </div>
        </div>
    </section>

    {{-- ── Filter + Grid ── --}}
    <section class="section-padding">
        <div class="container">
            {{-- Category Filter --}}
            @if($categories->count())
            <div class="text-center mb-4">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <button class="btn btn-sm btn-vp gallery-filter active" data-category="all">Toutes</button>
                    @foreach($categories as $category)
                    <button class="btn btn-sm btn-vp-outline gallery-filter" data-category="{{ Str::slug($category) }}">{{ $category }}</button>
                    @endforeach
                </div>
            </div>
            @endif

            @if($photos->count())
            <div class="gallery-grid" id="galleryGrid">
                @foreach($photos as $photo)
                <div class="gallery-item" data-category="{{ $photo->category ? Str::slug($photo->category) : '' }}" data-bs-toggle="modal" data-bs-target="#photoModal" onclick="showPhoto('{{ asset('storage/' . $photo->image) }}', '{{ addslashes($photo->title ?? '') }}', '{{ addslashes($photo->description ?? '') }}')">
                    <img src="{{ asset('storage/' . ($photo->thumbnail ?? $photo->image)) }}" alt="{{ $photo->title ?? 'Photo' }}" loading="lazy">
                    <div class="gallery-overlay">
                        @if($photo->title)
                        <h6>{{ $photo->title }}</h6>
                        @endif
                        @if($photo->category)
                        <small>{{ $photo->category }}</small>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-5">
                {{ $photos->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-images" style="font-size: 3rem; color: var(--vp-green-light); opacity: .4;"></i>
                <p class="text-muted mt-3">La galerie sera bient&ocirc;t disponible.</p>
            </div>
            @endif
        </div>
    </section>

    {{-- ── Photo Modal ── --}}
    <div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark border-0">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title text-white" id="photoTitle"></h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body text-center p-2">
                    <img id="photoImage" src="" alt="" class="img-fluid rounded" style="max-height: 75vh; object-fit: contain;">
                    <p id="photoDesc" class="text-white-50 mt-2 mb-0" style="font-size: .9rem;"></p>
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

    // Category filter
    document.querySelectorAll('.gallery-filter').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var cat = this.getAttribute('data-category');

            document.querySelectorAll('.gallery-filter').forEach(function(b) {
                b.classList.remove('active', 'btn-vp');
                b.classList.add('btn-vp-outline');
            });
            this.classList.remove('btn-vp-outline');
            this.classList.add('active', 'btn-vp');

            document.querySelectorAll('.gallery-item').forEach(function(item) {
                if (cat === 'all' || item.getAttribute('data-category') === cat) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
