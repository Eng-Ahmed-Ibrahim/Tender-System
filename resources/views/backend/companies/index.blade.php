@extends('admin.index')
@section('content')


<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Company Management') }}</h1>
        <a href="{{route('companies.create')}}" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#addCompanyModal">
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
                                {{__('Total Companies')}}</div>
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
                                {{__('Active Companies')}}</div>
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
                                {{__('New This Month')}}</div>
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
          
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="companiesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{__('Company Name') }}</th>
                            <th>{{__('Admin') }}</th>
                            <th>{{__('Email') }}</th>
                            <th>{{__('Phone') }}</th>
                            <th>{{__('Total Users') }}</th>
                            <th>{{__('Status') }}</th>
                            <th>{{__('Created At') }}</th>
                            <th>{{__('Actions') }}</th>
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
                            <td>{{ $company->email ?? 'N/A' }}</td>
                            <td>{{ $company->phone ?? 'N/A' }}</td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $company->users->count() }} Users
                                </span>
                            </td>
                            <td>
                                @php
                                    $displayStatus = $company->status;
                                    if ($displayStatus === 'unactive') {
                                        $displayStatus = 'inactive';
                                    }
                                @endphp
                                <span class="badge badge-{{ $company->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($displayStatus ?? 'Unknown') }}
                                </span>
                            </td>
                            <td>{{ $company->created_at ? $company->created_at->format('Y-m-d') : 'N/A' }}</td>
                            <td>
                                <div class="d-flex">
                                    <a class="btn btn-primary btn-sm d-inline-flex align-items-center justify-content-center action-btn" href="{{route('companies.edit',$company->id)}}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a class="btn btn-info btn-sm d-inline-flex align-items-center justify-content-center action-btn" href="{{route('companies.show',$company->id)}}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="mx-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center action-btn" onclick="return confirm('Are you sure you want to delete this company?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('companies.toggle-status', $company->id) }}" method="POST" class="mx-0">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn {{ $company->status === 'active' ? 'btn-warning' : 'btn-success' }} btn-sm d-inline-flex align-items-center justify-content-center action-btn" onclick="return confirm('Are you sure you want to {{ $company->status === 'active' ? 'deactivate' : 'activate' }} this company?')">
                                            <i class="fas fa-{{ $company->status === 'active' ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            
                            <style>
                            .action-btn {
                                width: 32px !important;
                                height: 32px !important;
                                padding: 0 !important;
                                margin: 0 2px !important;
                            }
                            
                            /* Target the forms specifically inside table cells */
                            td form {
                                margin: 0 2px !important;
                                padding: 0 !important;
                            }
                            
                            /* Ensure no extra spacing from form elements */
                            td form button {
                                margin: 0 !important;
                            }
                            </style>
                        
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
                    <h5 class="modal-title">{{__('Add New Company') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('Company Name') }}<span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('Email Address') }} <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('Password') }} <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('Phone Number') }}</label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('Address') }}</label>
                                <textarea name="address" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{__('Save Company') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection