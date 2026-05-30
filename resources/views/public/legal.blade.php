@extends('layouts.public')

@section('title', ($page->meta_title ?? $page->title) . ' - ' . Setting::get('site_name', 'VERDE PARIS 75'))

@if($page->meta_description)
@section('meta_description', $page->meta_description)
@endif

@section('content')
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb" style="font-size:.85rem;">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color:#0E7A32;">Accueil</a></li>
                            <li class="breadcrumb-item active text-muted">{{ $page->title }}</li>
                        </ol>
                    </nav>

                    <div class="card" style="padding:30px;">
                        <h1 style="color:#0b5e25;font-weight:700;font-size:1.8rem;margin-bottom:25px;padding-bottom:15px;border-bottom:3px solid #0E7A32;">
                            {{ $page->title }}
                        </h1>
                        <div style="line-height:1.8;color:#1f2937;">
                            {!! $page->content !!}
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-outline">
                            <i class="bi bi-arrow-left" style="margin-right:5px;"></i> Retour a l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
