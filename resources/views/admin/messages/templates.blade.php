@extends('layouts.admin')
@section('title', 'Modeles de reponse')

@section('actions')
<a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-secondary">
    <i class="bi bi-arrow-left me-1"></i> Retour
</a>
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header"><i class="bi bi-plus-circle me-1"></i> Nouveau modele</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.messages.templates.store') }}">
            @csrf
            <div class="row g-2 mb-2">
                <div class="col-md-6">
                    <input name="title" class="form-control" placeholder="Titre du modele" required>
                </div>
                <div class="col-md-6">
                    <input name="subject" class="form-control" placeholder="Sujet de l'email" required>
                </div>
            </div>
            <textarea name="body" class="form-control mb-2" rows="5" placeholder="Contenu de la reponse..." required></textarea>
            <button class="btn btn-vp"><i class="bi bi-plus me-1"></i> Ajouter</button>
        </form>
    </div>
</div>

@foreach($templates as $template)
<div class="card mb-2">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <strong>{{ $template->title }}</strong>
                <br><small class="text-muted">Sujet: {{ $template->subject }}</small>
                <div class="bg-light rounded p-2 mt-2" style="white-space:pre-wrap;font-size:.85rem;">{{ $template->body }}</div>
            </div>
            <form method="POST" action="{{ route('admin.messages.templates.destroy', $template) }}" onsubmit="return confirm('Supprimer ce modele ?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
        </div>
    </div>
</div>
@endforeach

@if($templates->isEmpty())
<div class="text-center text-muted py-4">Aucun modele. Creez-en un ci-dessus.</div>
@endif
@endsection
