@extends('admin.index')
@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Company Management') }}</h1>
        <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#addCompanyModal">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">{{ __('Add New Company') }}</span>
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Companies Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Companies</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $companies->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Companies Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Companies</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $companies->where('status', 'active')->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- This Month's New Companies Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                New This Month</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $companies->where('created_at', '>=', now()->startOfMonth())->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-plus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Companies Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Companies List') }}</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Export Options:</div>
                    <a class="dropdown-item" href="#"><i class="fas fa-file-excel mr-2"></i>Export Excel</a>
                    <a class="dropdown-item" href="#"><i class="fas fa-file-pdf mr-2"></i>Export PDF</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="companiesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Company Name</th>
                            <th>Admin</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Total Users</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                        <tr>
                            <td>{{ $company->id }}</td>
                            <td>{{ $company->name }}</td>
                            <td>
                                @if($admin = $company->users->first())
                                    {{ $admin->name }}
                                @else
                                    <span class="text-muted">No Admin</span>
                                @endif
                            </td>
                            <td>{{ $admin->email ?? 'N/A' }}</td>
                            <td>{{ $admin->phone ?? 'N/A' }}</td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $company->users->count() }} Users
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $company->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($company->status ?? 'Unknown') }}
                                </span>
                            </td>
                            <td>{{ $company->created_at ? $company->created_at->format('Y-m-d') : 'N/A' }}</td>
                            <td>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="editCompany({{ $company->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="{{route('companies.show',$company->id)}}" class="btn btn-info btn-sm" onclick="viewCompany({{ $company->id }})">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteCompany({{ $company->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Company Modal -->
<div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('companies.store') }}" method="POST" id="addCompanyForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Company</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection