@extends('layouts.public')

@section('title', 'Galerie Photos - ' . Setting::get('site_name', 'VERDE PARIS 75'))

@section('styles')
<style>
    .gallery-grid{columns:3;column-gap:16px;max-width:1200px;margin:auto}
    .gallery-item{break-inside:avoid;margin-bottom:16px;border-radius:10px;overflow:hidden;position:relative;cursor:pointer}
    .gallery-item img{width:100%;display:block;transition:transform .5s}
    .gallery-item:hover img{transform:scale(1.05)}
    .gallery-item .gallery-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(27,67,50,.7) 0%,transparent 50%);opacity:0;transition:opacity .3s;display:flex;flex-direction:column;justify-content:flex-end;padding:15px;color:#fff}
    .gallery-item:hover .gallery-overlay{opacity:1}
    .gallery-item .gallery-overlay h6{font-weight:600;margin-bottom:2px;font-size:.9rem}
    .gallery-item .gallery-overlay small{opacity:.8;font-size:.75rem}
    @media(max-width:991px){.gallery-grid{columns:2}}
    @media(max-width:575px){.gallery-grid{columns:1}}
</style>
@endsection

@section('content')
    <section class="hero hero-mini" style="background-image: url('https://images.unsplash.com/photo-1584467541268-b040f83be3fd?auto=format&fit=crop&w=1800&q=80');">
        <div class="container" style="text-align:center;">
            <h1>Galerie Photos</h1>
            <p style="margin:auto;">Nos plus belles realisations en images</p>
        </div>
    </section>

    <section>
        <div class="container">
            @if($categories->count())
            <div style="text-align:center;margin-bottom:30px;">
                <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:8px;">
                    <button class="btn btn-green btn-sm gallery-filter active" data-category="all">Toutes</button>
                    @foreach($categories as $category)
                    <button class="btn btn-outline btn-sm gallery-filter" data-category="{{ Str::slug($category) }}">{{ $category }}</button>
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

            <div class="d-flex justify-content-center mt-5">
                {{ $photos->links() }}
            </div>
            @else
            <div style="text-align:center;padding:60px 0;">
                <i class="bi bi-images" style="font-size:3rem;color:#0E7A32;opacity:.3;"></i>
                <p style="color:#999;margin-top:15px;">La galerie sera bientot disponible.</p>
            </div>
            @endif
        </div>
    </section>

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
    document.querySelectorAll('.gallery-filter').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var cat = this.getAttribute('data-category');
            document.querySelectorAll('.gallery-filter').forEach(function(b) {
                b.classList.remove('active');
                b.className = b.className.replace('btn-green', 'btn-outline');
            });
            this.classList.add('active');
            this.className = this.className.replace('btn-outline', 'btn-green');
            document.querySelectorAll('.gallery-item').forEach(function(item) {
                item.style.display = (cat === 'all' || item.getAttribute('data-category') === cat) ? '' : 'none';
            });
        });
    });
</script>
@endsection
