```php
{{-- resources/views/backend/dashboard/company.blade.php --}}
@extends('admin.index')

@section('css')
<style>
.company-header {
    background: linear-gradient(45deg, #2563eb 0%, #4f46e5 100%);
    border-radius: 1.5rem;
    padding: 2rem;
    margin-bottom: 2rem;
}

.stats-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 1rem;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.15);
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

.tender-card {
    border: 1px solid #e5e7eb;
    border-radius: 1rem;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.tender-card:hover {
    border-color: #3b82f6;
    background: #f8fafc;
}

.applicant-card {
    position: relative;
    padding: 1rem;
    border-radius: 1rem;
    background: #f8fafc;
    transition: all 0.3s ease;
}

.applicant-card:hover {
    background: #f1f5f9;
}

.progress-thin {
    height: 4px;
    border-radius: 2px;
}

.chart-container {
    position: relative;
    height: 300px;
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
                    <div class="company-logo me-4">
                        <div class="bg-white rounded-3 d-flex align-items-center justify-content-center"
                             style="width: 64px; height: 64px;">
                            <span class="text-primary fw-bold">
                                {{ strtoupper(substr($company->name, 0, 2)) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <h1 class="mb-1">{{ $company->name }}</h1>
                        <p class="mb-0 opacity-75">{{ $company->address }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="stats-card">
                            <div class="d-flex justify-content-between mb-2">
                                <p class="mb-0 opacity-75">Active Tenders</p>
                                <i class="fas fa-file-alt opacity-50"></i>
                            </div>
                            <h3 class="mb-0">{{ $statistics['active_tenders'] }}</h3>
                            <div class="progress progress-thin mt-2">
                                <div class="progress-bar bg-white" style="width: {{ ($statistics['active_tenders'] / max($statistics['total_tenders'], 1)) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="stats-card">
                            <div class="d-flex justify-content-between mb-2">
                                <p class="mb-0 opacity-75">Total Applicants</p>
                                <i class="fas fa-users opacity-50"></i>
                            </div>
                            <h3 class="mb-0">{{ $statistics['total_applicants'] }}</h3>
                            <p class="mb-0 small opacity-75">
                                <i class="fas fa-arrow-up me-1"></i>
                                {{ $statistics['recent_applications'] }} new this month
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Applications Chart -->
        <div class="col-lg-8">
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

        <!-- Tender Performance -->
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="mb-0">Tender Performance</h5>
                </div>
                <div class="card-body">
                    @foreach($tenderPerformance as $tender)
                    <div class="tender-card mb-3">
                        <h6 class="mb-2">{{ $tender->title }}</h6>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">{{ $tender->applicants_count }} applicants</span>
                            <span class="badge {{ $tender->end_date > now() ? 'bg-success' : 'bg-danger' }}">
                                {{ $tender->end_date > now() ? 'Active' : 'Closed' }}
                            </span>
                        </div>
                        <div class="progress progress-thin">
                            <div class="progress-bar bg-primary" 
                                 style="width: {{ min(($tender->applicants_count / 20) * 100, 100) }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Applicants -->
        <div class="col-lg-6">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="mb-0">Recent Applicants</h5>
                </div>
                <div class="card-body">
                    @foreach($recentApplicants as $applicant)
                    <div class="applicant-card mb-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 45px; height: 45px;">
                                    <span class="text-primary">
                                        {{ strtoupper(substr($applicant->user->name, 0, 2)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">{{ $applicant->user->name }}</h6>
                                    <small class="text-muted">
                                        {{ $applicant->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <p class="text-muted small mb-0">
                                    Applied for {{ $applicant->tender->title }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Application Status -->
        <div class="col-lg-6">
            <div class="dashboard-card">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="mb-0">Application Status</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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