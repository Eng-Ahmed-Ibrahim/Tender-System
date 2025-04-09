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
                            {{__('Track and manage all your tender listings efficiently')}}
                        </p>
                    </div>
                    <div class="col-lg-6 text-lg-end mt-4 mt-lg-0">
                        <div class="d-inline-flex gap-3">
                            <div class="bg-white bg-opacity-10 rounded-3 p-4 text-center">
                                <h3 class="text-white mb-1">{{ $tenders->total() }}</h3>
                                <small class="text-white-50 fw-semibold">  {{__('Total Tenders')}}</small>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-3 p-4 text-center">
                                <h3 class="text-white mb-1">
                                    {{ $tenders->where('end_date', '>', now())->count() }}
                                </h3>
                                <small class="text-white-50 fw-semibold">  {{__('Active Tenders')}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    @include('company.tenders.partials.filter')

    <!-- Tenders Grid View -->
<!-- Tenders Grid View -->
<div id="tendersContainer" class="row g-4">
    @include('company.tenders.partials.tender-grid')
</div>


</div>

<!-- QR Code Modal -->
<div class="modal fade" id="qrCodeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title">  {{__('QR Code')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-5">
                <div id="qrCodeContainer" class="mb-4">

                </div>
                <button class="btn btn-primary" id="printQrCode">
                    <i class="fas fa-print me-2"></i>  {{__('Print QR Code')}}
                </button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {

    let currentFilters = {
        search: '',
        startDate: '',
        endDate: '',
        companies: [],
        status: 'all',
        sort: 'date-desc'
    };

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

    function applyFilters() {
        const tendersContainer = document.getElementById('tendersContainer');
        
        tendersContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;

        const params = new URLSearchParams({
            search: currentFilters.search,
            start_date: currentFilters.startDate,
            end_date: currentFilters.endDate,
            status: currentFilters.status,
            sort: currentFilters.sort,
            partial: true 
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

            tendersContainer.innerHTML = html;
            
            const newUrl = `${window.location.pathname}?${params.toString()}`;

            window.history.pushState({ path: newUrl }, '', newUrl);

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

    function initializeComponents() {

        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(tooltip => {
            new bootstrap.Tooltip(tooltip);
        });

        const qrCodeButtons = document.querySelectorAll('.show-qr-code');
        qrCodeButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const tenderId = this.dataset.id;
                showQrCode(tenderId);
            });
        });
    }

    initializeComponents();
});
    </script>

@endsection

