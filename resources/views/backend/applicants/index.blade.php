@extends('admin.index')

@section('css')
<style>
.header-banner {
    background: linear-gradient(45deg, #3b82f6 0%, #8b5cf6 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
}

.stats-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 1rem;
    padding: 1.5rem;
}

.applicant-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 1rem;
}

.application-badge {
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.tender-link {
    color: #4f46e5;
    text-decoration: none;
    transition: all 0.2s;
}

.tender-link:hover {
    color: #4338ca;
}

.file-badge {
    background: #f3f4f6;
    padding: 0.25rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    color: #4b5563;
}

.company-avatar {
    width: 32px;
    height: 32px;
    background: #e5e7eb;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 600;
    color: #4b5563;
}
</style>
@endsection

@section('content')
<div class="container-fluid p-4">
    <!-- Header Banner -->
    <div class="header-banner text-white mb-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-6 fw-bold mb-2">{{ __('Applicant Management') }}</h1>
                <p class="lead mb-0 opacity-75">
                    {{ __('Track and manage tender applicants') }}
                </p>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-sm-6 col-md-3">
                        <div class="stats-card">
                            <h3 class="mb-1">{{ $statistics['total_applicants'] }}</h3>
                            <p class="mb-0 text-white-50">{{ __('Total Applicants') }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="stats-card">
                            <h3 class="mb-1">{{ $statistics['total_applications'] }}</h3>
                            <p class="mb-0 text-white-50">{{ __('Applications') }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="stats-card">
                            <h3 class="mb-1">{{ $statistics['recent_applications'] }}</h3>
                            <p class="mb-0 text-white-50">{{ __('Recent') }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="stats-card">
                            <h3 class="mb-1">{{ $statistics['active_tenders'] }}</h3>
                            <p class="mb-0 text-white-50">{{ __('Active Tenders') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form id="filterForm" class="row g-3">
                <div class="col-md-3">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" 
                               class="form-control ps-5" 
                               placeholder="{{ __('Search applicants...') }}"
                               name="search"
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="tender">
                        <option value="">{{ __('All Tenders') }}</option>
                        @foreach($tenders as $tender)
                            <option value="{{ $tender->id }}" 
                                    {{ request('tender') == $tender->id ? 'selected' : '' }}>
                                {{ $tender->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="company">
                        <option value="">{{ __('All Companies') }}</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" 
                                    {{ request('company') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                        <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Applicants List -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">{{ __('Applicant') }}</th>
                            <th>{{ __('Applications') }}</th>
                            <th>{{ __('Latest Tender') }}</th>
                            <th>{{ __('Company') }}</th>
                            <th>{{ __('Files') }}</th>
                            <th class="text-end pe-4">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applicants as $applicant)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar {{ !$applicant->avatar ? 'bg-primary text-white' : '' }}" 
                                                 style="width: 40px; height: 40px; border-radius: 10px;">
                                                @if($applicant->avatar)
                                                    <img src="{{ $applicant->avatar }}" 
                                                         alt="{{ $applicant->name }}"
                                                         class="w-100 h-100 rounded">
                                                @else
                                                    <span class="position-absolute top-50 start-50 translate-middle">
                                                        {{ strtoupper(substr($applicant->name, 0, 2)) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $applicant->name }}</h6>
                                            <small class="text-muted">{{ $applicant->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5 class="mb-0">{{ $applicant->applicants->count() }}</h5>
                                    <small class="text-muted">Applications</small>
                                </td>
                                <td>
                                    @if($latestApplication = $applicant->applicants->sortByDesc('created_at')->first())
                                        <div>
                                            <a href="{{ route('tenders.show', $latestApplication->tender_id) }}" 
                                               class="tender-link">
                                                {{ $latestApplication->tender->title }}
                                            </a>
                                            <div class="text-muted small">
                                                {{ $latestApplication->created_at->format('M d, Y') }}
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">{{ __('No applications') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($latestApplication)
                                        <div class="d-flex align-items-center">
                                            <div class="company-avatar me-2">
                                                {{ strtoupper(substr($latestApplication->tender->company->name, 0, 2)) }}
                                            </div>
                                            <span>{{ $latestApplication->tender->company->name }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($latestApplication)
                                        @php
                                            $files = json_decode($latestApplication->files);
                                        @endphp
                                        @if($files)
                                            @foreach($files as $file)
                                                <span class="file-badge me-1">
                                                    <i class="fas fa-file me-1"></i>
                                                    {{ basename($file) }}
                                                </span>
                                            @endforeach
                                        @endif
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" 
                                                   href="{{ route('applicants.show', $applicant->id) }}">
                                                    <i class="fas fa-eye me-2"></i>
                                                    {{ __('View Details') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" 
                                                   href="{{ route('applicants.edit', $applicant->id) }}">
                                                    <i class="fas fa-edit me-2"></i>
                                                    {{ __('Edit') }}
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('applicants.destroy', $applicant->id) }}" 
                                                      method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="dropdown-item text-danger"
                                                            onclick="return confirm('{{ __('Are you sure?') }}')">
                                                        <i class="fas fa-trash-alt me-2"></i>
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img src="/images/no-data.svg" 
                                         alt="No Data" 
                                         style="width: 120px; margin-bottom: 1rem;">
                                    <h4>{{ __('No Applicants Found') }}</h4>
                                    <p class="text-muted">
                                        {{ __('There are no applicants matching your search criteria.') }}
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($applicants->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
            {{ __('Showing') }} {{ $applicants->firstItem() }} {{ __('to') }} {{ $applicants->lastItem() }}
            {{ __('of') }} {{ $applicants->total() }} {{ __('entries') }}
        </div>
        {{ $applicants->links('pagination::bootstrap-5') }}
    </div>
    @endif

</div>

<!-- Application Details Modal -->
<div class="modal fade" id="applicationModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title">{{ __('Application Details') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="applicationModalContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter form handling
    const filterForm = document.getElementById('filterForm');
    const filterInputs = filterForm.querySelectorAll('input, select');

    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            applyFilters();
        });
    });

    // Search input with debounce
    const searchInput = filterForm.querySelector('input[name="search"]');
    let searchTimeout;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            applyFilters();
        }, 500);
    });

    function applyFilters() {
        const tableBody = document.querySelector('tbody');
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);

        // Show loading state
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </td>
            </tr>
        `;

        // Fetch filtered results
        fetch(`${window.location.pathname}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            document.querySelector('.table-responsive').innerHTML = html;
            history.pushState({}, '', `${window.location.pathname}?${params.toString()}`);
            initializeComponents();
        })
        .catch(error => {
            console.error('Error:', error);
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="alert alert-danger mb-0">
                            ${error.message || '{{ __("An error occurred while fetching data") }}'}
                        </div>
                    </td>
                </tr>
            `;
        });
    }

    // View application details
    window.viewApplication = function(applicationId) {
        const modal = document.getElementById('applicationModal');
        const modalContent = document.getElementById('applicationModalContent');

        modalContent.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;

        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();

        fetch(`/applications/${applicationId}`)
            .then(response => response.text())
            .then(html => {
                modalContent.innerHTML = html;
            })
            .catch(error => {
                modalContent.innerHTML = `
                    <div class="alert alert-danger m-3">
                        ${error.message || '{{ __("Failed to load application details") }}'}
                    </div>
                `;
            });
    }

    // Initialize tooltips and other components
    function initializeComponents() {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(tooltip => {
            new bootstrap.Tooltip(tooltip);
        });
    }

    // Initial initialization
    initializeComponents();
});
</script>
@endpush

@push('styles')
<style>
/* Add any additional styles here */
.table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
}

.dropdown-menu {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    border: none;
}

.file-badge {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 150px;
    display: inline-block;
}

.tender-link:hover {
    text-decoration: underline;
}

.avatar {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

/* Animation for status changes */
.table tbody tr {
    transition: background-color 0.3s ease;
}

.table tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

/* Custom scrollbar for table */
.table-responsive::-webkit-scrollbar {
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Loading shimmer effect */
@keyframes shimmer {
    0% {
        background-position: -1000px 0;
    }
    100% {
        background-position: 1000px 0;
    }
}

.loading-shimmer {
    animation: shimmer 2s infinite linear;
    background: linear-gradient(to right, #f6f7f8 0%, #edeef1 20%, #f6f7f8 40%, #f6f7f8 100%);
    background-size: 1000px 100%;
}
</style>
@endpush