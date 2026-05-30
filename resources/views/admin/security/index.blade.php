@extends('layouts.admin')
@section('title', 'Securite — Journal d\'activite')

@section('content')
{{-- Filtre par type d'action --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('admin.security.index') }}" class="d-flex align-items-center gap-3">
            <label for="action" class="form-label mb-0 text-nowrap">Filtrer par action :</label>
            <select name="action" id="action" class="form-select form-select-sm" style="max-width:250px;">
                <option value="">Toutes les actions</option>
                @foreach($actionTypes ?? [] as $type)
                    <option value="{{ $type }}" {{ request('action') == $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-sm btn-vp">
                <i class="bi bi-funnel me-1"></i> Filtrer
            </button>
            @if(request('action'))
                <a href="{{ route('admin.security.index') }}" class="btn btn-sm btn-secondary">Reinitialiser</a>
            @endif
        </form>
    </div>
</div>

{{-- Tableau des logs --}}
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Utilisateur</th>
                    <th>Action</th>
                    <th>Details</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>
                            <small>{{ $log->created_at->format('d/m/Y H:i:s') }}</small>
                        </td>
                        <td>{{ $log->user->name ?? 'Systeme' }}</td>
                        <td>
                            <span class="badge badge-vp">{{ $log->action }}</span>
                        </td>
                        <td>
                            <small class="text-muted">
                                @if(is_array($log->details))
                                    {{ Str::limit(json_encode($log->details), 80) }}
                                @else
                                    {{ Str::limit($log->details, 80) }}
                                @endif
                            </small>
                        </td>
                        <td>
                            <code style="font-size:.8rem;">{{ $log->ip_address ?? '—' }}</code>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Aucune activite enregistree</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($logs->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {{ $logs->links() }}
    </div>
@endif
@endsection
