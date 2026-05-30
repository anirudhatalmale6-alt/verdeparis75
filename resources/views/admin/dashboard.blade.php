@extends('layouts.admin')
@section('title', 'Tableau de bord')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3 col-6">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-gear"></i></div>
            <div class="stat-value">{{ $counts['services'] }}</div>
            <div class="stat-label">Services</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-briefcase"></i></div>
            <div class="stat-value">{{ $counts['projects'] }}</div>
            <div class="stat-label">Realisations</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-images"></i></div>
            <div class="stat-value">{{ $counts['photos'] }}</div>
            <div class="stat-label">Photos</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-envelope"></i></div>
            <div class="stat-value">{{ $counts['messages_unread'] }}</div>
            <div class="stat-label">Messages non lus</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3 col-6">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-eye"></i></div>
            <div class="stat-value">{{ $counts['visits_today'] }}</div>
            <div class="stat-label">Visites aujourd'hui</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-calendar-week"></i></div>
            <div class="stat-value">{{ $counts['visits_week'] }}</div>
            <div class="stat-label">Visites cette semaine</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-play-circle"></i></div>
            <div class="stat-value">{{ $counts['videos'] }}</div>
            <div class="stat-label">Videos</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <div class="stat-value">{{ $counts['partners'] }}</div>
            <div class="stat-label">Partenaires</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-envelope me-2"></i>Messages recents</span>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-vp-outline">Voir tout</a>
            </div>
            <div class="card-body p-0">
                @if($recentMessages->isEmpty())
                    <p class="text-muted text-center py-4">Aucun message</p>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($recentMessages as $msg)
                            <a href="{{ route('admin.messages.show', $msg) }}" class="list-group-item list-group-item-action {{ !$msg->is_read ? 'fw-bold' : '' }}">
                                <div class="d-flex justify-content-between">
                                    <span>{{ $msg->name }}</span>
                                    <small class="text-muted">{{ $msg->created_at->diffForHumans() }}</small>
                                </div>
                                <small class="text-muted">{{ Str::limit($msg->subject ?? $msg->message, 50) }}</small>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i>Activite recente</span>
                <a href="{{ route('admin.security.index') }}" class="btn btn-sm btn-vp-outline">Voir tout</a>
            </div>
            <div class="card-body p-0">
                @if($recentLogs->isEmpty())
                    <p class="text-muted text-center py-4">Aucune activite</p>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($recentLogs as $log)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-semibold">{{ $log->action }}</span>
                                    <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                </div>
                                @if($log->details)
                                    <small class="text-muted">{{ is_array($log->details) ? json_encode($log->details) : Str::limit($log->details, 60) }}</small>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
