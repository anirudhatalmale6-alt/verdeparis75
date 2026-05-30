@extends('layouts.admin')
@section('title', 'Services')

@section('actions')
    <a href="{{ route('admin.services.create') }}" class="btn btn-vp">
        <i class="bi bi-plus-circle me-1"></i> Ajouter un service
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
                    <th>Ordre</th>
                    <th>Actif</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>
                            @if($service->image)
                                <img src="{{ asset('storage/uploads/services/' . $service->image) }}" class="img-thumb" alt="{{ $service->title }}">
                            @else
                                <span class="text-muted"><i class="bi bi-image" style="font-size:1.5rem;"></i></span>
                            @endif
                        </td>
                        <td>{{ $service->title }}</td>
                        <td>{{ $service->sort_order }}</td>
                        <td>
                            @if($service->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-vp-outline" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="d-inline" onsubmit="return confirm('Supprimer ce service ?')">
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
                        <td colspan="5" class="text-center text-muted py-4">Aucun service enregistre</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($services->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {{ $services->links() }}
    </div>
@endif
@endsection
