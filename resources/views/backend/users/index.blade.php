{{-- resources/views/backend/users/index.blade.php --}}
@extends('admin.index')

@section('css')
<style>
.header-banner {
    background: linear-gradient(45deg, #1a73e8 0%, #6c5dd3 100%);
    border-radius: 1rem;
    padding: 2rem;
    margin-bottom: 2rem;
}

.user-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 1rem;
}

.user-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
}

.user-avatar {
    width: 45px;
    height: 45px;
    background: #e9ecef;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    font-weight: 600;
    color: #6c757d;
}

.stats-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 1rem;
    padding: 1.5rem;
}

.search-box {
    background: #f8f9fa;
    border: none;
    border-radius: 1rem;
    padding: 1rem 1.5rem;
    transition: all 0.3s ease;
}

.role-badge {
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
}

/* Add your existing styles here */
</style>
@endsection

@section('content')
<div class="container-fluid p-4">
    <!-- Header Banner -->
    <div class="header-banner text-white mb-4">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-6 fw-bold mb-2">{{ __('User Management') }}</h1>
                <p class="lead mb-0 opacity-75">
                    {{ __('Manage and monitor user accounts') }}
                </p>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-sm-4">
                        <div class="stats-card">
                            <h3 class="mb-1">{{ $users->total() }}</h3>
                            <p class="mb-0 text-white-50">{{ __('Total Users') }}</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="stats-card">
                            <h3 class="mb-1">{{ $users->where('created_at', '>=', now()->subDays(30))->count() }}</h3>
                            <p class="mb-0 text-white-50">{{ __('New Users') }}</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="stats-card">
                            <h3 class="mb-1">{{ $roles->count() }}</h3>
                            <p class="mb-0 text-white-50">{{ __('User Roles') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4" id="usersContainer">

    <!-- Filters Section -->
    @include('backend.users.partials.filter')

    </div>
    <!-- Users Grid -->
    <div class="row g-4" id="usersContainer">
        @include('backend.users.partials.user-cards')
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">{{ __('Confirm Delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Are you sure you want to delete this user?') }}</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">{{ __('Delete') }}</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));

    // Handle role updates
    function updateRole(selectElement, userId) {
        Swal.fire({
            title: '{{ __("Update Role") }}',
            text: '{{ __("Are you sure you want to change this user's role?") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __("Yes, update") }}',
            cancelButtonText: '{{ __("Cancel") }}',
            confirmButtonColor: '#1a73e8'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/users/${userId}/update-role`;
                form.innerHTML = `
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="role_id" value="${selectElement.value}">
                `;
                document.body.appendChild(form);
                form.submit();
            } else {
                // Reset select to previous value
                selectElement.value = selectElement.getAttribute('data-previous');
            }
        });
    }

    // Handle user deletion
    function deleteUser(userId) {
        Swal.fire({
            title: '{{ __("Delete User") }}',
            text: '{{ __("Are you sure you want to delete this user?") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __("Yes, delete") }}',
            cancelButtonText: '{{ __("Cancel") }}',
            confirmButtonColor: '#dc3545'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.querySelector(`#deleteForm${userId}`);
                form.submit();
            }
        });
    }

    // Search functionality with debounce
    let searchTimeout;
    const searchInput = document.querySelector('#searchInput');
    
    searchInput?.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const searchTerm = this.value;
            updateUsers({ search: searchTerm });
        }, 500);
    });

    // Update users list
    async function updateUsers(params = {}) {
        const usersContainer = document.querySelector('#usersContainer');
        usersContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;

        try {
            const queryString = new URLSearchParams(params).toString();
            const response = await fetch(`${window.location.pathname}?${queryString}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) throw new Error('Network response was not ok');
            
            const html = await response.text();
            usersContainer.innerHTML = html;
            
            // Update URL without reload
            window.history.pushState({}, '', `${window.location.pathname}?${queryString}`);
            
            // Reinitialize components
            initializeComponents();
        } catch (error) {
            console.error('Error:', error);
            usersContainer.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-danger">
                        {{ __('An error occurred while fetching users. Please try again.') }}
                    </div>
                </div>
            `;
        }
    }

    // Initialize/reinitialize components
    function initializeComponents() {
        // Reinitialize tooltips
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(tooltip => {
            new bootstrap.Tooltip(tooltip);
        });

        // Reinitialize role selects
        document.querySelectorAll('.role-select').forEach(select => {
            select.addEventListener('focus', function() {
                this.setAttribute('data-previous', this.value);
            });
        });
    }

    // Initialize components on page load
    initializeComponents();
});
</script>
@endsection