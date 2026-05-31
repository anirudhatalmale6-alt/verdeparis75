@extends('layouts.admin')
@section('title', 'Message de ' . $message->name)

@section('actions')
<a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-secondary">
    <i class="bi bi-arrow-left me-1"></i> Retour
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="mb-3">{{ $message->subject ?: 'Message client' }}</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm mb-0">
                            <tr><th class="text-muted" style="width:100px;">Nom</th><td>{{ $message->name }}</td></tr>
                            <tr><th class="text-muted">Email</th><td><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></td></tr>
                            <tr><th class="text-muted">Telephone</th><td>{{ $message->phone ?: '—' }}</td></tr>
                            <tr><th class="text-muted">Service</th><td>{{ $message->service ?: '—' }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm mb-0">
                            <tr><th class="text-muted" style="width:100px;">Date</th><td>{{ $message->created_at->format('d/m/Y a H:i') }}</td></tr>
                            <tr><th class="text-muted">IP</th><td>{{ $message->ip_address ?: '—' }}</td></tr>
                            <tr>
                                <th class="text-muted">Statut</th>
                                <td>
                                    @if($message->is_read)<span class="badge bg-success">Lu</span>@else<span class="badge bg-warning text-dark">Non lu</span>@endif
                                    @if($message->replied_at)<span class="badge bg-info">Repondu {{ $message->replied_at->format('d/m H:i') }}</span>@endif
                                </td>
                            </tr>
                            @if($message->forwarded_to)
                            <tr><th class="text-muted">Redirige</th><td>{{ implode(', ', $message->forwarded_to) }}</td></tr>
                            @endif
                        </table>
                    </div>
                </div>

                <hr>
                <div class="bg-light rounded p-3" style="white-space:pre-wrap;">{{ $message->message }}</div>

                <div class="mt-3 d-flex gap-2">
                    <form method="POST" action="{{ route('admin.messages.archive', $message) }}" class="d-inline">@csrf
                        <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-archive me-1"></i> Archiver</button>
                    </form>
                    <form method="POST" action="{{ $message->is_read ? route('admin.messages.unread', $message) : route('admin.messages.read', $message) }}" class="d-inline">@csrf
                        <button class="btn btn-sm btn-outline-warning"><i class="bi bi-envelope me-1"></i> {{ $message->is_read ? 'Marquer non lu' : 'Marquer lu' }}</button>
                    </form>
                    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="d-inline" onsubmit="return confirm('Supprimer ?')">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i> Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><i class="bi bi-reply me-1"></i> Repondre au client</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.messages.reply', $message) }}">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Sujet</label>
                        <input name="subject" class="form-control" value="Re: {{ $message->subject ?: 'Votre demande VERDE PARIS 75' }}">
                    </div>

                    @if($templates->count() > 0)
                    <div class="mb-2">
                        <label class="form-label">Modele</label>
                        <select class="form-select form-select-sm" id="templateSelect">
                            <option value="">-- Choisir un modele --</option>
                            @foreach($templates as $tpl)
                            <option data-subject="{{ $tpl->subject }}" data-body="{{ $tpl->body }}">{{ $tpl->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea name="body" id="replyBody" rows="10" class="form-control">Bonjour {{ $message->name }},

Merci pour votre message. Nous avons bien recu votre demande et nous allons vous repondre rapidement.

Cordialement,
VERDE PARIS 75</textarea>
                    </div>
                    <button class="btn btn-vp w-100"><i class="bi bi-send me-1"></i> Envoyer la reponse</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('templateSelect')?.addEventListener('change', function() {
    var opt = this.options[this.selectedIndex];
    if (opt.dataset.body) {
        document.getElementById('replyBody').value = opt.dataset.body;
    }
    if (opt.dataset.subject) {
        document.querySelector('input[name="subject"]').value = opt.dataset.subject;
    }
});
</script>
@endsection
