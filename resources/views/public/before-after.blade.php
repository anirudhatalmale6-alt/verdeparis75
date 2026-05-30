@extends('layouts.public')

@section('title', 'Avant / Apr&egrave;s - ' . Setting::get('site_name', 'VerdeParis75'))

@section('styles')
<style>
    .ba-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 15px rgba(0,0,0,.06);
        transition: transform .3s, box-shadow .3s;
    }
    .ba-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,.1);
    }
    .ba-slider {
        position: relative;
        overflow: hidden;
        height: 300px;
        cursor: col-resize;
        user-select: none;
    }
    .ba-slider img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .ba-slider .ba-after {
        clip-path: inset(0 50% 0 0);
        z-index: 2;
    }
    .ba-slider .ba-before {
        z-index: 1;
    }
    .ba-slider .ba-handle {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 50%;
        width: 4px;
        background: var(--vp-gold);
        z-index: 3;
        transform: translateX(-50%);
    }
    .ba-slider .ba-handle::before {
        content: '\F285';
        font-family: 'bootstrap-icons';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        background: var(--vp-gold);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,.25);
    }
    .ba-slider .ba-label {
        position: absolute;
        bottom: 10px;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: .75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .5px;
        z-index: 4;
        color: #fff;
    }
    .ba-slider .ba-label-before {
        right: 10px;
        background: rgba(0,0,0,.5);
    }
    .ba-slider .ba-label-after {
        left: 10px;
        background: var(--vp-green);
    }
</style>
@endsection

@section('content')
    {{-- ── Hero ── --}}
    <section class="hero-section hero-mini" style="background-image: url('{{ asset('images/before-after-hero.jpg') }}');">
        <div class="container">
            <div class="hero-content text-center w-100">
                <h1>Avant / Apr&egrave;s</h1>
                <p>La transformation de vos espaces verts en images</p>
            </div>
        </div>
    </section>

    {{-- ── Grid ── --}}
    <section class="section-padding">
        <div class="container">
            @if($items->count())
            <div class="row g-4">
                @foreach($items as $item)
                <div class="col-lg-6">
                    <div class="ba-card">
                        <div class="ba-slider" data-ba-slider>
                            <img src="{{ asset('storage/' . $item->before_image) }}" alt="Avant - {{ $item->title }}" class="ba-before">
                            <img src="{{ asset('storage/' . $item->after_image) }}" alt="Apr&egrave;s - {{ $item->title }}" class="ba-after">
                            <div class="ba-handle"></div>
                            <span class="ba-label ba-label-after">Apr&egrave;s</span>
                            <span class="ba-label ba-label-before">Avant</span>
                        </div>
                        <div class="p-3">
                            <h5 style="color: var(--vp-green-dark); font-weight: 600; margin-bottom: 5px;">{{ $item->title }}</h5>
                            @if($item->description)
                            <p class="text-muted mb-0" style="font-size: .9rem;">{{ $item->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-arrows-angle-expand" style="font-size: 3rem; color: var(--vp-green-light); opacity: .4;"></i>
                <p class="text-muted mt-3">Les transformations seront bient&ocirc;t disponibles.</p>
            </div>
            @endif
        </div>
    </section>

    {{-- ── CTA ── --}}
    <section class="cta-section">
        <div class="container">
            <h3>Envie d'une transformation similaire ?</h3>
            <p>Contactez-nous pour donner vie &agrave; votre projet.</p>
            <a href="{{ route('contact') }}" class="btn btn-vp-gold btn-lg">
                <i class="bi bi-envelope me-2"></i>Nous Contacter
            </a>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Before/After slider interaction
    document.querySelectorAll('[data-ba-slider]').forEach(function(slider) {
        var isDragging = false;

        function updateSlider(x) {
            var rect = slider.getBoundingClientRect();
            var pos = Math.max(0, Math.min(1, (x - rect.left) / rect.width));
            var pct = pos * 100;
            var afterImg = slider.querySelector('.ba-after');
            var handle = slider.querySelector('.ba-handle');
            afterImg.style.clipPath = 'inset(0 ' + (100 - pct) + '% 0 0)';
            handle.style.left = pct + '%';
        }

        slider.addEventListener('mousedown', function(e) {
            isDragging = true;
            updateSlider(e.clientX);
            e.preventDefault();
        });
        document.addEventListener('mousemove', function(e) {
            if (isDragging) updateSlider(e.clientX);
        });
        document.addEventListener('mouseup', function() {
            isDragging = false;
        });

        // Touch support
        slider.addEventListener('touchstart', function(e) {
            isDragging = true;
            updateSlider(e.touches[0].clientX);
        }, { passive: true });
        document.addEventListener('touchmove', function(e) {
            if (isDragging) updateSlider(e.touches[0].clientX);
        }, { passive: true });
        document.addEventListener('touchend', function() {
            isDragging = false;
        });
    });
</script>
@endsection
