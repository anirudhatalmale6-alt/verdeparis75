@extends('layouts.admin')
@section('title', 'Partenaires')

@section('actions')
    <a href="{{ route('admin.partners.create') }}" class="btn btn-vp">
        <i class="bi bi-plus-circle me-1"></i> Ajouter un partenaire
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Nom</th>
                    <th>Site web</th>
                    <th>Actif</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $partner)
                    <tr>
                        <td>
                            @if($partner->logo)
                                <img src="{{ asset('storage/uploads/partners/' . $partner->logo) }}" class="img-thumb" alt="{{ $partner->name }}">
                            @else
                                <span class="text-muted"><i class="bi bi-image" style="font-size:1.5rem;"></i></span>
                            @endif
                        </td>
                        <td>{{ $partner->name }}</td>
                        <td>
                            @if($partner->website)
                                <a href="{{ $partner->website }}" target="_blank" class="text-decoration-none">
                                    {{ $partner->website }} <i class="bi bi-box-arrow-up-right" style="font-size:.7rem;"></i>
                                </a>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            @if($partner->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.partners.edit', $partner) }}" class="btn btn-sm btn-vp-outline" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" class="d-inline" onsubmit="return confirm('Supprimer ce partenaire ?')">
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
                        <td colspan="5" class="text-center text-muted py-4">Aucun partenaire enregistre</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($partners->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {{ $partners->links() }}
    </div>
@endif
@endsection
