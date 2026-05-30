@extends('layouts.admin')
@section('title', 'Realisations')

@section('actions')
    <a href="{{ route('admin.projects.create') }}" class="btn btn-vp">
        <i class="bi bi-plus-circle me-1"></i> Ajouter une realisation
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Categorie</th>
                    <th>Vedette</th>
                    <th>Actif</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td>
                            @if($project->cover_image)
                                <img src="{{ asset('storage/uploads/projects/' . $project->cover_image) }}" class="img-thumb" alt="{{ $project->title }}">
                            @else
                                <span class="text-muted"><i class="bi bi-image" style="font-size:1.5rem;"></i></span>
                            @endif
                        </td>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->category ?? '—' }}</td>
                        <td>
                            @if($project->is_featured)
                                <i class="bi bi-star-fill text-warning"></i>
                            @else
                                <i class="bi bi-star text-muted"></i>
                            @endif
                        </td>
                        <td>
                            @if($project->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-vp-outline" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="d-inline" onsubmit="return confirm('Supprimer cette realisation ?')">
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
                        <td colspan="6" class="text-center text-muted py-4">Aucune realisation enregistree</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($projects->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {{ $projects->links() }}
    </div>
@endif
@endsection
