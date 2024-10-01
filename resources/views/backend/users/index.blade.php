@extends('admin.index')

@section('content')

<style>

    .user-info {
        display: flex;
        align-items: center;
    }
    
    .user-avatar img {
        width: 40px; /* Adjust size as needed */
        height: 40px; /* Adjust size as needed */
        border-radius: 50%; /* Make the image circular */
        margin-right: 10px; /* Add spacing between image and name */
    }
    
    .card {
        margin-top: 20px;
    }

</style>

<!-- Include SweetAlert CSS and JavaScript -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@10" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{__('Users')}}</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
               
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
        
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Category-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                                                                    </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Add customer-->
                            <a href="{{ route('AdminUsers.create')}}" class="btn btn-secondary">{{__('Create')}}</a>
                            <!--end::Add customer-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">

<div class="card">



        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Name')}}</th>
                        <th>{{ __('Email')}}</th>
                        <th>{{ __('Phone')}}</th>
                        <th>{{ __('Address')}}</th>
                        <th>{{ __('Actions')}}</th>
                        <th>{{__('Delete')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        {{ $user->name }}
                                    </div>
                                </div>
                            </td>
                            <!-- Other table columns -->
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? 'N/A' }}</td>
                            <td>{{ $user->address ?? 'N/A' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <form id="updateRoleForm" method="POST" action="{{ route('admin.users.updateRole', $user->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <select name="role_id" class="btn btn-secondary" onchange="confirmUpdateRole(this)">
                                            @if (is_null($user->role_id))
                                                <option value="" disabled selected>no role</option>
                                            @endif
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ $user->role_id === $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <form id="deleteUserForm" method="POST" action="{{ route('AdminUsers.destroy', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-secondary" onclick="confirmDeleteUser(this)">{{__('Delete')}}</button>
                                </form>
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

<script>
    function confirmUpdateRole(selectElement) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form
                selectElement.closest('form').submit();
            } else {
                // Revert the select element to its original value
                // For example, you can reload the page or undo the selection change
            }
        });
    }

    function confirmDeleteUser(buttonElement) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form
                buttonElement.closest('form').submit();
            } else {
                // Do nothing or handle cancel action
            }
        });
    }
</script>


@endsection
