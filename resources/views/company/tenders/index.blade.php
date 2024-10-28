@extends('admin.index')
@section('css')

<style>
.hover-shadow-lg {
    transition: all 0.3s ease;
}
.hover-shadow-lg:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
}
.description-truncate {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
.dropdown-menu {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
</style>
@endsection

@section('content')
<div class="container-fluid p-4">
    <!-- Animated Header Section -->
    <div class="position-relative mb-5">
        <div class="card bg-primary border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(45deg, #4158d0 0%, #c850c0 46%, #ffcc70 100%);"></div>
            <div class="card-body position-relative p-5">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="display-4 fw-bold text-white mb-3">
                            {{ __('Tender Management') }}
                        </h1>
                        <p class="lead text-white-50 mb-0">
                            Track and manage all your tender listings efficiently
                        </p>
                    </div>
                    <div class="col-lg-6 text-lg-end mt-4 mt-lg-0">
                        <div class="d-inline-flex gap-3">
                            <div class="bg-white bg-opacity-10 rounded-3 p-4 text-center">
                                <h3 class="text-white mb-1">{{ $tenders->total() }}</h3>
                                <small class="text-white-50 fw-semibold">Total Tenders</small>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-3 p-4 text-center">
                                <h3 class="text-white mb-1">
                                    {{ $tenders->where('end_date', '>', now())->count() }}
                                </h3>
                                <small class="text-white-50 fw-semibold">Active Tenders</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-sm border-0 rounded-4 mb-5">
        <div class="card-body p-4">
            <div class="row g-4">
                <!-- Search Bar -->
                <div class="col-12">
                    <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                        <span class="input-group-text border-0 bg-light px-4">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-0 bg-light" 
                               placeholder="Search tenders by title, description...">
                        <button class="btn btn-primary px-4" type="button" id="searchButton">
                            Search
                        </button>
                    </div>
                </div>

                <!-- Filters Dropdown -->
                <div class="col-12">
                    <div class="dropdown d-inline-block me-2">
                        <button class="btn btn-light dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-calendar-alt me-2"></i>Date Range
                        </button>
                        <div class="dropdown-menu p-3" style="min-width: 300px;">
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" id="endDate">
                            </div>
                            <button class="btn btn-primary w-100" id="applyDateFilter">Apply</button>
                        </div>
                    </div>

                    @if(auth()->user()->role === 'admin')
                    <div class="dropdown d-inline-block me-2">
                        <button class="btn btn-light dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-building me-2"></i>Company
                        </button>
                        <div class="dropdown-menu p-3" style="min-width: 250px;">
                            <div class="mb-3">
                                <input type="text" class="form-control mb-2" placeholder="Search companies...">
                                <div style="max-height: 200px; overflow-y: auto;">
                                    @foreach($companies as $company)
                                    <div class="form-check">
                                        <input class="form-check-input company-filter" type="checkbox" 
                                               value="{{ $company->id }}" id="company{{ $company->id }}">
                                        <label class="form-check-label" for="company{{ $company->id }}">
                                            {{ $company->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <button class="btn btn-primary w-100" id="applyCompanyFilter">Apply</button>
                        </div>
                    </div>
                    @endif

                    <div class="dropdown d-inline-block me-2">
                        <button class="btn btn-light dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-2"></i>Status
                        </button>
                        <div class="dropdown-menu p-3" style="min-width: 200px;">
                            <div class="form-check mb-2">
                                <input class="form-check-input status-filter" type="radio" name="status" 
                                       value="all" id="statusAll" checked>
                                <label class="form-check-label" for="statusAll">All</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input status-filter" type="radio" name="status" 
                                       value="open" id="statusOpen">
                                <label class="form-check-label" for="statusOpen">Open</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input status-filter" type="radio" name="status" 
                                       value="closed" id="statusClosed">
                                <label class="form-check-label" for="statusClosed">Closed</label>
                            </div>
                            <button class="btn btn-primary w-100 mt-2" id="applyStatusFilter">Apply</button>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button class="btn btn-light dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-sort me-2"></i>Sort By
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" data-sort="date-desc">
                                <i class="fas fa-sort-amount-down me-2"></i>Latest First
                            </a>
                            <a class="dropdown-item" href="#" data-sort="date-asc">
                                <i class="fas fa-sort-amount-up me-2"></i>Oldest First
                            </a>
                            <a class="dropdown-item" href="#" data-sort="title-asc">
                                <i class="fas fa-sort-alpha-down me-2"></i>Title A-Z
                            </a>
                            <a class="dropdown-item" href="#" data-sort="title-desc">
                                <i class="fas fa-sort-alpha-up me-2"></i>Title Z-A
                            </a>
                        </div>
                    </div>

                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createTenderModal">
                        <i class="fas fa-plus me-2"></i>Create Tender
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tenders Grid View -->
<!-- Tenders Grid View -->
<div id="tendersContainer" class="row g-4">
    @include('company.tenders.partials.tender-grid')
</div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $tenders->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- QR Code Modal -->
<div class="modal fade" id="qrCodeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title">QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-5">
                <div id="qrCodeContainer" class="mb-4">
                    <!-- QR Code will be displayed here -->
                </div>
                <button class="btn btn-primary" id="printQrCode">
                    <i class="fas fa-print me-2"></i>Print QR Code
                </button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables to store filter states
    let currentFilters = {
        search: '',
        startDate: '',
        endDate: '',
        companies: [],
        status: 'all',
        sort: 'date-desc'
    };

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');

    searchButton.addEventListener('click', function() {
        currentFilters.search = searchInput.value;
        applyFilters();
    });

    // Handle enter key in search input
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            currentFilters.search = searchInput.value;
            applyFilters();
        }
    });

    // Date range filter
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const applyDateFilter = document.getElementById('applyDateFilter');

    applyDateFilter.addEventListener('click', function() {
        currentFilters.startDate = startDateInput.value;
        currentFilters.endDate = endDateInput.value;
        applyFilters();
    });

    // Company filter
    const companyCheckboxes = document.querySelectorAll('.company-filter');
    const applyCompanyFilter = document.getElementById('applyCompanyFilter');

    applyCompanyFilter?.addEventListener('click', function() {
        currentFilters.companies = Array.from(companyCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        applyFilters();
    });

    // Status filter
    const statusRadios = document.querySelectorAll('.status-filter');
    const applyStatusFilter = document.getElementById('applyStatusFilter');

    applyStatusFilter.addEventListener('click', function() {
        const selectedStatus = document.querySelector('input[name="status"]:checked');
        currentFilters.status = selectedStatus ? selectedStatus.value : 'all';
        applyFilters();
    });

    // Sort functionality
    const sortDropdownItems = document.querySelectorAll('[data-sort]');
    sortDropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            currentFilters.sort = this.dataset.sort;
            applyFilters();
        });
    });

    // Function to apply all filters
    function applyFilters() {
        const tendersContainer = document.getElementById('tendersContainer');
        
        // Show loading state
        tendersContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;

        // Construct URL with query parameters
        const params = new URLSearchParams({
            search: currentFilters.search,
            start_date: currentFilters.startDate,
            end_date: currentFilters.endDate,
            status: currentFilters.status,
            sort: currentFilters.sort,
            partial: true // Add this to indicate we want only the tender cards
        });

        if (currentFilters.companies.length > 0) {
            currentFilters.companies.forEach(company => {
                params.append('companies[]', company);
            });
        }

        // Make AJAX request
        fetch(`${window.location.pathname}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Update only the tenders container
            tendersContainer.innerHTML = html;
            
            // Update URL without reloading the page
            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.pushState({ path: newUrl }, '', newUrl);

            // Reinitialize components
            initializeComponents();
        })
        .catch(error => {
            console.error('Error fetching filtered results:', error);
            tendersContainer.innerHTML = `
                <div class="col-12 text-center py-5">
                    <div class="alert alert-danger" role="alert">
                        An error occurred while fetching results. Please try again.
                    </div>
                </div>
            `;
        });
    }

    // Function to initialize/reinitialize components after content update
    function initializeComponents() {
        // Reinitialize tooltips
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(tooltip => {
            new bootstrap.Tooltip(tooltip);
        });

        // Reinitialize QR code functionality
        const qrCodeButtons = document.querySelectorAll('.show-qr-code');
        qrCodeButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const tenderId = this.dataset.id;
                showQrCode(tenderId);
            });
        });
    }

    // Initialize components on page load
    initializeComponents();
});
    </script>

@endsection

