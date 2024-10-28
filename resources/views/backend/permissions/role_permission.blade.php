@extends('admin.index')

@section('css')
<style>
.permission-card {
    transition: all 0.3s ease;
    border: none;
}

.permission-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
}

.role-header {
    background: linear-gradient(45deg, #3b82f6 0%, #8b5cf6 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
}

.permission-group {
    border-radius: 0.75rem;
    background-color: #f8fafc;
    margin-bottom: 1.5rem;
}

.permission-group-header {
    padding: 1rem 1.5rem;
    background-color: #f1f5f9;
    border-radius: 0.75rem 0.75rem 0 0;
}

.permission-item {
    transition: all 0.2s ease;
}

.permission-item:hover {
    background-color: #f1f5f9;
}

.custom-switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 30px;
}

.custom-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.switch-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #e2e8f0;
    transition: .4s;
    border-radius: 30px;
}

.switch-slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .switch-slider {
    background-color: #3b82f6;
}

input:checked + .switch-slider:before {
    transform: translateX(30px);
}

.permission-count-badge {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.875rem;
}
</style>
@endsection

@section('content')
<div class="container-fluid p-4">
    <!-- Role Header -->
    <div class="role-header text-white">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-6 fw-bold mb-2">{{ $role->title }}</h1>
                <p class="lead mb-0 opacity-75">
                    {{ __('Manage permissions for this role') }}
                </p>
            </div>
            <div class="col-lg-6 text-lg-end">
                <div class="d-inline-flex align-items-center bg-white bg-opacity-10 rounded-3 p-3">
                    <div class="me-3">
                        <div class="fs-4 fw-bold">{{ $permissions->count() }}</div>
                        <div class="text-white-50">{{ __('Total Permissions') }}</div>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold">{{ $role->permissions->count() }}</div>
                        <div class="text-white-50">{{ __('Assigned Permissions') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('roles.permissions.store', $role->id) }}" id="permissionsForm">
        @csrf
        
        <!-- Master Toggle -->
        <div class="card permission-card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">{{ __('Administrator Access') }}</h5>
                    <p class="text-muted small mb-0">{{ __('Grant all permissions to this role') }}</p>
                </div>
                <label class="custom-switch">
                    <input type="checkbox" id="kt_roles_select_all">
                    <span class="switch-slider"></span>
                </label>
            </div>
        </div>

        <!-- Permission Groups -->
        @foreach($permissions->groupBy('group_name') as $groupName => $groupPermissions)
        <div class="permission-group">
            <div class="permission-group-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">{{ __($groupName) }}</h5>
                    <p class="text-muted small mb-0">{{ $groupPermissions->count() }} {{ __('permissions') }}</p>
                </div>
                <span class="permission-count-badge">
                    {{ $groupPermissions->filter(function($permission) use ($role) { 
                        return $role->hasPermissionTo($permission);
                    })->count() }} / {{ $groupPermissions->count() }}
                </span>
            </div>
            
            <div class="p-4">
                <div class="row g-3">
                    @foreach($groupPermissions as $permission)
                    <div class="col-lg-4">
                        <div class="permission-item d-flex justify-content-between align-items-center p-3 rounded">
                            <div>
                                <h6 class="mb-1">{{ __($permission->name) }}</h6>
                                <p class="text-muted small mb-0">{{ __($permission->description ?? 'No description available') }}</p>
                            </div>
                            <label class="custom-switch">
                                <input type="checkbox" 
                                       name="permissions[]" 
                                       value="{{ $permission->id }}" 
                                       class="permission-checkbox"
                                       {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}>
                                <span class="switch-slider"></span>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

        <!-- Save Button -->
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-save me-2"></i>{{ __('Save Changes') }}
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('kt_roles_select_all');
    const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
    
    // Initialize "Select All" state
    function updateSelectAllState() {
        const allChecked = Array.from(permissionCheckboxes).every(checkbox => checkbox.checked);
        selectAllCheckbox.checked = allChecked;
    }
    
    // Handle "Select All" changes
    selectAllCheckbox.addEventListener('change', function() {
        permissionCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });
    
    // Handle individual permission changes
    permissionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectAllState);
    });
    
    // Set initial state
    updateSelectAllState();
    
    // Form submission with sweet alert
    document.getElementById('permissionsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: '{{ __("Save Changes?") }}',
            text: '{{ __("Are you sure you want to update the permissions for this role?") }}',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '{{ __("Yes, save changes") }}',
            cancelButtonText: '{{ __("Cancel") }}',
            confirmButtonColor: '#3b82f6'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>
@endsection