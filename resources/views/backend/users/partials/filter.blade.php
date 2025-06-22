{{-- resources/views/backend/users/partials/filters.blade.php --}}
    <div class="card-body p-4">
        <form id="filterForm" action="{{ route('AdminUsers.index') }}" method="GET">
            <div class="row g-3 align-items-center">
                <!-- Search Box -->
                <div class="col-lg-4">
                    <div class="position-relative">
                        <input type="text" 
                               class="search-box ps-5" 
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="{{ __('Search users...') }}">
                    </div>
                </div>

                <!-- Role Filter -->
                <div class="col-lg-2">
                    <select class="form-select form-select-solid" 
            name="role" 
            data-control="select2" 
            data-placeholder="{{ __('Select Role') }}"> 
        <option value="">{{ __('All Roles') }}</option>
        @foreach($roles as $role) 
            <option value="{{ $role->id }}" 
                    {{ request('role') == $role->id ? 'selected' : '' }}>
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
                             
                            </ul>
                        </div>

                        <!-- Bulk Actions -->
                        <div class="dropdown">
                      
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
                        <a href="{{ route('AdminUsers.create') }}" style="padding-top:17px;">
                            <i class="fas fa-plus me-2"></i>{{ __('Add User') }}
                        </a>
                    </div>
                </div>
            </div>
        </form>

       {{-- Modal Trigger + Sample Excel Download --}}
<div class="d-flex gap-2 align-items-center mt-3">
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importUsersModal">
        <i class="fas fa-file-import me-2"></i>{{ __('Import Users') }}
    </button>

  
</div>
<!-- Import Users Modal -->
<div class="modal fade" id="importUsersModal" tabindex="-1" aria-labelledby="importUsersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Changed to modal-lg for more width -->
      <form action="{{ route('AdminUsers.import') }}" method="POST" enctype="multipart/form-data" class="modal-content">
          @csrf
          <div class="modal-header">
              <h5 class="modal-title" id="importUsersModalLabel">{{ __('Import Users from Excel') }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
          </div>
          <div class="modal-body">
             <!-- Excel File Upload -->
              <div class="form-group mb-3">
                  <label for="excel_file">{{ __('Choose Excel File (.xlsx, .xls)') }}</label>
                  <input type="file" name="excel_file" class="form-control" required>
                  <div class="mt-2">
                      <a href="{{asset('assets/excel.xlsx')}}" class="btn btn-outline-secondary">
                          <i class="fas fa-download me-2"></i>{{ __('Download Sample') }}
                      </a>
                  </div>
              </div>
              
              <!-- Image Preview with centered container -->
              <div class="text-center mt-3 mb-3">
                  <img src="{{asset('assets/Capture.PNG')}}" alt="{{ __('Image Preview') }}" class="img-fluid" style="max-width: 100%;">
              </div>
              
              <div class="alert alert-info">
                  {{ __('Please make sure your Excel file matches the sample format.') }}
              </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary">
                  <i class="fas fa-upload me-2"></i>{{ __('Import') }}
              </button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  {{ __('Cancel') }}
              </button>
          </div>
      </form>
    </div>
  </div>

</div>
