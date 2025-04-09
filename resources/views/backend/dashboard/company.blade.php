@extends('admin.index')

@section('css')
<style>
.company-header {
    background: linear-gradient(135deg, #1a365d 0%, #2563eb 100%);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px; 
    position: relative;
    overflow: hidden;
}

.company-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 300px;
    height: 300px;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 100%);
    border-radius: 50%;
    transform: translate(100px, -100px);
}

.stats-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 20px;
}

.content-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.content-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.tender-progress {
    background: #f3f4f6;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 15px;
}

.tender-progress:hover {
    background: #f8fafc;
}

.applicant-card {
    border-radius: 10px;
    padding: 15px;
    transition: all 0.3s ease;
}

.applicant-card:hover {
    background: #f8fafc;
}

.chart-container {
    height: 300px;
    position: relative;
}

.quick-action {
    border-radius: 15px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.quick-action:hover {
    transform: translateY(-5px);
}
</style>
@endsection

@section('content')
<div class="container-fluid p-4">
    <!-- Company Header -->
    <div class="company-header text-white">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="d-flex align-items-center mb-3">
                    <div class="me-4">
                        <div class="bg-white bg-opacity-10 rounded-circle p-3" style="width: 80px; height: 80px;">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <span class="fs-2 fw-bold">{{ strtoupper(substr($company->name, 0, 2)) }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h1 class="display-6 fw-bold mb-1">{{ $company->name }}</h1>
                        <p class="mb-0 opacity-75">{{ $company->address }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="stats-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <p class="mb-0 opacity-75">{{ __('active_tenders') }}</p>
                                    <h2 class="mb-0">{{ $statistics['active_tenders'] }}</h2>
                                </div>
                                <div class="fs-1 opacity-25">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </div>
                            <div class="progress bg-white bg-opacity-25" style="height: 4px;">
                                <div class="progress-bar bg-white" 
                                     style="width: {{ ($statistics['active_tenders'] / max($statistics['total_tenders'], 1)) * 100 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stats-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <p class="mb-0 opacity-75">{{ __('total_applicants') }}</p>
                                    <h2 class="mb-0">{{ $statistics['total_applicants'] }}</h2>
                                </div>
                                <div class="fs-1 opacity-25">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <p class="mb-0 small opacity-75">
                                <i class="fas fa-arrow-up me-1"></i>
                                {{ $statistics['recent_applications'] }} {{ __('new_this_month') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        @can('tender.create')

        <div class="col-xl-3 col-md-6">
            <a href="{{ route('tenders.create') }}" class="quick-action d-block bg-primary bg-opacity-10 text-primary">
                <i class="fas fa-plus-circle fa-2x mb-3"></i>
                <h5 class="mb-0">{{ __('create_tender') }}</h5>
            </a>
        </div>
       @endcan
       @can('tender.view')

        <div class="col-xl-3 col-md-6">
            <a href="{{ route('tenders.index', ['status' => 'active']) }}" 
               class="quick-action d-block bg-success bg-opacity-10 text-success">
                <i class="fas fa-clock fa-2x mb-3"></i>
                <h5 class="mb-0">{{ __('active_tenders') }}</h5>
            </a>
        </div>
@endcan
@can('applicant.view')

        <div class="col-xl-3 col-md-6">
            <a href="{{ route('Applicants.index') }}" 
               class="quick-action d-block bg-info bg-opacity-10 text-info">
                <i class="fas fa-users fa-2x mb-3"></i>
                <h5 class="mb-0">{{ __('view_applicants') }}</h5>
            </a>
        </div>
@endcan
        <div class="col-xl-3 col-md-6">
            <a href="#" class="quick-action d-block bg-warning bg-opacity-10 text-warning">
                <i class="fas fa-chart-line fa-2x mb-3"></i>
                <h5 class="mb-0">{{ __('analytics') }}</h5>
            </a>
        </div>
    </div>

    <!-- Charts & Stats -->
    <div class="row g-4 mb-4">
        <!-- Applications Chart -->
        <div class="col-xl-8">
            <div class="content-card h-100">
                <div class="card-header bg-transparent border-0 py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('applications_overview') }}</h5>
                   
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="applicationsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tender Performance -->
        <div class="col-xl-4">
            <div class="content-card h-100">
                <div class="card-header bg-transparent border-0 py-4">
                    <h5 class="mb-0">Tender Performance</h5>
                </div>
                <div class="card-body">
                    @foreach($tenderPerformance as $tender)
                    <div class="tender-progress">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">{{ $tender->title }}</h6>
                            <span class="badge {{ $tender->end_date > now() ? 'bg-success' : 'bg-danger' }}">
                                {{ $tender->end_date > now() ? __('active') : __('closed') }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small text-muted">{{ $tender->applicants_count }} {{ __('applicant') }}</span>
                            <span class="small text-muted">
                                Ends {{ $tender->end_date }}
                            </span> 
                        </div>
                        
                    </div>
                    @endforeach
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
    const applicationsChart = new Chart(
        document.getElementById('applicationsChart').getContext('2d'),
        {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyApplications->pluck('month')) !!},
                datasets: [{
                    label: 'Applications',
                    data: {!! json_encode($monthlyApplications->pluck('count')) !!},
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
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
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        }
    );

    // Status Chart
    new Chart(
        document.getElementById('statusChart').getContext('2d'),
        {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($applicationStatus->pluck('status')) !!},
                datasets: [{
                    data: {!! json_encode($applicationStatus->pluck('count')) !!},
                    backgroundColor: ['#10b981', '#ef4444']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '75%'
            }
        }
    );
});

function viewApplication(id) {
    // Add your application view logic here
}

function updateChart(period) {
    // Add your chart update logic here
}
</script>
@endpush

