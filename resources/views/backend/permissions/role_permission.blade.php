@extends('admin.index')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2>{{ __('Role') }}: {{ $role->name}}</h2>
                <form method="POST" action="{{ route('roles.permissions.store', $role->id) }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <tbody class="text-gray-600 fw-semibold">
                                <tr>
                                    <td class="text-gray-800">{{__('Administrator Access')}}
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
                                                        <input class="form-check-input" type="checkbox" name="permissions[]" id="permission_{{ $permission->id }}" value="{{ $permission->id }}" {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}>
                                                        <span class="form-check-label">{{ __($permission->name) }}</span>
                                                    </label>
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center pt-15">
                        <button type="submit" class="btn btn-secondary">{{ __('Save Changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
@endsection
