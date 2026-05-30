@extends('layouts.public')

@section('title', ($page->meta_title ?? $page->title) . ' - ' . Setting::get('site_name', 'VerdeParis75'))

@if($page->meta_description)
@section('meta_description', $page->meta_description)
@endif

@section('content')
    {{-- ── Spacer for fixed navbar ── --}}
    <div class="page-hero-spacer"></div>

    {{-- ── Content ── --}}
    <section class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    {{-- Breadcrumb --}}
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb" style="font-size: .85rem;">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--vp-green);">Accueil</a></li>
                            <li class="breadcrumb-item active text-muted">{{ $page->title }}</li>
                        </ol>
                    </nav>

                    <div class="card card-vp p-4 p-md-5">
                        <h1 style="color: var(--vp-green-dark); font-weight: 700; font-size: 1.8rem; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 3px solid var(--vp-green);">
                            {{ $page->title }}
                        </h1>
                        <div class="content-body" style="line-height: 1.8; color: var(--vp-text);">
                            {!! $page->content !!}
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-vp-outline">
                            <i class="bi bi-arrow-left me-1"></i> Retour &agrave; l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
