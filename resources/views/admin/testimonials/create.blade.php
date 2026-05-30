@extends('layouts.admin')
@section('title', 'Ajouter un temoignage')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="client_name" class="form-label">Nom du client <span class="text-danger">*</span></label>
                    <input type="text" name="client_name" id="client_name" class="form-control" value="{{ old('client_name') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="client_location" class="form-label">Lieu</label>
                    <input type="text" name="client_location" id="client_location" class="form-control" value="{{ old('client_location') }}" placeholder="ex: Paris 16e">
                </div>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Temoignage <span class="text-danger">*</span></label>
                <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="rating" class="form-label">Note <span class="text-danger">*</span></label>
                    <select name="rating" id="rating" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} etoile{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="image" class="form-label">Photo du client</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                </div>
            </div>

            <div class="mb-3 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">Actif</label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-vp">
                    <i class="bi bi-check-circle me-1"></i> Enregistrer
                </button>
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
