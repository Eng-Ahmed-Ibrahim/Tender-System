{{-- resources/views/backend/users/partials/filters.blade.php --}}
    <div class="card-body p-4">
        <form id="filterForm" action="{{ route('AdminUsers.index') }}" method="GET">
            <div class="row g-3 align-items-center">
                <!-- Search Box -->
                <div class="col-lg-4">
                    <div class="position-relative">
                        <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" 
                               class="search-box ps-5" 
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="{{ __('Search users...') }}">
                    </div>
                </div>

                <!-- Role Filter -->
                <div class="col-lg-2">
                    <select class="form-select" name="role">
                        <option value="">{{ __('All Roles') }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                                {{ $role->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range -->
                <div class="col-lg-4">
                    <div class="d-flex gap-2">
                        <input type="date" 
                               class="form-control" 
                               name="date_from"
                               value="{{ request('date_from') }}"
                               placeholder="{{ __('From Date') }}">
                        <input type="date" 
                               class="form-control" 
                               name="date_to"
                               value="{{ request('date_to') }}"
                               placeholder="{{ __('To Date') }}">
                    </div>
                </div>

                <!-- Sort -->
                <div class="col-lg-2">
                    <select class="form-select" name="sort">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                            {{ __('Newest First') }}
                        </option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                            {{ __('Oldest First') }}
                        </option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                            {{ __('Name A-Z') }}
                        </option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                            {{ __('Name Z-A') }}
                        </option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-2"></i>{{ __('Apply Filters') }}
                        </button>
                        <a href="{{ route('AdminUsers.index') }}" class="btn btn-light ms-2">
                            <i class="fas fa-redo me-2"></i>{{ __('Reset') }}
                        </a>
                    </div>

                    <div class="d-flex gap-2">
                        <!-- Export Buttons -->
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-download me-2"></i>{{ __('Export') }}
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('users.export', ['format' => 'excel']) }}">
                                        <i class="fas fa-file-excel me-2"></i>Excel
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('users.export', ['format' => 'pdf']) }}">
                                        <i class="fas fa-file-pdf me-2"></i>PDF
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('users.export', ['format' => 'csv']) }}">
                                        <i class="fas fa-file-csv me-2"></i>CSV
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Bulk Actions -->
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-cog me-2"></i>{{ __('Bulk Actions') }}
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="bulkAction('activate')">
                                        <i class="fas fa-check-circle me-2"></i>{{ __('Activate Selected') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="bulkAction('deactivate')">
                                        <i class="fas fa-times-circle me-2"></i>{{ __('Deactivate Selected') }}
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="bulkAction('delete')">
                                        <i class="fas fa-trash-alt me-2"></i>{{ __('Delete Selected') }}
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Add User Button -->
                        <a href="{{ route('AdminUsers.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>{{ __('Add User') }}
                        </a>
                    </div>
                </div>
            </div>
        </form>
</div>
