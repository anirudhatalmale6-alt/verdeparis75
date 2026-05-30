@extends('layouts.admin')
@section('title', 'Message de ' . $message->name)

@section('actions')
    <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th class="text-muted" style="width:120px;">Nom</th>
                        <td>{{ $message->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Email</th>
                        <td>
                            <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                        </td>
                    </tr>
                    @if($message->phone)
                        <tr>
                            <th class="text-muted">Telephone</th>
                            <td>{{ $message->phone }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th class="text-muted">Sujet</th>
                        <td>{{ $message->subject ?? '—' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th class="text-muted" style="width:120px;">Date</th>
                        <td>{{ $message->created_at->format('d/m/Y a H:i') }}</td>
                    </tr>
                    @if($message->ip_address)
                        <tr>
                            <th class="text-muted">Adresse IP</th>
                            <td>{{ $message->ip_address }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th class="text-muted">Statut</th>
                        <td>
                            @if($message->is_read)
                                <span class="badge bg-success">Lu</span>
                            @else
                                <span class="badge bg-warning text-dark">Non lu</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <div class="mt-3">
            <h6 class="text-muted mb-3">Message</h6>
            <div class="bg-light rounded p-3" style="white-space: pre-wrap;">{{ $message->message }}</div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <a href="mailto:{{ $message->email }}" class="btn btn-vp">
                <i class="bi bi-reply me-1"></i> Repondre par email
            </a>
            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Supprimer ce message ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash me-1"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
