@extends('layouts.admin')
@section('title', 'Redirections SEO')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-plus-circle me-1"></i> Ajouter une redirection
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.seo-pro.redirects.store') }}">
            @csrf
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label for="source_path" class="form-label">URL source</label>
                    <input type="text" name="source_path" id="source_path" class="form-control" placeholder="/ancienne-url" required>
                </div>
                <div class="col-md-4">
                    <label for="target_url" class="form-label">URL cible</label>
                    <input type="text" name="target_url" id="target_url" class="form-control" placeholder="/nouvelle-url" required>
                </div>
                <div class="col-md-2">
                    <label for="status_code" class="form-label">Code</label>
                    <select name="status_code" id="status_code" class="form-select">
                        <option value="301">301 (permanent)</option>
                        <option value="302">302 (temporaire)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="form-check mb-2">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
                        <label for="is_active" class="form-check-label">Active</label>
                    </div>
                    <button type="submit" class="btn btn-vp btn-sm w-100">
                        <i class="bi bi-plus"></i> Ajouter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th>Source</th>
                    <th>Cible</th>
                    <th>Code</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($redirects as $r)
                <tr>
                    <td><code>{{ $r->source_path }}</code></td>
                    <td>{{ $r->target_url }}</td>
                    <td><span class="badge {{ $r->status_code == 301 ? 'bg-primary' : 'bg-warning text-dark' }}">{{ $r->status_code }}</span></td>
                    <td>
                        @if($r->is_active)
                            <span class="badge bg-success">Oui</span>
                        @else
                            <span class="badge bg-secondary">Non</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.seo-pro.redirects.destroy', $r) }}" onsubmit="return confirm('Supprimer cette redirection ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Aucune redirection.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $redirects->links() }}</div>
@endsection
