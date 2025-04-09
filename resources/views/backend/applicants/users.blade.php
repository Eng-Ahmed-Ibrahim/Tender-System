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
                <h1 class="display-6 fw-bold mb-2">{{ __('Users Management') }}</h1>
                {{-- <p class="lead mb-0 opacity-75">
                    {{ __('Track and manage tender applicants') }}
                </p> --}}
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-sm-6 col-md-3">
                        <div class="stats-card">
                            <h3 class="mb-1">{{ $statistics['total_applicants'] }}</h3>
                            <p class="mb-0 text-white-50">{{ __('users') }}</p>
                        </div>
                    </div>
                 
                  
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
<!-- Advanced Filter Section -->
<div class="card card-flush mb-5 shadow-sm">
    <div class="card-header min-h-65px">
        <h3 class="card-title align-items-start flex-column">
          
        </h3>
        <div class="card-toolbar">
            <button type="button" class="btn btn-sm btn-light" id="resetFilters">
                <i class="ki-duotone ki-filter-off fs-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                {{ __('Reset') }}
            </button>
        </div>
    </div>
    <div class="card-body pt-5">
        <div class="d-flex justify-content-between mb-4">
            <h3 class="card-title">{{ __('Applicants') }}</h3>
            <a href="{{ route('Applicants.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> {{ __('New User') }}
            </a>
        </div>
        
        <form id="filterForm" class="row g-4">
            <!-- Search Input -->
            <div class="col-12 col-md-3">
                <label class="form-label text-gray-600">{{ __('Search') }}</label>
                <div class="position-relative">
                    <span class="position-absolute top-50 translate-middle-y ms-4">
                        <i class="ki-duotone ki-magnifier fs-3 text-gray-500">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </span>
                    <input type="text"
                           class="form-control form-control-solid ps-12"
                           placeholder="{{ __('Search users...') }}"
                           name="search"
                           value="{{ request('search') }}"
                           data-kt-filter="search"/>
                </div>
            </div>
        </form>
    </div> 
</div>

@push('styles')
<style>
    .form-select-solid,
    .form-control-solid {
        transition: color 0.2s ease, background-color 0.2s ease;
    }

    .form-select-solid:focus,
    .form-control-solid:focus {
        background-color: #f5f8fa;
        border-color: #009ef7;
        color: #5e6278;
        box-shadow: none;
    }

    .daterangepicker {
        box-shadow: 0 0 50px 0 rgb(82 63 105 / 15%);
        border: 0;
    }

    .daterangepicker .ranges ul {
        padding: 1rem 0;
        width: 175px;
    }

    .daterangepicker .ranges li:hover {
        background-color: #f5f8fa;
    }

    .daterangepicker .ranges li.active {
        background-color: #009ef7;
    }
</style>
@endpush

<script>
$(document).ready(function() {
    // Initialize Select2
    $('select[data-control="select2"]').select2({
        minimumResultsForSearch: 10,
        dropdownParent: $('#filterForm')
    });

    // Initialize DateRangePicker
    $('#dateRangePicker').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: '{{ __("Clear") }}',
            applyLabel: '{{ __("Apply") }}',
            fromLabel: '{{ __("From") }}',
            toLabel: '{{ __("To") }}',
            customRangeLabel: '{{ __("Custom") }}',
            weekLabel: 'W',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June',
                        'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        },
        ranges: {
           '{{ __("Today") }}': [moment(), moment()],
           '{{ __("Yesterday") }}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           '{{ __("Last 7 Days") }}': [moment().subtract(6, 'days'), moment()],
           '{{ __("Last 30 Days") }}': [moment().subtract(29, 'days'), moment()],
           '{{ __("This Month") }}': [moment().startOf('month'), moment().endOf('month')],
           '{{ __("Last Month") }}': [moment().subtract(1, 'month').startOf('month'), 
                                     moment().subtract(1, 'month').endOf('month')]
        }
    });

    // Handle date range picker events
    $('#dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        $('input[name="date_from"]').val(picker.startDate.format('YYYY-MM-DD'));
        $('input[name="date_to"]').val(picker.endDate.format('YYYY-MM-DD'));
        $('#filterForm').submit();
    });

    $('#dateRangePicker').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        $('input[name="date_from"]').val('');
        $('input[name="date_to"]').val('');
        $('#filterForm').submit();
    });

    // Auto-submit form on change
    $('#filterForm select, #filterForm input[type="text"]').on('change', function() {
        $('#filterForm').submit();
    });

    // Reset filters
    $('#resetFilters').on('click', function() {
        $('#filterForm')[0].reset();
        $('select[data-control="select2"]').val(null).trigger('change');
        $('#dateRangePicker').val('');
        $('input[name="date_from"]').val('');
        $('input[name="date_to"]').val('');
        $('#filterForm').submit();
    });
});
</script>

    <!-- Applicants List -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">{{ __('Users') }}</th>
                            <th>{{ __('Applications') }}</th>
                            <th>{{ __('Latest Tender') }}</th>
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
                                                {{ $latestApplication->created_at}}
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">{{ __('No applications') }}</span>
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
                                                   href="{{ route('Applicants.show', $applicant->id) }}">
                                                    <i class="fas fa-eye me-2"></i>
                                                    {{ __('View Details') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                   href="{{ route('Applicants.edit', $applicant->id) }}">
                                                    <i class="fas fa-edit me-2"></i>
                                                    {{ __('Edit') }}
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('Applicants.destroy', $applicant->id) }}"
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

        // Fetch filtered results using a full page load instead of AJAX
        // This is more reliable if server-side isn't properly set up for AJAX requests
        window.location.href = `${window.location.pathname}?${params.toString()}`;
    }

    // Reset filters button
    const resetButton = document.getElementById('resetFilters');
    if (resetButton) {
        resetButton.addEventListener('click', function(e) {
            e.preventDefault();
            filterForm.reset();
            
            // Reset Select2 components
            document.querySelectorAll('select[data-control="select2"]').forEach(select => {
                if (window.jQuery && jQuery(select).data('select2')) {
                    jQuery(select).val('').trigger('change');
                }
            });
            
            // Reset date range picker
            const dateRangePicker = document.getElementById('dateRangePicker');
            if (dateRangePicker) {
                dateRangePicker.value = '';
                document.querySelector('input[name="date_from"]').value = '';
                document.querySelector('input[name="date_to"]').value = '';
            }
            
            // Submit the form with reset values
            window.location.href = window.location.pathname;
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

        // Use a standard fetch without the X-Requested-With header
        fetch(`/applications/${applicationId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                modalContent.innerHTML = html;
            })
            .catch(error => {
                modalContent.innerHTML = `
                    <div class="alert alert-danger m-3">
                        ${error.message || 'Failed to load application details'}
                    </div>
                `;
            });
    }

    // Initialize tooltips and other components
    function initializeComponents() {
        if (window.bootstrap) {
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(tooltip => {
                new bootstrap.Tooltip(tooltip);
            });
        }
    }

    // Initial initialization
    initializeComponents();
});
</script>

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