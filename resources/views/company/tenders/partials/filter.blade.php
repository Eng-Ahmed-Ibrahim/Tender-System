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
                        placeholder="{{ __('Search tenders by title, description...') }}">
                    <button class="btn btn-primary px-4" type="button" id="searchButton">
                        {{ __('Search') }}
                    </button>
                </div>
            </div>
            <!-- Add this with your other dropdown filters -->
            <!-- Replace the dynamic city dropdown with this static one -->

            <!-- Filters Dropdown -->
            <div class="col-12">
                <select id="countryFilter" class="form-select" style="    display: inline-block;width: 100px;">
                    <option value="">{{ __('Country') }}</option>

                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }} ({{ $country->name_ar }})</option>
                    @endforeach
                </select>
                <div class="dropdown d-inline-block me-2">
                    <button class="btn btn-light dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-city me-2"></i>{{ __('City') }}
                    </button>
                    <div class="dropdown-menu p-3" style="min-width: 250px;">
                        <div class="mb-3">
                            <select id="cityFilter" class="form-select">
                                <option value="">{{ __('All Cities') }}</option>
                            </select>
                        </div>
                        <button class="btn btn-primary w-100" id="applyCityFilter">{{ __('Apply') }}</button>
                    </div>
                </div>
                <div class="dropdown d-inline-block me-2">
                    <button class="btn btn-light dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-calendar-alt me-2"></i>{{ __('Date Range') }}
                    </button>
                    <div class="dropdown-menu p-3" style="min-width: 300px;">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Start Date') }}</label>
                            <input type="date" class="form-control" id="startDate">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('End Date') }}</label>
                            <input type="date" class="form-control" id="endDate">
                        </div>
                        <button class="btn btn-primary w-100" id="applyDateFilter">{{ __('Apply') }}</button>
                    </div>
                </div>

                @if (auth()->user()->role === 'admin')
                    <div class="dropdown d-inline-block me-2">
                        <button class="btn btn-light dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-building me-2"></i>{{ __('Company') }}
                        </button>
                        <div class="dropdown-menu p-3" style="min-width: 250px;">
                            <div class="mb-3">
                                <input type="text" class="form-control mb-2" placeholder="Search companies...">
                                <div style="max-height: 200px; overflow-y: auto;">
                                    @foreach ($companies as $company)
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
                            <button class="btn btn-primary w-100" id="applyCompanyFilter">{{ __('Apply') }}</button>
                        </div>
                    </div>
                @endif

                <div class="dropdown d-inline-block me-2">
                    <button class="btn btn-light dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-2"></i>{{ __('Status') }}
                    </button>
                    <div class="dropdown-menu p-3" style="min-width: 200px;">
                        <div class="form-check mb-2">
                            <input class="form-check-input status-filter" type="radio" name="status" value="all"
                                id="statusAll" checked>
                            <label class="form-check-label" for="statusAll">{{ __('All') }}</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input status-filter" type="radio" name="status" value="open"
                                id="statusOpen">
                            <label class="form-check-label" for="statusOpen">{{ __('Open') }}</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input status-filter" type="radio" name="status" value="closed"
                                id="statusClosed">
                            <label class="form-check-label" for="statusClosed">{{ __('Closed') }}</label>
                        </div>
                        <button class="btn btn-primary w-100 mt-2"
                            id="applyStatusFilter">{{ __('Apply') }}</button>
                    </div>
                </div>

                <div class="dropdown d-inline-block me-2">
                    <button class="btn btn-light dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-sort me-2"></i>{{ __('Sort By') }}
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" data-sort="date-desc">
                            <i class="fas fa-sort-amount-down me-2"></i>{{ __('Latest First') }}
                        </a>
                        <a class="dropdown-item" href="#" data-sort="date-asc">
                            <i class="fas fa-sort-amount-up me-2"></i>{{ __('Oldest First') }}
                        </a>
                        <a class="dropdown-item" href="#" data-sort="title-asc">
                            <i class="fas fa-sort-alpha-down me-2"></i>{{ __('Title A-Z') }}
                        </a>
                        <a class="dropdown-item" href="#" data-sort="title-desc">
                            <i class="fas fa-sort-alpha-up me-2"></i>{{ __('Title Z-A') }}
                        </a>
                    </div>
                </div>

                <!-- New Export Dropdown -->
                <div class="dropdown d-inline-block me-2">
                    <button class="btn btn-light dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-download me-2"></i>{{ __('Export') }}
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('tenders.export', 'excel') }}" id="exportExcel">
                            <i class="fas fa-file-excel me-2 text-success"></i>{{ __('Export to Excel') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('tenders.export', 'pdf') }}" id="exportPdf">
                            <i class="fas fa-file-pdf me-2 text-danger"></i>{{ __('Export to PDF') }}
                        </a>
                    </div>
                </div>
                <a class="btn btn-primary float-end" href="{{ route('tenders.create') }}">
                    <i class="fas fa-plus me-2"></i>{{ __('Create Tender') }}
                </a>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.getElementById('applyCityFilter').addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        console.log("City filter apply button clicked");
        const selectedCity = document.getElementById('cityFilter').value;
        console.log("Selected city:", selectedCity);

        // Get the current URL without query parameters
        const currentPath = window.location.pathname;

        // Keep all existing query parameters
        const urlParams = new URLSearchParams(window.location.search);

        // Update or remove the city parameter
        if (selectedCity) {
            urlParams.set('city', selectedCity);
        } else {
            urlParams.delete('city');
        }

        // Build the new URL
        const newUrl = currentPath + '?' + urlParams.toString();
        console.log("Redirecting to:", newUrl);

        // Navigate to the new URL
        window.location.href = newUrl;
    });

    $(document).ready(function() {
        // City filter apply button click handler
        // Replace your current city filter apply button handler with this

        // Set the dropdown to the currently selected city from URL if any
        const urlParams = new URLSearchParams(window.location.search);
        const cityParam = urlParams.get('city');


        $('#countryFilter').on('change', function() {
            console.log(124);

            var countryId = $(this).val();
            var citySelect = $('#cityFilter');

            citySelect.empty().append('<option value="">{{ __('Select City') }}</option>');

            if (countryId) {
                $.ajax({
                    url: '/api/cities',
                    type: 'GET',
                    data: {
                        country_id: countryId
                    },
                    success: function(data) {
                        $.each(data.data, function(key, city) {


                            citySelect.append(
                                $('<option>', {
                                    value: city.id,
                                    text: city.name + (city.name_ar ?
                                        ` (${city.name_ar})` : '')
                                })
                            );
                        });
                    },
                    error: function() {
                        alert('Failed to load cities.');
                    }
                });
            }
        });

        if (cityParam) {
            $('#cityFilter').val(cityParam);
        }

        // Date filter apply button click handler
        $('#applyDateFilter').on('click', function() {
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();

            const currentUrl = new URL(window.location.href);

            // Clear existing date parameters
            currentUrl.searchParams.delete('start_date');
            currentUrl.searchParams.delete('end_date');

            // Add new date parameters if they exist
            if (startDate) {
                currentUrl.searchParams.set('start_date', startDate);
            }

            if (endDate) {
                currentUrl.searchParams.set('end_date', endDate);
            }

            window.location.href = currentUrl.toString();
        });

        // Set the date inputs to the currently selected dates from URL if any
        const startDateParam = urlParams.get('start_date');
        const endDateParam = urlParams.get('end_date');

        if (startDateParam) {
            $('#startDate').val(startDateParam);
        }

        if (endDateParam) {
            $('#endDate').val(endDateParam);
        }

        // Status filter apply button click handler
        $('#applyStatusFilter').on('click', function() {
            const status = $('input[name="status"]:checked').val();

            const currentUrl = new URL(window.location.href);

            // Clear existing status parameter
            currentUrl.searchParams.delete('status');

            // Add new status parameter if it's not 'all'
            if (status && status !== 'all') {
                currentUrl.searchParams.set('status', status);
            }

            window.location.href = currentUrl.toString();
        });

        // Set the status radio button to the currently selected status from URL if any
        const statusParam = urlParams.get('status');
        if (statusParam) {
            $(`#status${statusParam.charAt(0).toUpperCase() + statusParam.slice(1)}`).prop('checked', true);
        } else {
            $('#statusAll').prop('checked', true);
        }

        // Company filter apply button click handler (for admin only)
        $('#applyCompanyFilter').on('click', function() {
            const selectedCompanies = $('.company-filter:checked').map(function() {
                return $(this).val();
            }).get();

            const currentUrl = new URL(window.location.href);

            // Clear existing companies parameters
            currentUrl.searchParams.delete('companies[]');

            // Add new companies parameters if they exist
            if (selectedCompanies.length > 0) {
                selectedCompanies.forEach(companyId => {
                    currentUrl.searchParams.append('companies[]', companyId);
                });
            }

            window.location.href = currentUrl.toString();
        });

        // Set the company checkboxes to the currently selected companies from URL if any
        const companyParams = urlParams.getAll('companies[]');
        if (companyParams.length > 0) {
            companyParams.forEach(companyId => {
                $(`#company${companyId}`).prop('checked', true);
            });
        }

        // Sort dropdown click handler
        $('.dropdown-item[data-sort]').on('click', function(e) {
            e.preventDefault();

            const sortValue = $(this).data('sort');

            const currentUrl = new URL(window.location.href);

            // Clear existing sort parameter
            currentUrl.searchParams.delete('sort');

            // Add new sort parameter
            currentUrl.searchParams.set('sort', sortValue);

            window.location.href = currentUrl.toString();
        });

        // Set the active sort item based on URL parameter
        const sortParam = urlParams.get('sort') || 'date-desc';
        $(`.dropdown-item[data-sort="${sortParam}"]`).addClass('active');

        // Search button click handler
        $('#searchButton').on('click', function() {
            const searchTerm = $('#searchInput').val();

            const currentUrl = new URL(window.location.href);

            // Clear existing search parameter
            currentUrl.searchParams.delete('search');

            // Add new search parameter if it exists
            if (searchTerm) {
                currentUrl.searchParams.set('search', searchTerm);
            }

            window.location.href = currentUrl.toString();
        });

        // Search on Enter key press
        $('#searchInput').on('keyup', function(e) {
            if (e.key === 'Enter') {
                $('#searchButton').click();
            }
        });

        // Set the search input to the currently selected search term from URL if any
        const searchParam = urlParams.get('search');
        if (searchParam) {
            $('#searchInput').val(searchParam);
        }

        // Export buttons click handlers
        $('#exportExcel').click(function(e) {
            e.preventDefault();
            window.location.href = '/export/excel?' + getFilterParameters();
        });

        $('#exportPdf').click(function(e) {
            e.preventDefault();
            window.location.href = '/export/pdf?' + getFilterParameters();
        });

        // Helper function to get current filter parameters
        window.getFilterParameters = function() {
            const params = new URLSearchParams();

            // Add search parameter if it exists
            const searchTerm = $('#searchInput').val();
            if (searchTerm) {
                params.set('search', searchTerm);
            }

            // Add date parameters if they exist
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();

            if (startDate) {
                params.set('start_date', startDate);
            }

            if (endDate) {
                params.set('end_date', endDate);
            }

            // Add status parameter if it's not 'all'
            const status = $('input[name="status"]:checked').val();
            if (status && status !== 'all') {
                params.set('status', status);
            }

            // Add company parameters if they exist
            const selectedCompanies = $('.company-filter:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedCompanies.length > 0) {
                selectedCompanies.forEach(companyId => {
                    params.append('companies[]', companyId);
                });
            }

            // Add city parameter if it exists
            const selectedCity = $('#cityFilter').val();
            if (selectedCity) {
                params.set('city', selectedCity);
            }

            // Add sort parameter
            const sortValue = $('.dropdown-item.active').data('sort') || 'date-desc';
            params.set('sort', sortValue);

            return params.toString();
        };
    });
</script>
