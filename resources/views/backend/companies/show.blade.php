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
                                <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Companies</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Company Details</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-light">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                <button type="button" class="btn btn-danger" onclick="deleteCompany({{ $company->id }})">
                    <i class="fas fa-trash me-2"></i>Delete
                </button>
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
                            <h4 class="card-title mb-0 fw-bold">Company Details</h4>
                            <span class="badge bg-{{ $company->status === 'active' ? 'success' : 'danger' }} rounded-pill px-3 py-2">
                                {{ ucfirst($company->status ?? 'Unknown') }}
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
                                        <label class="text-muted small mb-0">Email</label>
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
                                        <label class="text-muted small mb-0">Phone</label>
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
                                        <label class="text-muted small mb-0">Address</label>
                                        <p class="mb-0 fw-medium">{{ $company->address ?? 'Not specified' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Statistics Section -->
                        <div class="statistics mt-4">
                            <h5 class="fw-bold mb-3">Statistics</h5>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="stat-card bg-primary bg-opacity-10 p-3 rounded-3">
                                        <div class="stat-icon text-primary mb-2">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="stat-value fw-bold text-primary h4 mb-0">
                                            {{ $statistics['total_users'] }}
                                        </div>
                                        <div class="stat-label text-muted small">Total Users</div>
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
                                        <div class="stat-label text-muted small">Active Users</div>
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
                                <i class="fas fa-users me-2"></i>Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tenders" role="tab">
                                <i class="fas fa-file-contract me-2"></i>Tenders
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4">
                    <div class="tab-content">
                        <!-- Users Tab -->
                        <div class="tab-pane fade show active" id="users" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title mb-0 fw-bold">Company Users</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <i class="fas fa-plus me-2"></i>Add User
                                </button>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover" id="usersTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Joined Date</th>
                                            <th>Actions</th>
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
                                                <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }} rounded-pill">
                                                    {{ ucfirst($user->status ?? 'Unknown') }}
                                                </span>
                                            </td>
                                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-light" onclick="editUser({{ $user->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-light text-danger" onclick="deleteUser({{ $user->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
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
                                <h5 class="card-title mb-0 fw-bold">Company Tenders</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTenderModal">
                                    <i class="fas fa-plus me-2"></i>Add Tender
                                </button>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover" id="tendersTable">
                                    <thead>
                                        <tr>
                                            <th>Tender ID</th>
                                            <th>Title</th>
                                            <th>inurance</th>
                                            <th>Due Date</th>
                                            <th>Actions</th>
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
                                                <a type="button" class="btn btn-sm btn-light text-danger" onclick="deleteUser({{ $tender->id }})">
                                                    <i class="fas fa-trash"></i>
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
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addUserForm">

                <meta name="csrf-token" content="{{ csrf_token() }}">
                <input type="hidden" name="company_id" value="{{ $company->id }}">
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Name<span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email<span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Phone</label>
                            <input type="tel" name="phone" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Role<span class="text-danger">*</span></label>
                            <select name="role" class="form-select" required>
                                <option value="user_company">User</option>
                                <option value="admin_company">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Password<span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Confirm Password<span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
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
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUserForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" id="edit_user_id">
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Name<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email<span class="text-danger">*</span></label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Phone</label>
                            <input type="tel" name="phone" id="edit_phone" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Role<span class="text-danger">*</span></label>
                            <select name="role" id="edit_role" class="form-select" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="change_password">
                                <label class="form-check-label">Change Password</label>
                            </div>
                        </div>
                        <div class="col-md-6 password-fields d-none">
                            <label class="form-label fw-bold">New Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-6 password-fields d-none">
                            <label class="form-label fw-bold">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
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
                <h5 class="modal-title" id="addTenderModalLabel">Add New Tender</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addTenderForm" class="p-3">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="first_insurance" class="form-label">First Insurance</label>
                        <input type="text" name="first_insurance" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="city" class="form-label">City</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="edit_end_date" class="form-label">Deadline to Update</label>
                        <input type="date" name="edit_end_date" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="show_applicants" class="form-label">Show Applicants</label>
                    <select name="show_applicants" id="show_applicants" class="form-select">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Tender</button>
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
                    title: 'Success!',
                    text: 'User added successfully',
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
        $.get(`/users/${userId}/edit`, function(data) {
            $('#edit_user_id').val(data.id);
            $('#edit_name').val(data.name);
            $('#edit_email').val(data.email);
            $('#edit_phone').val(data.phone);
            $('#edit_role').val(data.role);
            $('#editUserModal').modal('show');
        });
    }

    // Update User Form Submission
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const userId = $('#edit_user_id').val();
        const submitBtn = form.find('button[type="submit"]');
        
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Updating...');
        
        $.ajax({
            url: `/users/${userId}`,
            type: 'PUT',
            data: form.serialize(),
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
                    title: 'Success!',
                    text: 'Tender added successfully',
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
            title: 'Error',
            text: 'Please check the form and try again',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    }
});

// Global function for editing user
window.editUser = function(userId) {
    $.get(`/AdminUsers/${userId}/edit`, function(data) {
        $('#edit_user_id').val(data.id);
        $('#edit_name').val(data.name);
        $('#edit_email').val(data.email);
        $('#edit_phone').val(data.phone);
        $('#edit_role').val(data.role);
        $('#editUserModal').modal('show');
    });
}
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
$(document).ready(function() {
    $('#usersTable').DataTable({
        responsive: true,
        order: [[4, 'desc']],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search users..."
        },
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    });

    $('#tendersTable').DataTable({
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search tenders..."
        }
    });

    // Enable Bootstrap tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Add hover effect to table rows
    $('.table tbody tr').hover(
        function() {
            $(this).addClass('bg-light');
        },
        function() {
            $(this).removeClass('bg-light');
        }
    );
});

// Your existing delete functions here...
</script>

@endsection