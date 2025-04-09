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
                           placeholder="{{__('Search tenders by title, description...')}}">
                    <button class="btn btn-primary px-4" type="button" id="searchButton">
                        {{__('Search')}}
                    </button>
                </div>
            </div>

            <!-- Filters Dropdown -->
            <div class="col-12">
                <div class="dropdown d-inline-block me-2">
                    <button class="btn btn-light dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-calendar-alt me-2"></i>{{__('Date Range')}}
                    </button>
                    <div class="dropdown-menu p-3" style="min-width: 300px;">
                        <div class="mb-3">
                            <label class="form-label">{{__('Start Date')}}</label>
                            <input type="date" class="form-control" id="startDate">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{__('End Date')}}</label>
                            <input type="date" class="form-control" id="endDate">
                        </div>
                        <button class="btn btn-primary w-100" id="applyDateFilter">{{__('Apply')}}</button>
                    </div>
                </div>

                @if(auth()->user()->role === 'admin')
                <div class="dropdown d-inline-block me-2">
                    <button class="btn btn-light dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-building me-2"></i>{{__('Company')}}
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
                        <button class="btn btn-primary w-100" id="applyCompanyFilter">{{__('Apply')}}</button>
                    </div>
                </div>
                @endif

                <div class="dropdown d-inline-block me-2">
                    <button class="btn btn-light dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-2"></i>{{__('Status')}}
                    </button>
                    <div class="dropdown-menu p-3" style="min-width: 200px;">
                        <div class="form-check mb-2">
                            <input class="form-check-input status-filter" type="radio" name="status" 
                                   value="all" id="statusAll" checked>
                            <label class="form-check-label" for="statusAll">{{__('All')}}</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input status-filter" type="radio" name="status" 
                                   value="open" id="statusOpen">
                            <label class="form-check-label" for="statusOpen">{{__('Open')}}</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input status-filter" type="radio" name="status" 
                                   value="closed" id="statusClosed">
                            <label class="form-check-label" for="statusClosed">{{__('Closed')}}</label>
                        </div>
                        <button class="btn btn-primary w-100 mt-2" id="applyStatusFilter">{{__('Apply')}}</button>
                    </div>
                </div>

                <div class="dropdown d-inline-block me-2">
                    <button class="btn btn-light dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-sort me-2"></i>{{__('Sort By')}}
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" data-sort="date-desc">
                            <i class="fas fa-sort-amount-down me-2"></i>{{__('Latest First')}}
                        </a>
                        <a class="dropdown-item" href="#" data-sort="date-asc">
                            <i class="fas fa-sort-amount-up me-2"></i>{{__('Oldest First')}}
                        </a>
                        <a class="dropdown-item" href="#" data-sort="title-asc">
                            <i class="fas fa-sort-alpha-down me-2"></i>{{__('Title A-Z')}}
                        </a>
                        <a class="dropdown-item" href="#" data-sort="title-desc">
                            <i class="fas fa-sort-alpha-up me-2"></i>{{__('Title Z-A')}}
                        </a>
                    </div>
                </div>

                <!-- New Export Dropdown -->
                <div class="dropdown d-inline-block me-2">
                    <button class="btn btn-light dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-download me-2"></i>{{__('Export')}}
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('tenders.export', 'excel') }}" id="exportExcel">
                            <i class="fas fa-file-excel me-2 text-success"></i>{{__('Export to Excel')}}
                        </a>
                        <a class="dropdown-item" href="{{ route('tenders.export', 'pdf') }}" id="exportPdf">
                            <i class="fas fa-file-pdf me-2 text-danger"></i>{{__('Export to PDF')}}
                        </a>
                    </div>
                </div>
                <a class="btn btn-primary float-end" href="{{ route('tenders.create') }}">
                    <i class="fas fa-plus me-2"></i>{{__('Create Tender')}}
                </a>
            </div>
        </div>
    </div>
</div>
<script>

$('#exportExcel').click(function(e) {
    e.preventDefault();
    window.location.href = '/export/excel?' + getFilterParameters();
});

$('#exportPdf').click(function(e) {
    e.preventDefault();

    window.location.href = '/export/pdf?' + getFilterParameters();
});

// Helper function to get current filter parameters
function getFilterParameters() {
    return $.param({
        search: $('#searchInput').val(),
        startDate: $('#startDate').val(),
        endDate: $('#endDate').val(),
        status: $('input[name="status"]:checked').val(),
        companies: $('.company-filter:checked').map(function() {
            return $(this).val();
        }).get(),
        sort: $('.dropdown-item.active').data('sort')
    });
}
    </script>
