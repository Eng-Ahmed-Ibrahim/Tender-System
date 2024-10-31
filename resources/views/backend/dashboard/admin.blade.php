@extends('admin.index')

@section('css')
<style>
.stats-card {
    background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
    border-radius: 15px;
    padding: 20px;
    color: white;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stats-card-1 { --gradient-start: #4158D0; --gradient-end: #C850C0; }
.stats-card-2 { --gradient-start: #0093E9; --gradient-end: #80D0C7; }
.stats-card-3 { --gradient-start: #00C9FF; --gradient-end: #92FE9D; }
.stats-card-4 { --gradient-start: #FF3CAC; --gradient-end: #784BA0; }

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.content-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.content-card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.chart-container {
    height: 300px;
    position: relative;
}

.activity-item {
    padding: 15px;
    border-left: 2px solid #e2e8f0;
    position: relative;
    margin-left: 20px;
}

.activity-item::before {
    content: '';
    position: absolute;
    left: -8px;
    top: 20px;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background: #4158D0;
    border: 3px solid white;
}
</style>
@endsection

@section('content')
<div class="container-fluid p-4">
    <!-- Stats Row -->
    <div class="row g-4 mb-4">
        <!-- Total Tenders -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-card-1">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon">
                        <i class="fas fa-file-alt fa-2x opacity-50"></i>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-1">{{ $statistics['total_tenders'] }}</h3>
                        <p class="mb-0">{{__('Total Tenders')}}</p>
                    </div>
                </div>
                <div class="progress bg-white bg-opacity-25" style="height: 4px;">
                    <div class="progress-bar bg-white" style="width: 75%"></div>
                </div>
            </div>
        </div>

        <!-- Active Tenders -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-card-2">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon">
                        <i class="fas fa-clock fa-2x opacity-50"></i>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-1">{{ $statistics['active_tenders'] }}</h3>
                        <p class="mb-0">{{__('Active Tenders')}}</p>
                    </div>
                </div>
                <div class="progress bg-white bg-opacity-25" style="height: 4px;">
                    <div class="progress-bar bg-white" 
                         style="width: {{ ($statistics['active_tenders'] / max($statistics['total_tenders'], 1)) * 100 }}%">
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Companies -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-card-3">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon">
                        <i class="fas fa-building fa-2x opacity-50"></i>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-1">{{ $statistics['total_companies'] }}</h3>
                        <p class="mb-0">{{__('Companies')}}</p>
                    </div>
                </div>
                <div class="progress bg-white bg-opacity-25" style="height: 4px;">
                    <div class="progress-bar bg-white" style="width: 60%"></div>
                </div>
            </div>
        </div>

        <!-- Total Applicants -->
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-card-4">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon">
                        <i class="fas fa-users fa-2x opacity-50"></i>
                    </div>
                    <div class="text-end">
                        <h3 class="mb-1">{{ $statistics['total_applicants'] }}</h3>
                        <p class="mb-0">{{__('Applicants')}}</p>
                    </div>
                </div>
                <div class="progress bg-white bg-opacity-25" style="height: 4px;">
                    <div class="progress-bar bg-white" style="width: 85%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Applications Chart -->
        <div class="col-xl-8">
            <div class="content-card h-100">
                <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{__('Applications Overview')}}</h5>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-light" onclick="updateChart('weekly')">Week</button>
                            <button class="btn btn-sm btn-light" onclick="updateChart('monthly')">Month</button>
                            <button class="btn btn-sm btn-light" onclick="updateChart('yearly')">Year</button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="chart-container">
                        <canvas id="applicationsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="col-xl-4">
            <div class="content-card h-100">
                <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4">
                    <h5 class="mb-0">{{__('Recent Applications')}}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="activity-timeline">
                        @foreach($recentApplicants as $applicant)
                            <div class="activity-item mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3">
                                        <div class="avatar-content rounded-circle bg-light d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($applicant->name, 0, 2)) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $applicant->name }}</h6>
                                        <p class="mb-0 text-muted small">
                                            Applied for: {{ $applicant->applicants->first()?->tender->title }}
                                        </p>
                                        <small class="text-muted">
                                            {{ $applicant->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="row g-4">
        <!-- Top Companies -->
        <div class="col-xl-12">
            <div class="content-card">
                <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4">
                    <h5 class="mb-0">{{__('Top Companies')}}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{__('Company')}}</th>
                                    <th>{{__('Tenders')}}</th>
                                    <th>{{__('Active')}}</th>
                                    <th>{{__('Applications')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topCompanies as $company)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-2">
                                                <div class="avatar-content rounded bg-light d-flex align-items-center justify-content-center"
                                                     style="width: 35px; height: 35px;">
                                                    {{ strtoupper(substr($company->name, 0, 2)) }}
                                                </div>
                                            </div>
                                            <div>
                                              <a href="{{route('companies.show',$company->id)}}">  <h6 class="mb-0">{{ $company->name }}</h6></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $company->tenders_count }}</td>
                                    <td>{{ $company->active_tenders_count }}</td>
                                    <td>
                                        <div class="progress" style="height: 5px; width: 100px;">
                                            <div class="progress-bar" style="width: {{ ($company->active_tenders_count / max($company->tenders_count, 1)) * 100 }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Distribution -->
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Applications Chart
    const applicationsCtx = document.getElementById('applicationsChart').getContext('2d');
    const applicationsChart = new Chart(applicationsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyApplications->pluck('month')) !!},
            datasets: [{
                label: 'Applications',
                data: {!! json_encode($monthlyApplications->pluck('count')) !!},
                borderColor: '#4158D0',
                backgroundColor: 'rgba(65, 88, 208, 0.1)',
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
    });

    // Categorie
});
</script>
@endpush
@endsection
