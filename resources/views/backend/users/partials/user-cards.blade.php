<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" style="width: 40px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                            </div>
                        </th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Contact') }}</th>
                        <th>{{ __('Role') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Joined Date') }}</th>
                        <th class="text-end pe-4">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="form-check">
                                <input class="form-check-input user-checkbox" 
                                       type="checkbox" 
                                       value="{{ $user->id }}"
                                       name="selected_users[]">
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3" style="width: 40px; height: 40px;">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar }}" 
                                             alt="{{ $user->name }}"
                                             class="rounded-circle w-100 h-100">
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center w-100 h-100 text-secondary fw-bold">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="mb-1">
                                    <i class="fas fa-phone-alt text-muted me-2"></i>
                                    <span>{{ $user->phone ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                    <span>{{ $user->address ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if(auth()->user()->role === 'admin')
                            <select class="form-select form-select-sm role-select" 
                                    onchange="updateRole(this, {{ $user->id }})"
                                    style="width: 150px;">
                                <option value="" disabled {{ is_null($user->role_id) ? 'selected' : '' }}>
                                    {{ __('No Role') }}
                                </option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" 
                                        {{ $user->role_id === $role->id ? 'selected' : '' }}>
                                    {{ $role->title }}
                                </option>
                                @endforeach
                            </select>
                            @else
                            <span class="badge bg-light text-dark">
                                {{ $user->role?->title ?? 'No Role' }}
                            </span>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusClass = [
                                    'active' => 'success',
                                    'inactive' => 'warning',
                                    'suspended' => 'danger'
                                ][$user->status ?? 'inactive'];
                            @endphp
                            <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }}">
                                {{ __(ucfirst($user->status ?? 'Inactive')) }}
                            </span>
                        </td>
                        <td>
                            <div>
                                {{ $user->created_at->format('M d, Y') }}
                                <div class="text-muted small">
                                    {{ $user->created_at->format('h:i A') }}
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('AdminUsers.edit', $user->id) }}">
                                            <i class="fas fa-edit me-2"></i>{{ __('Edit') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="resetPassword({{ $user->id }})">
                                            <i class="fas fa-key me-2"></i>{{ __('Reset Password') }}
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('AdminUsers.destroy', $user->id) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="dropdown-item text-danger" 
                                                    onclick="confirmDelete(this)">
                                                <i class="fas fa-trash-alt me-2"></i>{{ __('Delete') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-users fa-2x mb-3"></i>
                                <p>{{ __('No users found') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($users->hasPages())
<div class="d-flex justify-content-between align-items-center mt-4">
    <div class="text-muted">
        {{ __('Showing') }} {{ $users->firstItem() }} {{ __('to') }} {{ $users->lastItem() }} 
        {{ __('of') }} {{ $users->total() }} {{ __('entries') }}
    </div>
    <div>
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endif

@push('styles')
<style>
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
    }
    
    .role-select {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        background-color: #fff;
        transition: all 0.2s;
    }
    
    .role-select:hover {
        border-color: #a1a1aa;
    }
    
    .user-checkbox:checked {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }
    
    .bg-success-subtle {
        background-color: #def7ec;
    }
    
    .bg-warning-subtle {
        background-color: #fef3c7;
    }
    
    .bg-danger-subtle {
        background-color: #fde2e2;
    }
    
    .text-success {
        color: #046c4e !important;
    }
    
    .text-warning {
        color: #9f580a !important;
    }
    
    .text-danger {
        color: #c81e1e !important;
    }
</style>
@endpush

@push('scripts')
<script>
document.getElementById('selectAll')?.addEventListener('change', function() {
    document.querySelectorAll('.user-checkbox').forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

document.querySelectorAll('.user-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const allChecked = Array.from(document.querySelectorAll('.user-checkbox'))
            .every(cb => cb.checked);
        document.getElementById('selectAll').checked = allChecked;
    });
});
</script>
@endpush