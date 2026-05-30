@extends('layouts.admin')
@section('title', "Page d'accueil")

@section('content')
<div class="row g-4">
    @php
        $sectionLabels = [
            'hero' => ['label' => 'Hero / Banniere', 'icon' => 'bi-display', 'desc' => 'Banniere principale avec image de fond et texte d\'accroche'],
            'about' => ['label' => 'A propos', 'icon' => 'bi-info-circle', 'desc' => 'Presentation de l\'entreprise'],
            'services_preview' => ['label' => 'Apercu des services', 'icon' => 'bi-gear', 'desc' => 'Section mettant en avant les principaux services'],
            'projects_preview' => ['label' => 'Apercu des realisations', 'icon' => 'bi-briefcase', 'desc' => 'Galerie des realisations recentes'],
            'testimonials' => ['label' => 'Temoignages', 'icon' => 'bi-chat-quote', 'desc' => 'Avis et temoignages des clients'],
            'cta' => ['label' => 'Appel a l\'action', 'icon' => 'bi-megaphone', 'desc' => 'Section d\'incitation a prendre contact'],
            'stats' => ['label' => 'Statistiques', 'icon' => 'bi-graph-up', 'desc' => 'Chiffres cles de l\'entreprise'],
        ];
    @endphp

    @foreach($sectionLabels as $key => $meta)
        @php $section = $sections[$key] ?? null; @endphp
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi {{ $meta['icon'] }} me-2" style="font-size:1.5rem; color:var(--vp-green);"></i>
                        <h6 class="mb-0">{{ $meta['label'] }}</h6>
                    </div>
                    <p class="text-muted small mb-3">{{ $meta['desc'] }}</p>
                    @if($section)
                        <div class="mb-2">
                            @if($section->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                        </div>
                    @else
                        <span class="badge bg-warning text-dark">Non configure</span>
                    @endif
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin.homepage.edit', $key) }}" class="btn btn-sm btn-vp w-100">
                        <i class="bi bi-pencil me-1"></i> Modifier
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
