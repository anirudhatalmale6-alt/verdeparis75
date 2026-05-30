@extends('layouts.admin')
@section('title', 'Temoignages')

@section('actions')
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-vp">
        <i class="bi bi-plus-circle me-1"></i> Ajouter un temoignage
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Lieu</th>
                    <th>Note</th>
                    <th>Actif</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $testimonial)
                    <tr>
                        <td>{{ $testimonial->client_name }}</td>
                        <td>{{ $testimonial->client_location ?? '—' }}</td>
                        <td>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $testimonial->rating)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @else
                                    <i class="bi bi-star text-muted"></i>
                                @endif
                            @endfor
                        </td>
                        <td>
                            @if($testimonial->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-vp-outline" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" class="d-inline" onsubmit="return confirm('Supprimer ce temoignage ?')">
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
                        <td colspan="5" class="text-center text-muted py-4">Aucun temoignage enregistre</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($testimonials->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {{ $testimonials->links() }}
    </div>
@endif
@endsection
