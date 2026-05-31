@extends('layouts.public')
@section('title', $meta['title'])

@section('meta_description', $meta['description'])

@section('styles')
<style>
    .seo-sections { max-width: 1200px; margin: auto; padding: 60px 24px; }
    .seo-section { margin-bottom: 40px; }
    .seo-section h2 { font-size: 28px; color: #0E7A32; margin: 0 0 12px; font-weight: 700; }
    .seo-section p { font-size: 17px; line-height: 1.8; color: #555; }
</style>
<link rel="canonical" href="{{ $meta['canonical'] }}">
<meta name="robots" content="{{ $meta['robots'] }}">
<meta property="og:title" content="{{ $meta['title'] }}">
<meta property="og:description" content="{{ $meta['description'] }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $meta['canonical'] }}">
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endsection

@section('content')
<div class="hero hero-mini" style="background-image:url('{{ asset('images/hero-bg.jpg') }}');">
    <div class="container">
        <h1>{{ $page->h1 ?: $page->title }}</h1>
        <p>{{ $page->meta_description }}</p>
        <div class="hero-btns">
            <a href="{{ route('contact') }}" class="btn btn-green">Demander un devis</a>
            <a href="{{ route('services') }}" class="btn btn-white">Nos services</a>
        </div>
    </div>
</div>

<div class="seo-sections">
    @foreach(($page->sections ?? []) as $section)
    <article class="seo-section">
        <h2>{{ $section['title'] ?? '' }}</h2>
        <p>{!! nl2br(e($section['content'] ?? '')) !!}</p>
    </article>
    @endforeach
</div>

<div class="cta-section">
    <h3>Besoin d'un devis ?</h3>
    <p>Contactez VERDE PARIS 75 pour etudier votre projet et obtenir une estimation adaptee.</p>
    <a href="{{ route('contact') }}" class="btn btn-gold">Nous contacter</a>
</div>
@endsection
