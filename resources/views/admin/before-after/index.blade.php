@extends('layouts.admin')
@section('title', 'Avant / Apres')

@section('actions')
    <a href="{{ route('admin.before-after.create') }}" class="btn btn-vp">
        <i class="bi bi-plus-circle me-1"></i> Ajouter
    </a>
@endsection

@section('content')
<div class="row g-4">
    @forelse($items as $item)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-3">{{ $item->title }}</h6>
                    <div class="row g-2 mb-3">
                        <div class="col-6 text-center">
                            <small class="text-muted d-block mb-1">Avant</small>
                            @if($item->before_image)
                                <img src="{{ asset('storage/uploads/before-after/' . $item->before_image) }}" class="img-fluid rounded" alt="Avant" style="height:120px; width:100%; object-fit:cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:120px;">
                                    <i class="bi bi-image text-muted" style="font-size:2rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-6 text-center">
                            <small class="text-muted d-block mb-1">Apres</small>
                            @if($item->after_image)
                                <img src="{{ asset('storage/uploads/before-after/' . $item->after_image) }}" class="img-fluid rounded" alt="Apres" style="height:120px; width:100%; object-fit:cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:120px;">
                                    <i class="bi bi-image text-muted" style="font-size:2rem;"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        @if($item->is_active)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-secondary">Inactif</span>
                        @endif
                        <div>
                            <a href="{{ route('admin.before-after.edit', $item) }}" class="btn btn-sm btn-vp-outline" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.before-after.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Supprimer cet element ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center text-muted py-4">
                    Aucune comparaison avant/apres enregistree
                </div>
            </div>
        </div>
    @endforelse
</div>

@if($items->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {{ $items->links() }}
    </div>
@endif
@endsection
