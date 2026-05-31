@extends('layouts.admin')
@section('title', 'Pages SEO')

@section('actions')
<a href="{{ route('admin.seo-pro.pages.create') }}" class="btn btn-sm btn-vp">
    <i class="bi bi-plus-circle me-1"></i> Ajouter
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
                    <th>SEO Title</th>
                    <th>Indexable</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                <tr>
                    <td><strong>{{ $page->title }}</strong></td>
                    <td><code>/{{ $page->slug }}</code></td>
                    <td>{{ Str::limit($page->seo_title, 40) ?: '—' }}</td>
                    <td>
                        @if($page->is_indexable)
                            <span class="badge bg-success">Oui</span>
                        @else
                            <span class="badge bg-secondary">Non</span>
                        @endif
                    </td>
                    <td>
                        @if($page->is_active)
                            <span class="badge bg-success">Oui</span>
                        @else
                            <span class="badge bg-secondary">Non</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ url('/' . $page->slug) }}" class="btn btn-sm btn-outline-secondary" target="_blank" title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.seo-pro.pages.edit', $page) }}" class="btn btn-sm btn-vp-outline" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.seo-pro.pages.destroy', $page) }}" onsubmit="return confirm('Supprimer cette page SEO ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Aucune page SEO. Cliquez sur "Ajouter" pour en creer une.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $pages->links() }}</div>
@endsection
