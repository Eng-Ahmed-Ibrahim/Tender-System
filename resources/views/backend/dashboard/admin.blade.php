
@extends('admin.index')

@section('css')
<style>
.stats-card {
    background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
    border-radius: 1rem;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.stats-card-1 {
    --gradient-start: #3b82f6;
    --gradient-end: #2563eb;
}

.stats-card-2 {
    --gradient-start: #10b981;
    --gradient-end: #059669;
}

.stats-card-3 {
    --gradient-start: #f59e0b;
    --gradient-end: #d97706;
}

.stats-card-4 {
    --gradient-start: #6366f1;
    --gradient-end: #4f46e5;
}

.dashboard-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
}

.chart-container {
    position: relative;
    height: 300px;
}

.activity-timeline {
    position: relative;
    padding-left: 2rem;
}

.activity-timeline::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e5e7eb;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -2rem;
    top: 0.25rem;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    background: #3b82f6;
    border: 3px solid #fff;
}

.company-card {
    border: 1px solid #e5e7eb;
    border-radius: 1rem;
    padding: 1rem;
    transition: all 0.3s ease;
}

.company-card:hover {
    border-color: #3b82f6;
    background: #f8fafc;
}
</style>
@endsection

@section('content')
<div class="container-fluid p-4">
    <!-- Statistics Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-card-1 text-white">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="stats-icon">
                        <i class="fas fa-file-alt fa-2x opacity-75"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link text-white p-0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('tenders.index') }}">View All</a></li>
                            <li><a class="dropdown-item" href="{{ route('tenders.create') }}">Create New</a></li>
                        </ul>
                    </div>
                </div>
                <h3 class="mb-2">{{ $statistics['total_tenders'] }}</h3>
                <p class="mb-0 opacity-75">Total Tenders</p>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-card-2 text-white">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="stats-icon">
                        <i class="fas fa-building fa-2x opacity-75"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link text-white p-0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">View Companies</a></li>
                        </ul>
                    </div>
                </div>
                <h3 class="mb-2">{{ $statistics['total_companies'] }}</h3>
                <p class="mb-0 opacity-75">Registered Companies</p>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-card-3 text-white">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="stats-icon">
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link text-white p-0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">View Applicants</a></li>
                        </ul>
                    </div>
                </div>
                <h3 class="mb-2">{{ $statistics['total_applicants'] }}</h3>
                <p class="mb-0 opacity-75">Total Applicants</p>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-card-4 text-white">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="stats-icon">
                        <i class="fas fa-clock fa-2x opacity-75"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link text-white p-0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">View Active</a></li>
                        </ul>
                    </div>
                </div>
                <h3 class="mb-2">{{ $statistics['active_tenders'] }}</h3>
                <p class="mb-0 opacity-75">Active Tenders</p>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="mb-0">Applications Overview</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="applicationsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="mb-0">Tender Categories</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="categoriesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Top Companies -->
    <div class="row g-4">
        <div class="col-xl-4">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="mb-0">Top Companies</h5>
                </div>
                <div class="card-body">
                    @foreach($topCompanies as $company)
                    <div class="company-card mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="company-avatar me-3">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($company->name, 0, 2)) }}
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1">{{ $company->name }}</h6>
                                    <p class="text-muted small mb-0">
                                        {{ $company->tenders_count }} tenders • 
                                        {{ $company->active_tenders_count }} active
                                    </p>
                                </div>
                            </div>
                            <a href="#" class="btn btn-light btn-sm">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>```php
        <div class="col-xl-4">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="mb-0">Recent Tenders</h5>
                </div>
                <div class="card-body">
                    <div class="activity-timeline">
                        @foreach($recentTenders as $tender)
                        <div class="timeline-item">
                            <div class="bg-light rounded-3 p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">{{ $tender->title }}</h6>
                                    <span class="badge {{ $tender->end_date > now() ? 'bg-success' : 'bg-danger' }}">
                                        {{ $tender->end_date > now() ? 'Active' : 'Closed' }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center text-muted small mb-2">
                                    <i class="fas fa-building me-2"></i>
                                    {{ $tender->company->name }}
                                </div>
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="fas fa-users me-2"></i>
                                    {{ $tender->applicants_count }} {{ __('Applicants') }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-clock me-2"></i>
                                    {{ $tender->end_date->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Applicants</h5>
                    <a href="#" class="btn btn-light btn-sm">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($recentApplicants as $applicant)
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar bg-light rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 45px; height: 45px;">
                                        {{ strtoupper(substr($applicant->name, 0, 2)) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">{{ $applicant->name }}</h6>
                                        <small class="text-muted">
                                            {{ $applicant->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        Applied for 
                                        <a href="#" class="text-decoration-none">
                                            {{ $applicant->applicants->first()?->tender->title ?? 'Unknown Tender' }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Applications Chart
    const applicationsCtx = document.getElementById('applicationsChart').getContext('2d');
    new Chart(applicationsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyApplications->pluck('month')) !!},
            datasets: [{
                label: 'Applications',
                data: {!! json_encode($monthlyApplications->pluck('count')) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Categories Chart
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($tenderCategories->pluck('category')) !!},
            datasets: [{
                data: {!! json_encode($tenderCategories->pluck('count')) !!},
                backgroundColor: [
                    '#3b82f6',
                    '#10b981',
                    '#f59e0b',
                    '#6366f1',
                    '#ec4899'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endpush
