@extends('admin.index')

@section('content')
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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"></h1>
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
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <form action="" method="GET">
                                    <input type="text" name="search" value="{{ request()->input('search') }}" class="form-control form-control-solid w-250px ps-12" placeholder="Search Role" />
                                </form>                                                        </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Add customer-->
                            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                                {{ __('Create') }}
                            </button>                            <!--end::Add customer-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Permissions') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="roles-table">
                                @foreach($roles as $role)
                                    <tr id="role-{{ $role->id }}">
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @foreach($role->permissions as $permission)
                                                <span class="badge bg-secondary"><b>{{ $permission->name }}</b></span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                               
                                                <a href="{{route('roles.permissions.view', $role->id)}}" class="btn btn-secondary btn-sm" data-role-id="{{ $role->id }}" data-role-name="{{ $role->name }}">
                                                    {{ __('Edit') }}
                                                </a>
                                                
                                                <form action="{{ route('role.destroy', $role->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('{{ __('Confirm Delete?') }}');">
                                                        <i class="fas fa-trash"></i> {{ __('Delete') }}
                                                    </button>
                                                </form>
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

<!-- Create Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">{{__('Add a Role')}}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y mx-lg-5 my-7">
                <form method="post" action="{{ route('role.store') }}" class="form">
                    @csrf
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" data-kt-scroll="true" data-kt-scroll-max-height="auto" data-kt-scroll-offset="300px">
                        <div class="fv-row mb-10">
                            <label class="fs-5 fw-bold form-label mb-2">
                                <span class="required">{{__('Role Name')}}</span>
                            </label>
                            <input class="form-control form-control-solid" placeholder="Enter a role name" name="name" required>
                        </div>
                        <div class="fv-row">
                            <label class="fs-5 fw-bold form-label mb-2">{{__('Permissions')}}</label>
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <tbody class="text-gray-600 fw-semibold">
                                        <tr>
                                            <td class="text-gray-800">Administrator Access
                                                <span class="ms-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Allows full access to the system">
                                                    <i class="ki-duotone ki-information fs-7"></i>
                                                </span>
                                            </td>
                                            <td>
                                                <label class="form-check form-check-custom form-check-solid me-9">
                                                    <input class="form-check-input" type="checkbox" id="kt_roles_select_all" />
                                                    <span class="form-check-label" for="kt_roles_select_all">Select all</span>
                                                </label>
                                            </td>
                                        </tr>
                                        @foreach($permissions->groupBy('group_name') as $groupName => $groupPermissions)
                                            <tr>
                                                <td class="text-gray-800">{{ __($groupName) }}</td>
                                                @foreach($groupPermissions as $permission)
                                                    <td>
                                                        <div class="d-flex">
                                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                <input class="form-check-input" type="checkbox" value="{{ $permission->id }}" name="permissions[]" />
                                                                <span class="form-check-label">{{ $permission->name }}</span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-roles-modal-action="cancel">{{__('Discard')}}</button>
                        <button type="submit" class="btn btn-secondary" data-kt-roles-modal-action="submit">
                            {{__('Submit')}}
                        </button>
                    </div>
                </form>
                
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const selectAllCheckbox = document.getElementById('kt_roles_select_all');
                    const permissionCheckboxes = document.querySelectorAll('input[name="permissions[]"]');
                
                    selectAllCheckbox.addEventListener('change', function() {
                        permissionCheckboxes.forEach(function(checkbox) {
                            checkbox.checked = selectAllCheckbox.checked;
                        });
                    });
                
                    permissionCheckboxes.forEach(function(checkbox) {
                        checkbox.addEventListener('change', function() {
                            if (!this.checked) {
                                selectAllCheckbox.checked = false;
                            } else {
                                const allChecked = Array.from(permissionCheckboxes).every(function(checkbox) {
                                    return checkbox.checked;
                                });
                                selectAllCheckbox.checked = allChecked;
                            }
                        });
                    });
                });
                </script>
                
                
            </div>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="edit-role-form">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleModalLabel">{{ __('Edit Role') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" name="name" id="edit-role-name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary">{{ __('Save Changes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal -->

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Role
        document.querySelectorAll('.edit-role-btn').forEach(button => {
            button.addEventListener('click', function() {
                const roleId = this.getAttribute('data-id');
                const roleName = this.getAttribute('data-name');
                const editForm = document.getElementById('edit-role-form');
                
                editForm.setAttribute('action', `/roles/${roleId}`);
                document.getElementById('edit-role-name').value = roleName;
                
                const editRoleModal = new bootstrap.Modal(document.getElementById('editRoleModal'));
                editRoleModal.show();
            });
        });

       
});

</script>
@endsection
