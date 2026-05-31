@extends('layouts.admin')
@section('title', 'Parametres messagerie')

@section('actions')
<a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-secondary">
    <i class="bi bi-arrow-left me-1"></i> Retour
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.messages.settings.update') }}">
            @csrf

            <div class="mb-3">
                <label for="redirect_emails" class="form-label">Emails de redirection</label>
                <input type="text" name="redirect_emails" id="redirect_emails" class="form-control" value="{{ $redirect_emails }}" placeholder="contact@site.com, devis@site.com">
                <small class="text-muted">Separez les emails par des virgules. Les nouveaux messages seront envoyes a ces adresses.</small>
            </div>

            <div class="mb-3">
                <label for="min_seconds" class="form-label">Delai anti-spam (secondes)</label>
                <input type="number" name="min_seconds" id="min_seconds" class="form-control" value="{{ $min_seconds }}" min="1" max="30" style="max-width:150px;">
                <small class="text-muted">Temps minimum entre l'ouverture du formulaire et l'envoi (anti-bot).</small>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="client_confirmation" id="client_confirmation" class="form-check-input" value="1" {{ $client_confirmation ? 'checked' : '' }}>
                    <label for="client_confirmation" class="form-check-label">Envoyer une confirmation au client</label>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="admin_notification" id="admin_notification" class="form-check-input" value="1" {{ $admin_notification ? 'checked' : '' }}>
                    <label for="admin_notification" class="form-check-label">Envoyer notification admin</label>
                </div>
            </div>

            <button type="submit" class="btn btn-vp"><i class="bi bi-check-circle me-1"></i> Enregistrer</button>
        </form>

        <hr>

        <form method="POST" action="{{ route('admin.messages.settings.test') }}">
            @csrf
            <button class="btn btn-vp-outline"><i class="bi bi-send me-1"></i> Envoyer un email test</button>
        </form>
    </div>
</div>
@endsection
