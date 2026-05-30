@extends('layouts.admin')
@section('title', 'Messages')

@section('content')
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ !request('filter') || request('filter') == 'all' ? 'active' : '' }}" href="{{ route('admin.messages.index') }}">
            Tous
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request('filter') == 'unread' ? 'active' : '' }}" href="{{ route('admin.messages.index', ['filter' => 'unread']) }}">
            Non lus
            @if(isset($unreadCount) && $unreadCount > 0)
                <span class="badge bg-danger ms-1">{{ $unreadCount }}</span>
            @endif
        </a>
    </li>
</ul>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Sujet</th>
                    <th>Date</th>
                    <th>Lu</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                    <tr class="{{ !$message->is_read ? 'fw-bold' : '' }}">
                        <td>{{ $message->name }}</td>
                        <td>{{ $message->email }}</td>
                        <td>{{ Str::limit($message->subject ?? '—', 40) }}</td>
                        <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($message->is_read)
                                <span class="badge bg-success">Lu</span>
                            @else
                                <span class="badge bg-warning text-dark">Non lu</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-sm btn-vp-outline" title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="d-inline" onsubmit="return confirm('Supprimer ce message ?')">
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
                        <td colspan="6" class="text-center text-muted py-4">Aucun message</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($messages->hasPages())
    <div class="mt-3 d-flex justify-content-center">
        {{ $messages->links() }}
    </div>
@endif
@endsection
