@extends('layouts.admin')
@section('title', 'Analytics')

@section('content')
{{-- Cartes statistiques --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-eye"></i></div>
            <div class="stat-value">{{ $visitsToday ?? 0 }}</div>
            <div class="stat-label">Visites aujourd'hui</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-calendar-week"></i></div>
            <div class="stat-value">{{ $visitsWeek ?? 0 }}</div>
            <div class="stat-label">Visites cette semaine</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="stat-icon"><i class="bi bi-calendar-month"></i></div>
            <div class="stat-value">{{ $visitsMonth ?? 0 }}</div>
            <div class="stat-label">Visites ce mois</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- Graphique des visites quotidiennes --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-bar-chart me-2"></i>Visites quotidiennes (30 derniers jours)
            </div>
            <div class="card-body">
                <canvas id="dailyVisitsChart" height="250"></canvas>
            </div>
        </div>
    </div>

    {{-- Repartition par appareil --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-phone me-2"></i>Repartition par appareil
            </div>
            <div class="card-body">
                <canvas id="deviceChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Pages les plus visitees --}}
<div class="card">
    <div class="card-header">
        <i class="bi bi-file-earmark me-2"></i>Pages les plus visitees
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th>Page</th>
                    <th>Visites</th>
                    <th>Pourcentage</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topPages ?? [] as $page)
                    <tr>
                        <td>{{ $page->page }}</td>
                        <td>{{ $page->visits }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height:6px;">
                                    <div class="progress-bar" style="width:{{ $page->percentage ?? 0 }}%; background:var(--vp-green);"></div>
                                </div>
                                <small>{{ number_format($page->percentage ?? 0, 1) }}%</small>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Aucune donnee disponible</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    // Visites quotidiennes - graphique en barres
    const dailyData = @json($dailyVisits ?? []);
    const dailyLabels = dailyData.map(d => d.date);
    const dailyValues = dailyData.map(d => d.visits);

    new Chart(document.getElementById('dailyVisitsChart'), {
        type: 'bar',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Visites',
                data: dailyValues,
                backgroundColor: 'rgba(45, 106, 79, 0.6)',
                borderColor: '#2d6a4f',
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { ticks: { maxRotation: 45, font: { size: 10 } } }
            },
            plugins: { legend: { display: false } }
        }
    });

    // Repartition par appareil - graphique en camembert
    const deviceData = @json($deviceBreakdown ?? []);
    const deviceLabels = deviceData.map(d => d.device);
    const deviceValues = deviceData.map(d => d.count);

    new Chart(document.getElementById('deviceChart'), {
        type: 'pie',
        data: {
            labels: deviceLabels,
            datasets: [{
                data: deviceValues,
                backgroundColor: ['#2d6a4f', '#40916c', '#52b788', '#74c69d', '#95d5b2'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { padding: 15 } }
            }
        }
    });
</script>
@endsection
