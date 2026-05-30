@extends('layouts.admin')
@section('title', 'SEO')

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th>Page</th>
                    <th>Meta titre</th>
                    <th>Meta description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $seoPages = [
                        'home' => 'Accueil',
                        'services' => 'Services',
                        'projects' => 'Realisations',
                        'gallery' => 'Galerie',
                        'videos' => 'Videos',
                        'contact' => 'Contact',
                        'partners' => 'Partenaires',
                    ];
                @endphp
                @foreach($seoPages as $key => $label)
                    @php $seo = $seoSettings[$key] ?? null; @endphp
                    <tr>
                        <td>
                            <i class="bi bi-file-earmark me-1"></i> {{ $label }}
                        </td>
                        <td>{{ $seo->meta_title ?? '—' }}</td>
                        <td>{{ Str::limit($seo->meta_description ?? '—', 60) }}</td>
                        <td>
                            <a href="{{ route('admin.seo.edit', $key) }}" class="btn btn-sm btn-vp-outline" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
