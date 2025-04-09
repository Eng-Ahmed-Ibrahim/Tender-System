@extends('admin.index')
@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <div class="company-avatar me-3">
                        @if($company->logo)
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" class="rounded-3" style="width: 64px; height: 64px; object-fit: cover;">
                        @else
                            <div class="placeholder-avatar rounded-3 bg-light d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                                <i class="fas fa-building fa-2x text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h1 class="h3 mb-1 fw-bold text-gray-800">{{ $company->name }}</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">{{__('Companies')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__('Company Details')}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-light">
                    <i class="fas fa-edit me-2"></i>{{__('Edit')}}
                </a>
                <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="mx-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center action-btn" onclick="return confirm('Are you sure you want to delete this company?')">
                        <i class="fas fa-trash me-2"></i>{{__('Delete')}}
                    </button> 
                </form>
                  
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-xl-4 col-lg-5">
            <!-- Company Info Card --> 
            <div class="card shadow-sm rounded-3 border-0 mb-4">
                <div class="card-body">
                    <div class="company-info">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h4 class="card-title mb-0 fw-bold">{{__('Company Details')}}</h4>
                            <span class="badge bg-{{ $company->status === 'active' ? 'success' : 'danger' }} rounded-pill px-3 py-2">
                                {{ __($company->status ? ucfirst($company->status) : 'Unknown') }}
                            </span>
                            
                        </div>
                        
                        <div class="info-list">
                            <div class="info-item mb-3 p-3 bg-light rounded-3">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="info-icon bg-primary bg-opacity-10 rounded-circle p-2">
                                            <i class="fas fa-envelope text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label class="text-muted small mb-0">{{__('Email')}}</label>
                                        <p class="mb-0 fw-medium">{{ $company->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="info-item mb-3 p-3 bg-light rounded-3">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="info-icon bg-success bg-opacity-10 rounded-circle p-2">
                                            <i class="fas fa-phone text-success"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label class="text-muted small mb-0">{{__('Phone')}}</label>
                                        <p class="mb-0 fw-medium">{{ $company->phone ?? 'Not specified' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="info-item mb-3 p-3 bg-light rounded-3">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="info-icon bg-info bg-opacity-10 rounded-circle p-2">
                                            <i class="fas fa-map-marker-alt text-info"></i>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <label class="text-muted small mb-0">{{__('Address')}}</label>
                                        <p class="mb-0 fw-medium">{{ $company->address ?? 'Not specified' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        
                        <!-- Statistics Section -->
                        <div class="statistics mt-4">
                            <h5 class="fw-bold mb-3">{{__('Statistics')}}</h5>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="stat-card bg-primary bg-opacity-10 p-3 rounded-3">
                                        <div class="stat-icon text-primary mb-2">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="stat-value fw-bold text-primary h4 mb-0">
                                            {{ $statistics['total_users'] }}
                                        </div>
                                        <div class="stat-label text-muted small">{{__('Total Users')}}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card bg-success bg-opacity-10 p-3 rounded-3">
                                        <div class="stat-icon text-success mb-2">
                                            <i class="fas fa-user-check"></i>
                                        </div>
                                        <div class="stat-value fw-bold text-success h4 mb-0">
                                            {{ $statistics['active_users'] }}
                                        </div>
                                        <div class="stat-label text-muted small">{{__('Active Users')}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
       <!-- Statistics Section -->
       <div class="statistics mt-4">
        <h5 class="fw-bold mb-3">{{__('Commercial photo')}}</h5>
        <div class="row g-3">
            <div class="col-12">
                <div class="stat-card bg-success bg-opacity-10 p-3 rounded-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-icon text-success mb-2">
                                <i class="fas fa-image"></i>
                            </div>
                            <div class="stat-label text-muted small">{{__('Commercial Photo')}}</div>
                        </div>
                        
                        @if($company->commercial_photo)
                            <a href="{{ asset('storage/' . $company->commercial_photo) }}" 
                               download="commercial_photo_{{ $company->id }}" 
                               class="btn btn-sm btn-outline-success">
                                <i class="fas fa-download me-1"></i> {{__('Download')}}
                            </a>
                        @endif
                    </div>
                    
                    <div class="mt-3 text-center">
                        @if($company->commercial_photo)
                            <img src="{{ asset('storage/' . $company->commercial_photo) }}" 
                                 alt="Commercial Photo" 
                                 class="img-fluid rounded-3" 
                                 style="max-height: 250px; max-width: 100%;">
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{__('No commercial photo available')}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>          
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm rounded-3 border-0">
                <div class="card-header bg-white border-bottom-0 p-4">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#users" role="tab">
                                <i class="fas fa-users me-2"></i>{{__('Users')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tenders" role="tab">
                                <i class="fas fa-file-contract me-2"></i>{{__('Tenders')}}
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4">
                    <div class="tab-content">
                        <!-- Users Tab -->
                        <div class="tab-pane fade show active" id="users" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title mb-0 fw-bold">{{__('Company Users')}}</h5>
                                {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <i class="fas fa-plus me-2"></i>{{__('Add User')}}
                                </button> --}}
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover" id="usersTable">
                                    <thead>
                                        <tr>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Email')}}</th>
                                            <th>{{__('Phone')}}</th>
                                            <th>{{__('Status')}}</th>
                                            <th>{{__('Joined Date')}}</th>
                                            <th>{{__('Actions')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($company->users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="user-avatar me-2">
                                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 text-primary" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ $user->name }}</div>
                                                        <small class="text-muted">{{ $user->role }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $user->is_active === 1 ? 'success' : 'danger' }} rounded-pill">
                                                    {{ $user->is_active === 1 ? 'active' : 'inactive' }}
                                                </span>
                                            </td>
                                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        {{-- <li>
                                                            <a class="dropdown-item" href="#" onclick="editUser({{ $user->id }}); return false;">
                                                                <i class="fas fa-edit me-2"></i> {{ __('Edit') }}
                                                            </a>
                                                        </li> --}}
                                                        <li>
                                                            <form action="{{ route('users.toggle-status', $user->id) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="dropdown-item {{ $user->is_active ? 'text-warning' : 'text-success' }}">
                                                                    <i class="fa fa-{{ $user->is_active ? 'ban' : 'check' }} me-2"></i>
                                                                    {{ $user->is_active ? __('Deactivate') : __('Activate') }}
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('AdminUsers.destroy', $user->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger" 
                                                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                                                    <i class="fa fa-trash me-2"></i> {{ __('Delete') }}
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tenders Tab -->
                        <div class="tab-pane fade" id="tenders" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title mb-0 fw-bold">{{__('Company Tenders')}}</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTenderModal">
                                    <i class="fas fa-plus me-2"></i>{{__('Add Tender')}}
                                </button>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover" id="tendersTable">
                                    <thead>
                                        <tr>
                                            <th>{{__('Tender ID')}}</th>
                                            <th>{{__('Title')}}</th>
                                            <th>{{__('inurance')}}</th>
                                            <th>{{__('Due Date')}}</th>
                                            <th>{{__('Actions')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tenders as $tender)

                                        <tr>
                                        <td>{{$tender->id}}</td>
                                        <td>{{$tender->title}}</td>
                                        <td>{{$tender->first_insurance}}</td>
                                        <td>{{$tender->end_date}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a  href="{{route('tenders.edit',$tender->id)}}" type="button" class="btn btn-sm btn-light"">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            
                                            </div>
                                        </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add these modals at the bottom of your view file -->

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">{{__('Add New User')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addUserForm">

                <meta name="csrf-token" content="{{ csrf_token() }}">
                <input type="hidden" name="company_id" value="{{ $company->id }}">
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{__('Name')}}<span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{__('Email')}}<span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{__('Phone')}}</label>
                            <input type="tel" name="phone" class="form-control"   minlength="11"
                            maxlength="11">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{__('Role')}}<span class="text-danger">*</span></label>
                            <select name="role" class="form-select" required>
                                <option value="company">{{__('User')}}</option>
                                <option value="admin_company">{{__('Admin')}}</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{__('Password')}}<span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{__('Confirm Password')}}<span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">{{__('Add User')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">{{__('Edit User')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUserForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" id="edit_user_id">
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{__('Name')}}<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{__('Email')}}<span class="text-danger">*</span></label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div> 
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{__('Phone')}}</label>
                            <input type="tel" name="phone" id="edit_phone" class="form-control"   minlength="11"
                            maxlength="11">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{__('Role')}}<span class="text-danger">*</span></label>
                            <select name="role" class="form-select" required>
                                <option value="company">{{__('User')}}</option>
                                <option value="admin_company">{{__('Admin')}}</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="change_password">
                                <label class="form-check-label">{{__('Change Password')}}</label>
                            </div>
                        </div>
                        <div class="col-md-6 password-fields d-none">
                            <label class="form-label fw-bold">{{__('New Password')}}</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-6 password-fields d-none">
                            <label class="form-label fw-bold">{{__('Confirm New Password')}}</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Update User')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Tender Modal -->
<div class="modal fade" id="addTenderModal" tabindex="-1" aria-labelledby="addTenderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header  text-white">
                <h5 class="modal-title" id="addTenderModalLabel">{{__('Add New Tender')}}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addTenderForm" class="p-3">
                @csrf
                <input type="hidden" name="company_id" value="{{ $company->id }}">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">{{__('Title')}}</label>
                        <input type="text" name="title" class="form-control" required>
                    </div> 

                    <div class="col-md-6">
                        <label for="title" class="form-label">{{__('Title')}}(Arabic)</label>
                        <input type="text" name="title_ar" class="form-control" required>
                    </div>
 
                    <div class="col-md-6">
                        <label for="first_insurance" class="form-label">{{__('First Insurance')}}</label>
                        <input type="number" name="first_insurance" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="price" class="form-label">{{__('Price')}}</label>
                        <input type="number" name="price" class="form-control" required>
                    </div> 

                    <div class="col-md-6">
                        <label for="city" class="form-label">{{__('City')}}</label>
                        <input type="text" name="city" class="form-control" required>
                    </div> 
                </div> 

                <div class="mb-3">
                    <label for="description" class="form-label">{{__('Description')}}</label>
                    <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">{{__('Description')}}(Arabic)</label>
                    <textarea name="description_ar" class="form-control" rows="3" required></textarea>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">{{__('End Date')}}</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="edit_end_date" class="form-label">{{__('Deadline to Update')}}</label>
                        <input type="date" name="edit_end_date" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="show_applicants" class="form-label">{{__('Show Applicants')}}</label>
                    <select name="show_applicants" id="show_applicants" class="form-select">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Cancel')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('Add Tender')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Add User Form Submission
    $('#addUserForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Adding...');
        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
        $.ajax({
            url: '{{ route("CompanyUsers.store") }}',
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#addUserModal').modal('hide');
                Swal.fire({
    icon: 'success',
    title: '{{ __("Success!") }}',
    text: '{{ __("User added successfully") }}',
    showConfirmButton: false,
    timer: 1500
}).then(() => {
    location.reload();
});

            },
            error: function(xhr) {
                handleFormErrors(form, xhr);
                submitBtn.prop('disabled', false).text('Add User');
            }
        });
    });

    // Edit User
    function editUser(userId) {
    // Fetch user data via AJAX
    $.ajax({
        url: `/users/${userId}`,  // Adjust this URL to match your API endpoint
        type: 'GET',
        success: function(response) {
            // Populate the form fields with existing data
            $('#edit_user_id').val(response.id);
            $('#edit_name').val(response.name);
            $('#edit_email').val(response.email);
            $('#edit_phone').val(response.phone);
            $('#edit_role').val(response.role);
            
            // Reset password fields
            $('#change_password').prop('checked', false);
            $('.password-fields').addClass('d-none');
            
            // Show the modal
            $('#editUserModal').modal('show');
        },
        error: function(xhr) {
            // Handle error
            alert('Error fetching user data. Please try again.');
            console.error(xhr);
        }
    });
}

// Toggle password fields visibility when checkbox is clicked
$(document).ready(function() {
    $('#change_password').change(function() {
        if($(this).is(':checked')) {
            $('.password-fields').removeClass('d-none');
        } else {
            $('.password-fields').addClass('d-none');
        }
    });
});

    // Update User Form Submission
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const userId = $('#edit_user_id').val();
        const submitBtn = form.find('button[type="submit"]');
        
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Updating...');
        
        $.ajax({
            url: `/CompanyUsers/${userId}`,
            type: 'PUT', 
            data: form.serialize(),
            success: function(response) {
                $('#editUserModal').modal('hide');
                Swal.fire({
                    icon: 'success', 
                    title: '{{ __("Success!") }}',
                    text: '{{ __("User updated successfully") }}',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                handleFormErrors(form, xhr);
                submitBtn.prop('disabled', false).text('Update User');
            }
        });
    });

    // Add Tender Form Submission
    $('#addTenderForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Adding...');
        
        $.ajax({
            url: '{{ route("tenders.store") }}',
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#addTenderModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: '{{ __("Success!") }}',
                    text: '{{ __("Tender added successfully") }}',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                handleFormErrors(form, xhr);
                submitBtn.prop('disabled', false).text('Add Tender');
            }
        });
    });

    // Handle Password Change Toggle
    $('#change_password').on('change', function() {
        $('.password-fields').toggleClass('d-none', !this.checked);
        const passwordInputs = $('.password-fields input');
        passwordInputs.prop('required', this.checked);
    });

    // Error Handling Function
    function handleFormErrors(form, xhr) {
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();
        
        if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;
            Object.keys(errors).forEach(field => {
                const input = form.find(`[name="${field}"]`);
                input.addClass('is-invalid')
                    .after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
            });
            
            // Scroll to first error
            const firstError = form.find('.is-invalid').first();
            if (firstError.length) {
                firstError[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
        
        Swal.fire({
            icon: 'error',
            title: '{{ __("Error!") }}',
            text: '{{ __("Please check the form and try again") }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    }
});



// Keep the password toggle code inside document ready
$(document).ready(function() {
    $('#change_password').change(function() {
        if($(this).is(':checked')) {
            $('.password-fields').removeClass('d-none');
        } else {
            $('.password-fields').addClass('d-none');
        }
    });
});
</script>
<style>
.info-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.nav-tabs .nav-link {
    color: #6c757d;
    border: none;
    padding: 1rem 1.5rem;
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    border-bottom: 2px solid #0d6efd;
    background: transparent;
}

.table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
}

.stat-card {
    transition: transform 0.2s;
}

.stat-card:hover {
    transform: translateY(-3px);
}

.info-item {
    transition: transform 0.2s;
}

.info-item:hover {
    transform: translateX(5px);
}

.badge {
    font-weight: 500;
}

.btn-light {
    background-color: #f8f9fa;
    border-color: #f0f0f0;
}

.btn-light:hover {
    background-color: #e9ecef;
}
</style>

<script>
// Initialize DataTables


function editUser(userId) {
    $.ajax({
        url: `/AdminUsers/${userId}/edit_user`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response && response.user) {
                const user = response.user;
                // Populate form fields
                $('#edit_user_id').val(user.id);
                $('#edit_name').val(user.name);
                $('#edit_email').val(user.email);
                $('#edit_phone').val(user.phone || '');
                $('select[name="role"]').val(user.role);
                
                // Reset password fields
                $('#change_password').prop('checked', false);
                $('.password-fields').addClass('d-none');
                $('.password-fields input').prop('required', false);
                
                $('#editUserModal').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'User data not found in response',
                });
            }
        },
        error: function(xhr) {
            console.error('Error response:', xhr);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to fetch user data. Please try again.',
            });
        }
    });
}

// Update the edit form submission handler
$(document).ready(function() {
    // Your existing document ready code...
    
    // Update User Form Submission
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const userId = $('#edit_user_id').val();
        const submitBtn = form.find('button[type="submit"]');
        
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Updating...');
        
        const formData = new FormData(this);
        formData.append('_method', 'PUT'); // For Laravel method spoofing
        
        $.ajax({ 
            url: `/CompanyUsers/${userId}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#editUserModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'User updated successfully',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                console.error('Update error:', xhr); 
                handleFormErrors(form, xhr);
                submitBtn.prop('disabled', false).text('Update User');
            }
        });
    }); 
    
    // Existing password toggle code
    $('#change_password').change(function() {
        if($(this).is(':checked')) {
            $('.password-fields').removeClass('d-none');
            $('.password-fields input').prop('required', true);
        } else {
            $('.password-fields').addClass('d-none');
            $('.password-fields input').prop('required', false);
        }
    });
});



// Your existing delete functions here...
</script>

@endsection