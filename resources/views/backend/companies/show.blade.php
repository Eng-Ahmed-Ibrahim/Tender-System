@extends('admin.index')
@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">{{ $company->name }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Companies</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Company Details</li>
                </ol>
            </nav>
        </div>
          
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Company Information Card -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Company Information</h6>
                </div>
                <div class="card-body">
                    <div class="company-info">
                        <div class="text-center mb-4">
                            <i class="fas fa-building fa-4x text-gray-300 mb-3"></i>
                            <h4 class="font-weight-bold">{{ $company->name }}</h4>
                            <span class="badge badge-{{ $company->status === 'active' ? 'success' : 'danger' }} px-3 py-2">
                                {{ ucfirst($company->status ?? 'Unknown') }}
                            </span>
                        </div>
                        
                        <div class="info-group mb-3">
                            <label class="text-muted mb-1">Company ID</label>
                            <p class="font-weight-bold mb-0">{{ $company->id }}</p>
                        </div>

                        <div class="info-group mb-3">
                            <label class="text-muted mb-1">Address</label>
                            <p class="font-weight-bold mb-0">{{ $company->address ?? 'Not specified' }}</p>
                        </div>

                        <div class="info-group mb-3">
                            <label class="text-muted mb-1">Created Date</label>
                            <p class="font-weight-bold mb-0">{{ $statistics['created_date'] }}</p>
                        </div>

                        <div class="info-group mb-3">
                            <label class="text-muted mb-1">Last Updated</label>
                            <p class="font-weight-bold mb-0">{{ $statistics['last_updated'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="font-weight-bold text-primary mb-1">Total Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['total_users'] }}</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="font-weight-bold text-success mb-1">Active Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $statistics['active_users'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users List Card -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Company Users</h6>
                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addUserModal">
                        <i class="fas fa-plus fa-sm"></i> Add User
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
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
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $user->status === 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($user->status ?? 'Unknown') }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="editUser({{ $user->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})">
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
            </div>
        </div>
    </div>
</div>

<!-- Delete Company JavaScript -->
<script>
function deleteCompany(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will delete the company and all associated users. This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/companies/${id}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        'Company has been deleted.',
                        'success'
                    ).then(() => {
                        window.location.href = '{{ route("companies.index") }}';
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the company.',
                        'error'
                    );
                }
            });
        }
    });
}

function deleteUser(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/users/${id}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        'User has been deleted.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the user.',
                        'error'
                    );
                }
            });
        }
    });
}

// Initialize DataTable
$(document).ready(function() {
    $('#usersTable').DataTable({
        responsive: true,
        order: [[4, 'desc']], // Sort by joined date by default
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search users..."
        }
    });
});
</script>

<style>
.company-info .info-group label {
    font-size: 0.8rem;
    text-transform: uppercase;
}

.badge {
    font-size: 0.85rem;
}

.breadcrumb {
    margin-bottom: 0;
    font-size: 0.9rem;
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: none;
}

.table th {
    background-color: #f8f9fc;
    font-weight: 600;
}
</style>

@endsection