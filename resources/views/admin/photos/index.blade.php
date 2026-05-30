@extends('layouts.admin')
@section('title', 'Galerie Photos')

@section('actions')
    <a href="{{ route('admin.photos.create') }}" class="btn btn-vp">
        <i class="bi bi-plus-circle me-1"></i> Ajouter une photo
    </a>
@endsection

@section('content')
<div class="row g-3">
    @forelse($photos as $photo)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100">
                @if($photo->image)
                    <img src="{{ asset('storage/uploads/photos/' . $photo->image) }}" class="card-img-top" alt="{{ $photo->title }}" style="height:180px; object-fit:cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:180px;">
                        <i class="bi bi-image text-muted" style="font-size:3rem;"></i>
                    </div>
                @endif
                <div class="card-body p-2">
                    <h6 class="card-title mb-1" style="font-size:.85rem;">{{ $photo->title }}</h6>
                    @if($photo->category)
                        <span class="badge badge-vp" style="font-size:.7rem;">{{ $photo->category }}</span>
                    @endif
                </div>
                <div class="card-footer bg-transparent border-0 p-2 d-flex justify-content-between align-items-center">
                    @if($photo->is_active)
                        <span class="badge bg-success" style="font-size:.65rem;">Actif</span>
                    @else
                        <span class="badge bg-secondary" style="font-size:.65rem;">Inactif</span>
                    @endif
                    <div>
                        <a href="{{ route('admin.photos.edit', $photo) }}" class="btn btn-sm btn-vp-outline" title="Modifier">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.photos.destroy', $photo) }}" class="d-inline" onsubmit="return confirm('Supprimer cette photo ?')">
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
    @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center text-muted py-4">
                    Aucune photo enregistree
                </div>
            </div>
        </div>
    @endforelse
</div>

@if($photos->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {{ $photos->links() }}
    </div>
@endif
@endsection
