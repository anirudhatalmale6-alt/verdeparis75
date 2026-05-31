@extends('layouts.admin')
@section('title', 'Messages')

@section('actions')
<div class="d-flex gap-2">
    <a href="{{ route('admin.messages.settings') }}" class="btn btn-sm btn-vp-outline">
        <i class="bi bi-gear me-1"></i> Parametres
    </a>
    <a href="{{ route('admin.messages.templates') }}" class="btn btn-sm btn-vp-outline">
        <i class="bi bi-file-text me-1"></i> Modeles
    </a>
</div>
@endsection

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-envelope"></i></div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-envelope-open"></i></div>
            <div class="stat-value">{{ $stats['unread'] }}</div>
            <div class="stat-label">Non lus</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-archive"></i></div>
            <div class="stat-value">{{ $stats['archived'] }}</div>
            <div class="stat-label">Archives</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-exclamation-octagon"></i></div>
            <div class="stat-value">{{ $stats['spam'] }}</div>
            <div class="stat-label">Spam</div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 align-items-center">
            <input name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Recherche nom, email, sujet..." style="max-width:300px;">
            <select name="status" class="form-select form-select-sm" style="max-width:180px;">
                <option value="inbox" @selected(request('status', 'inbox') === 'inbox')>Boite de reception</option>
                <option value="unread" @selected(request('status') === 'unread')>Non lus</option>
                <option value="archived" @selected(request('status') === 'archived')>Archives</option>
                <option value="spam" @selected(request('status') === 'spam')>Spam</option>
            </select>
            <button class="btn btn-sm btn-vp"><i class="bi bi-search"></i> Filtrer</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Telephone</th>
                    <th>Sujet</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                <tr @if(!$message->is_read) style="font-weight:bold;background:#fffbea" @endif>
                    <td>{{ $message->name }}</td>
                    <td>{{ $message->email }}</td>
                    <td>{{ $message->phone ?: '—' }}</td>
                    <td>{{ Str::limit($message->subject ?: '—', 35) }}</td>
                    <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($message->is_spam)
                            <span class="badge bg-danger">Spam</span>
                        @elseif($message->is_archived)
                            <span class="badge bg-secondary">Archive</span>
                        @elseif($message->is_read)
                            <span class="badge bg-success">Lu</span>
                            @if($message->replied_at)
                                <span class="badge bg-info">Repondu</span>
                            @endif
                        @else
                            <span class="badge bg-warning text-dark">Non lu</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-sm btn-vp-outline" title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(!$message->is_archived)
                            <form method="POST" action="{{ route('admin.messages.archive', $message) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary" title="Archiver"><i class="bi bi-archive"></i></button>
                            </form>
                            @else
                            <form method="POST" action="{{ route('admin.messages.restore', $message) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-info" title="Restaurer"><i class="bi bi-arrow-counterclockwise"></i></button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="d-inline" onsubmit="return confirm('Supprimer ce message ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Aucun message</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($messages->hasPages())
<div class="mt-3">{{ $messages->links() }}</div>
@endif
@endsection
