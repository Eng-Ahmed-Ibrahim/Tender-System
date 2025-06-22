{{-- resources/views/backend/applicants/show.blade.php --}}
@extends('admin.index')

@section('css')
    <style>
        .header-banner {
            background: linear-gradient(45deg, #3b82f6 0%, #8b5cf6 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
        }

        .application-card {
            transition: all 0.3s ease;
            border: none !important;
            border-radius: 1rem;
        }

        .application-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-badge.active {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-badge.closed {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .document-card {
            background: #f8fafc;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 0.5rem;
        }

        .timeline-item {
            position: relative;
            padding-left: 2.5rem;
            padding-bottom: 2rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e2e8f0;
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            left: -0.5rem;
            top: 0;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            background: #3b82f6;
            border: 3px solid #fff;
        }

        .company-card {
            background: #fff;
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid p-4">
        <!-- Header Banner -->
        <div class="header-banner text-white mb-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-4">
                            <div class="avatar bg-white text-primary" style="width: 80px; height: 80px; border-radius: 1rem;">
                                {{ strtoupper(substr($applicant->name, 0, 2)) }}
                            </div>
                        </div>
                        <div>
                            <h1 class="display-6 fw-bold mb-1">{{ $applicant->name }}</h1>
                            <div class="d-flex align-items-center opacity-75">
                                <i class="fas fa-envelope me-2"></i>
                                {{ $applicant->email }}
                                @if ($applicant->phone)
                                    <span class="mx-3">|</span>
                                    <i class="fas fa-phone me-2"></i>
                                    {{ $applicant->phone }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="profile-card">
                                <h3 class="mb-1">{{ $statistics['total_applications'] }}</h3>
                                <p class="mb-0 text-white-50">{{ __('Total Applications') }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="profile-card">
                                <h3 class="mb-1">{{ $statistics['active_applications'] }}</h3>
                                <p class="mb-0 text-white-50">{{ __('Active Applications') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Applications Timeline -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0">{{ __('Application History') }}</h5>
                    </div>
                    <div class="card-body">
                        @forelse($applicant->applicants as $application)
                            @php $tender= $application->tender ; @endphp
                            <div class="timeline-item">
                                <div class="application-card card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-3">
                                            <h5 class="mb-0">
                                                <a href="{{ route('tenders.show', $application->tender->id) }}"
                                                    class="text-decoration-none">
                                                    {{ $application->tender->title }}
                                                </a>
                                            </h5>
                                            <span
                                                class="status-badge {{ $application->tender->end_date > now() ? 'active' : 'closed' }}">
                                                {{ $application->tender->end_date > now() ? __('Active') : __('Closed') }}
                                            </span>
                                        </div>

                                        <div class="company-card mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-light text-dark me-3"
                                                    style="width: 40px; height: 40px; border-radius: 0.5rem;">
                                                    {{ strtoupper(substr($application->tender->company->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">{{ $application->tender->company->name }}</h6>
                                                    <p class="text-muted mb-0 small">
                                                        {{ $application->tender->company->address }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="application-details mb-3">
                                            <h6 class="text-muted mb-2">{{ __('Application Details') }}</h6>
                                            <div class="bg-light rounded p-3">
                                                {!! $application->application_details !!}
                                            </div>
                                        </div>
                                        @can('applicant.show.files')
                                            <!-- Files -->
                                            <div class="col-12 col-md-12 col-lg-12 mb-3 mb-lg-0"
                                                style="display: flex;gap: 15px;">
                                                @if ($application->files)
                                                    @php
                                                        $fileArray = array_filter(explode(',', $application->files));
                                                    @endphp
                                                    <div class="d-flex flex-wrap">
                                                        @foreach ($fileArray as $file)
                                                            <a href="{{ asset('storage/' . trim($file)) }}"
                                                                class="file-badge text-decoration-none me-2 mb-2"
                                                                target="_blank">
                                                                <i class="fas fa-file-alt me-1"></i>
                                                                {{-- {{ basename(trim($file)) }} --}}
                                                                {{ __('Technical file') }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <span class="badge bg-warning">{{ __('No files') }}</span>
                                                @endif

                                                @if ($tender->status == false || \Carbon\Carbon::parse($tender->end_date)->lt(\Carbon\Carbon::today()))
                                                    @if ($application->quantity_file)
                                                        @php
                                                            $fileArray = array_filter(
                                                                explode(',', $application->quantity_file),
                                                            );
                                                        @endphp
                                                        <div class="d-flex flex-wrap">
                                                            @foreach ($fileArray as $file)
                                                                <a href="{{ asset('storage/' . trim($file)) }}"
                                                                    class="file-badge text-decoration-none me-2 mb-2"
                                                                    target="_blank">
                                                                    <i class="fas fa-file-alt me-1"></i>
                                                                    {{ __('Quantity file') }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="badge bg-warning">{{ __('No files') }}</span>
                                                    @endif

                                                    @if ($application->financial_file)
                                                        @php
                                                            $fileArray = array_filter(
                                                                explode(',', $application->financial_file),
                                                            );
                                                        @endphp
                                                        <div class="d-flex flex-wrap">
                                                            @foreach ($fileArray as $file)
                                                                <a href="{{ asset('storage/' . trim($file)) }}"
                                                                    class="file-badge text-decoration-none me-2 mb-2"
                                                                    target="_blank">
                                                                    <i class="fas fa-file-alt me-1"></i>
                                                                    {{ __('Financial file') }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="badge bg-warning">{{ __('No files') }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        @endcan

                                        {{-- @if ($files = json_decode($application->files))
                                            <div class="submitted-documents">
                                                <h6 class="text-muted mb-2">{{ __('Submitted Documents') }}</h6>
                                                <div class="row g-2">
                                                    @foreach ($files as $file)
                                                        <div class="col-md-6">
                                                            <div class="document-card">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center">
                                                                    <div>
                                                                        <i class="fas fa-file-alt me-2 text-primary"></i>
                                                                        {{ basename($file) }}
                                                                    </div>
                                                                    <a href="{{ Storage::url($file) }}"
                                                                        class="btn btn-sm btn-light" target="_blank">
                                                                        <i class="fas fa-download"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif --}}

                                        <div class="mt-3 text-muted small">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ __('Applied') }} {{ $application->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty

                            <!-- Actions -->
                            <div class="text-center py-5">
                                <img src="/images/no-data.svg" alt="No Applications" class="mb-3" style="width: 120px;">
                                <h4>{{ __('No Applications Yet') }}</h4>
                                <p class="text-muted">{{ __('This applicant has not submitted any applications.') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Profile Information -->
                <div class="card mb-4">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0">{{ __('Profile Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted small">{{ __('Full Name') }}</label>
                            <p class="mb-0">{{ $applicant->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">{{ __('Email Address') }}</label>
                            <p class="mb-0">{{ $applicant->email }}</p>
                        </div>
                        @if ($applicant->phone)
                            <div class="mb-3">
                                <label class="text-muted small">{{ __('Phone Number') }}</label>
                                <p class="mb-0">{{ $applicant->phone }}</p>
                            </div>
                        @endif
                        @if ($applicant->address)
                            <div class="mb-3">
                                <label class="text-muted small">{{ __('Address') }}</label>
                                <p class="mb-0">{{ $applicant->address }}</p>
                            </div>
                        @endif
                        <div>
                            <label class="text-muted small">{{ __('Member Since') }}</label>
                            <p class="mb-0">{{ $applicant->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="card">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0">{{ __('Activity Statistics') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-3 bg-light rounded">
                                    <h3 class="mb-1">{{ $statistics['total_applications'] }}</h3>
                                    <p class="text-muted mb-0 small">{{ __('Total Applications') }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded">
                                    <h3 class="mb-1">{{ $statistics['active_applications'] }}</h3>
                                    <p class="text-muted mb-0 small">{{ __('Active Applications') }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded">
                                    <h3 class="mb-1">{{ $statistics['documents_submitted'] }}</h3>
                                    <p class="text-muted mb-0 small">{{ __('Documents Submitted') }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded">
                                    <h3 class="mb-1">{{ $statistics['recent_activity'] }}</h3>
                                    <p class="text-muted mb-0 small">{{ __('Recent Activity') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
