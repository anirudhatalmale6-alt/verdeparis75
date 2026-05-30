@extends('layouts.admin')
@section('title', 'Videos')

@section('actions')
    <a href="{{ route('admin.videos.create') }}" class="btn btn-vp">
        <i class="bi bi-plus-circle me-1"></i> Ajouter une video
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Categorie</th>
                    <th>Vues / Likes</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($videos as $video)
                    <tr>
                        <td>{{ $video->title }}</td>
                        <td>
                            <span class="badge bg-info text-dark">{{ ucfirst($video->video_type) }}</span>
                        </td>
                        <td>{{ $video->category ?? '—' }}</td>
                        <td>
                            <i class="bi bi-eye"></i> {{ $video->views ?? 0 }}
                            <i class="bi bi-heart-fill ms-2"></i> {{ $video->likes ?? 0 }}
                        </td>
                        <td>
                            @if($video->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                            @if($video->is_featured)
                                <span class="badge bg-warning text-dark">Vedette</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.videos.edit', $video) }}" class="btn btn-sm btn-vp-outline" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.videos.destroy', $video) }}" class="d-inline" onsubmit="return confirm('Supprimer cette video ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Aucune video enregistree</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($videos->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {{ $videos->links() }}
    </div>
@endif
@endsection
