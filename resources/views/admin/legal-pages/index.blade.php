@extends('layouts.admin')
@section('title', 'Pages Legales')

@section('actions')
    <a href="{{ route('admin.legal-pages.create') }}" class="btn btn-vp">
        <i class="bi bi-plus-circle me-1"></i> Ajouter une page
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Slug</th>
                    <th>Actif</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td><code>{{ $page->slug }}</code></td>
                        <td>
                            @if($page->is_active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.legal-pages.edit', $page) }}" class="btn btn-sm btn-vp-outline" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.legal-pages.destroy', $page) }}" class="d-inline" onsubmit="return confirm('Supprimer cette page ?')">
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
                        <td colspan="4" class="text-center text-muted py-4">Aucune page legale enregistree</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($pages->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {{ $pages->links() }}
    </div>
@endif
@endsection
