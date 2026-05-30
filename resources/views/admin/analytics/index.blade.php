@extends('layouts.admin')
@section('title', 'Visiteurs & Analytics')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-activity me-2"></i>Visiteurs en ligne & Analytics</h4>
    <button class="btn btn-sm btn-outline-success" onclick="location.reload()">
        <i class="bi bi-arrow-clockwise me-1"></i> Actualiser
    </button>
</div>

{{-- Real-time banner --}}
<div class="online-banner mb-4">
    <div class="online-dot"></div>
    <span class="online-count">{{ $onlineNow }}</span>
    <span class="online-label">{{ $onlineNow <= 1 ? 'personne sur le site' : 'personnes sur le site' }}</span>
</div>

{{-- Stat cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card analytics-card">
            <div class="analytics-icon" style="background:rgba(45,106,79,.12);color:#2d6a4f;"><i class="bi bi-eye"></i></div>
            <div class="analytics-value">{{ number_format($visitsToday) }}</div>
            <div class="analytics-label">Visites aujourd'hui</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card analytics-card">
            <div class="analytics-icon" style="background:rgba(59,130,246,.12);color:#3b82f6;"><i class="bi bi-person-check"></i></div>
            <div class="analytics-value">{{ number_format($uniqueToday) }}</div>
            <div class="analytics-label">Visiteurs uniques (jour)</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card analytics-card">
            <div class="analytics-icon" style="background:rgba(245,158,11,.12);color:#f59e0b;"><i class="bi bi-calendar-week"></i></div>
            <div class="analytics-value">{{ number_format($visitsWeek) }}</div>
            <div class="analytics-label">Visites cette semaine</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card analytics-card">
            <div class="analytics-icon" style="background:rgba(168,85,247,.12);color:#a855f7;"><i class="bi bi-calendar-month"></i></div>
            <div class="analytics-value">{{ number_format($visitsMonth) }}</div>
            <div class="analytics-label">Visites ce mois</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card analytics-card">
            <div class="analytics-icon" style="background:rgba(16,185,129,.12);color:#10b981;"><i class="bi bi-people"></i></div>
            <div class="analytics-value">{{ number_format($uniqueMonth) }}</div>
            <div class="analytics-label">Visiteurs uniques (mois)</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card analytics-card">
            <div class="analytics-icon" style="background:rgba(239,68,68,.12);color:#ef4444;"><i class="bi bi-file-earmark-text"></i></div>
            <div class="analytics-value">{{ number_format($pageViewsToday) }}</div>
            <div class="analytics-label">Pages vues aujourd'hui</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card analytics-card">
            <div class="analytics-icon" style="background:rgba(20,184,166,.12);color:#14b8a6;"><i class="bi bi-globe"></i></div>
            <div class="analytics-value">{{ number_format($totalVisits) }}</div>
            <div class="analytics-label">Visites totales</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card analytics-card">
            <div class="analytics-icon" style="background:rgba(99,102,241,.12);color:#6366f1;"><i class="bi bi-person-badge"></i></div>
            <div class="analytics-value">{{ number_format($uniqueVisitors) }}</div>
            <div class="analytics-label">Visiteurs uniques (total)</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    {{-- Daily visits chart --}}
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header bg-white">
                <i class="bi bi-bar-chart me-2 text-success"></i>Visites quotidiennes (30 derniers jours)
            </div>
            <div class="card-body" style="height:300px;">
                <canvas id="dailyVisitsChart"></canvas>
            </div>
        </div>
    </div>
    {{-- Device breakdown --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-white">
                <i class="bi bi-phone me-2 text-success"></i>Appareils
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <canvas id="deviceChart" style="max-height:180px;"></canvas>
                <div class="mt-3 w-100">
                    @foreach($deviceBreakdown as $device)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>
                            @if($device->device_type === 'mobile')
                                <i class="bi bi-phone text-primary me-1"></i> Mobile
                            @elseif($device->device_type === 'tablet')
                                <i class="bi bi-tablet text-warning me-1"></i> Tablette
                            @else
                                <i class="bi bi-laptop text-success me-1"></i> Desktop
                            @endif
                        </span>
                        <span class="badge bg-secondary">{{ $device->count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    {{-- Hourly chart --}}
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header bg-white">
                <i class="bi bi-clock me-2 text-success"></i>Visites par heure (aujourd'hui)
            </div>
            <div class="card-body" style="height:300px;">
                <canvas id="hourlyChart"></canvas>
            </div>
        </div>
    </div>
    {{-- Recent visitors --}}
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header bg-white">
                <i class="bi bi-person-lines-fill me-2 text-success"></i>Visiteurs recents
            </div>
            <div class="card-body p-0" style="max-height:350px;overflow-y:auto;">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>IP</th>
                            <th>Page</th>
                            <th>Appareil</th>
                            <th>Heure</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentVisitors as $visitor)
                        <tr>
                            <td><code class="small">{{ substr($visitor->ip_address, 0, -3) . '***' }}</code></td>
                            <td class="small text-truncate" style="max-width:150px;">{{ $visitor->page_url ?: '/' }}</td>
                            <td>
                                @if($visitor->device_type === 'mobile')
                                    <i class="bi bi-phone text-primary"></i>
                                @elseif($visitor->device_type === 'tablet')
                                    <i class="bi bi-tablet text-warning"></i>
                                @else
                                    <i class="bi bi-laptop text-success"></i>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $visitor->created_at->format('H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Top pages --}}
<div class="card mb-4">
    <div class="card-header bg-white">
        <i class="bi bi-star me-2 text-success"></i>Pages les plus visitees (30 jours)
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Page</th>
                    <th>Visites</th>
                    <th>Visiteurs uniques</th>
                    <th style="min-width:200px;">Pourcentage</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topPages as $i => $page)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><code>/{{ $page->page_url ?: '' }}</code></td>
                    <td><strong>{{ $page->visit_count }}</strong></td>
                    <td>{{ $page->unique_count }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress flex-grow-1" style="height:8px;">
                                <div class="progress-bar" style="width:{{ $page->percentage }}%;background:#2d6a4f;border-radius:4px;"></div>
                            </div>
                            <small class="fw-bold">{{ $page->percentage }}%</small>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Aucune donnee disponible</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Referrers --}}
@if($referrerStats->count() > 0)
<div class="card mb-4">
    <div class="card-header bg-white">
        <i class="bi bi-box-arrow-in-right me-2 text-success"></i>Sources de trafic (30 jours)
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Source</th>
                    <th>Visites</th>
                </tr>
            </thead>
            <tbody>
                @foreach($referrerStats as $ref)
                <tr>
                    <td class="small text-truncate" style="max-width:400px;">{{ $ref->referer }}</td>
                    <td><strong>{{ $ref->count }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection

@section('styles')
<style>
.online-banner {
    background: linear-gradient(135deg, #065f46, #059669);
    color: white;
    padding: 20px 30px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 4px 15px rgba(5,150,105,.3);
}
.online-dot {
    width: 16px;
    height: 16px;
    background: #4ade80;
    border-radius: 50%;
    animation: pulse-dot 1.5s infinite;
    box-shadow: 0 0 10px rgba(74,222,128,.6);
}
@keyframes pulse-dot {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.3); opacity: 0.7; }
}
.online-count {
    font-size: 2.5rem;
    font-weight: 800;
    line-height: 1;
}
.online-label {
    font-size: 1.1rem;
    opacity: 0.9;
}
.analytics-card {
    padding: 20px;
    text-align: center;
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    transition: transform .2s, box-shadow .2s;
}
.analytics-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,.1);
}
.analytics-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    margin: 0 auto 10px;
}
.analytics-value {
    font-size: 1.8rem;
    font-weight: 800;
    color: #1f2937;
    line-height: 1.2;
}
.analytics-label {
    font-size: .8rem;
    color: #6b7280;
    margin-top: 4px;
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
const vpGreen = '#2d6a4f';
const vpGreenLight = 'rgba(45,106,79,0.15)';

// Daily visits chart
const dailyData = @json($dailyVisits);
new Chart(document.getElementById('dailyVisitsChart'), {
    type: 'bar',
    data: {
        labels: dailyData.map(d => { var p = d.date.split('-'); return p[2]+'/'+p[1]; }),
        datasets: [{
            label: 'Visites',
            data: dailyData.map(d => d.visits),
            backgroundColor: vpGreenLight,
            borderColor: vpGreen,
            borderWidth: 2,
            borderRadius: 5,
            hoverBackgroundColor: 'rgba(45,106,79,0.4)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,.05)' } },
            x: { ticks: { maxRotation: 45, font: { size: 10 } }, grid: { display: false } }
        },
        plugins: { legend: { display: false } }
    }
});

// Device chart
const deviceData = @json($deviceBreakdown);
const deviceLabels = deviceData.map(d => {
    if(d.device_type === 'mobile') return 'Mobile';
    if(d.device_type === 'tablet') return 'Tablette';
    return 'Desktop';
});
new Chart(document.getElementById('deviceChart'), {
    type: 'doughnut',
    data: {
        labels: deviceLabels,
        datasets: [{
            data: deviceData.map(d => d.count),
            backgroundColor: ['#2d6a4f', '#40916c', '#74c69d'],
            borderWidth: 3,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: { legend: { position: 'bottom', labels: { padding: 10, font: { size: 11 } } } }
    }
});

// Hourly chart
const hourlyData = @json($hourlyData);
new Chart(document.getElementById('hourlyChart'), {
    type: 'line',
    data: {
        labels: hourlyData.map(d => d.hour),
        datasets: [{
            label: 'Visites',
            data: hourlyData.map(d => d.count),
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.1)',
            fill: true,
            tension: 0.4,
            pointRadius: 3,
            pointBackgroundColor: '#3b82f6'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,.05)' } },
            x: { ticks: { font: { size: 10 } }, grid: { display: false } }
        },
        plugins: { legend: { display: false } }
    }
});

// Auto-refresh every 30 seconds
setTimeout(function(){ location.reload(); }, 30000);
</script>
@endsection
