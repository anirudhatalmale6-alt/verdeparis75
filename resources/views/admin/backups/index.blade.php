@extends('layouts.admin')
@section('title', 'Sauvegardes')

@section('actions')
    <form method="POST" action="{{ route('admin.backups.create') }}" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-vp" onclick="return confirm('Creer une nouvelle sauvegarde ?')">
            <i class="bi bi-plus-circle me-1"></i> Creer une sauvegarde
        </button>
    </form>
@endsection

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th>Nom du fichier</th>
                    <th>Type</th>
                    <th>Taille</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($backups as $backup)
                    <tr>
                        <td>
                            <i class="bi bi-file-earmark-zip me-1"></i>
                            {{ $backup->filename }}
                        </td>
                        <td>
                            @if($backup->type === 'full')
                                <span class="badge badge-vp">Complet</span>
                            @elseif($backup->type === 'database')
                                <span class="badge bg-info text-dark">Base de donnees</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($backup->type) }}</span>
                            @endif
                        </td>
                        <td>{{ $backup->human_filesize ?? '—' }}</td>
                        <td>{{ $backup->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.backups.download', $backup) }}" class="btn btn-sm btn-vp-outline" title="Telecharger">
                                <i class="bi bi-download"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.backups.destroy', $backup) }}" class="d-inline" onsubmit="return confirm('Supprimer cette sauvegarde ?')">
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
                        <td colspan="5" class="text-center text-muted py-4">Aucune sauvegarde disponible</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(method_exists($backups, 'hasPages') && $backups->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {{ $backups->links() }}
    </div>
@endif
@endsection
