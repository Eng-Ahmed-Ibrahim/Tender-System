@extends('admin.index')
@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white py-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-bell fa-2x me-3"></i>
                <h3 class="card-title mb-0 flex-grow-1">{{__('Send Notification')}}</h3>
                <span class="badge bg-light text-primary" id="selectedCount">0</span>
            </div>
        </div>
        
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <div class="flex-grow-1">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <div class="flex-grow-1">{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <form action="{{ route('notifications.store') }}" method="POST" id="notificationForm">
                @csrf
                <div class="mb-4">
                    <label class="form-label h6">{{__('Recipients')}}</label>
                    @if (auth()->user()->role_id == 4)
                    <div class="recipient-type p-3 bg-light rounded mb-3">
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="recipient_type" id="specificUsers" value="specific" checked>
                            <label class="btn btn-outline-primary" for="specificUsers">
                                <i class="fas fa-users me-2"></i>{{__('Specific Users')}}
                            </label>
                            <input type="radio" class="btn-check" name="recipient_type" id="allCompanies" value="companies">
                            <label class="btn btn-outline-primary" for="allCompanies">
                                <i class="fas fa-building me-2"></i>{{__('All Companies')}} 
                            </label>
                             
                            <input type="radio" class="btn-check" name="recipient_type" id="allUsers" value="all">
                            <label class="btn btn-outline-primary" for="allUsers">
                                <i class="fas fa-globe me-2"></i>{{__('All Users')}}
                            </label>
 
                        </div>  
                    </div> 
@endif
                    <div id="userSelectSection" class="mb-3">
                        <div class="row">
                            <div class="col-md-8">
                               
                                
                                <div class="user-select-wrapper">
                                    <select name="users[]" multiple class="form-select user-select" size="12">
                                        <optgroup label="Companies" class="user-group">
                                            @foreach($users->where('role', 'admin_company') as $user)
                                                <option value="{{ $user->id }}" data-search="{{ strtolower($user->name . ' ' . $user->email) }}">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-building me-2"></i>
                                                        {{ $user->name }}
                                                        <small class="text-muted ms-2">({{ $user->email }})</small>
                                                    </div>
                                                </option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Other Users" class="user-group">
                                            @foreach($users->where('role', '!=', 'company') as $user)
                                                <option value="{{ $user->id }}" data-search="{{ strtolower($user->name . ' ' . $user->email) }}">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-user me-2"></i>
                                                        {{ $user->name }}
                                                        <small class="text-muted ms-2">({{ $user->email }})</small>
                                                    </div>
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    {{__('Use Ctrl/Cmd + Click for multiple selections')}}
                                </small>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card h-100 border-0 shadow-sm"> 
                                    <div class="card-body">  
                                        <h6 class="card-title mb-3"> 
                                            <i class="fas fa-filter me-2"></i>{{__('Quick Filters')}}
                                        </h6> 
                                        <div class="d-grid gap-2">
                                            
                                            <button type="button" class="btn btn-outline-secondary btn-sm select-others">
                                                <i class="fas fa-users me-2"></i>{{__('Select All Other Users')}}
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm clear-selection">
                                                <i class="fas fa-times me-2"></i>{{__('Clear Selection')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label h6">{{__('Notification Title')}}</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-heading"></i>
                        </span>
                        <input type="text" name="title" required 
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="{{__('Enter notification title')}}">
                    </div>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label h6">{{__('Message Content')}}</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-comment-alt"></i>
                        </span>
                        <textarea name="body" required rows="4" 
                                  class="form-control @error('body') is-invalid @enderror"
                                  placeholder="{{__('Enter your message here...')}}"></textarea>
                    </div>
                    @error('body')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                        <i class="fas fa-arrow-left me-2"></i>{{__('Cancel')}}
                    </button>
                    <button type="submit" class="btn btn-primary" id="sendButton">
                        <i class="fas fa-paper-plane me-2"></i>{{__('Send Notification')}}
                        <span class="badge bg-light text-primary ms-2" id="recipientCount">0</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #2196F3, #1976D2);
}

.bg-gradient-primary {
    background: var(--primary-gradient);
}

.card {
    transition: box-shadow 0.3s ease;
}

.user-select-wrapper {
    position: relative;
    background: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.user-select {
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    overflow: hidden;
}

.user-select optgroup {
    font-weight: 600;
    background-color: #f8f9fa;
    padding: 0.5rem;
    color: #495057;
}

.user-select option {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #f1f1f1;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.user-select option:hover {
    background-color: #f8f9fa;
}

.user-select option:checked {
    background: var(--primary-gradient);
    color: white;
}

.btn-group {
    border-radius: 0.5rem;
    overflow: hidden;
}

.btn-group .btn {
    flex: 1;
    padding: 0.75rem;
    transition: all 0.3s ease;
}

.btn-check:checked + .btn-outline-primary {
    background: var(--primary-gradient);
    border-color: transparent;
}

.input-group-text {
    background-color: #f8f9fa;
    border-right: none;
}

.input-group .form-control {
    border-left: none;
}

.input-group .form-control:focus {
    border-color: #dee2e6;
    box-shadow: none;
}

.btn {
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.alert {
    border: none;
    border-radius: 0.5rem;
}

#userSearch {
    padding-right: 2.5rem;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}

/* Animation for alerts */
.alert.show {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateY(-10px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const recipientTypeRadios = document.querySelectorAll('input[name="recipient_type"]');
    const userSelectSection = document.getElementById('userSelectSection');
    const userSelect = document.querySelector('select[name="users[]"]');
    const selectedCount = document.getElementById('selectedCount');
    const recipientCount = document.getElementById('recipientCount');
    const form = document.getElementById('notificationForm');
    
    function updateSelectedCount() {
        const count = userSelect.selectedOptions.length;
        selectedCount.textContent = `${count} selected`;
        recipientCount.textContent = count;
        
        if (count > 0) {
            selectedCount.classList.remove('bg-light', 'text-primary');
            selectedCount.classList.add('bg-primary', 'text-white');
        } else {
            selectedCount.classList.add('bg-light', 'text-primary');
            selectedCount.classList.remove('bg-primary', 'text-white');
        }
    }
    
    // Handle recipient type change
    recipientTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            userSelectSection.style.display = this.value === 'specific' ? 'block' : 'none';
            if (this.value !== 'specific') {
                userSelect.selectedIndex = -1;
                updateSelectedCount();
            }
        });
    });

    // Quick filter buttons - Fix for select-others button
    const selectOthersButton = document.querySelector('.select-others');
    if (selectOthersButton) {
        selectOthersButton.addEventListener('click', function() {
            Array.from(userSelect.options).forEach(option => {
                if (option.parentElement.label === 'Other Users') {
                    option.selected = true;
                }
            });
            updateSelectedCount();
        });
    }

    // Clear selection button
    const clearSelectionButton = document.querySelector('.clear-selection');
    if (clearSelectionButton) {
        clearSelectionButton.addEventListener('click', function() {
            userSelect.selectedIndex = -1;
            updateSelectedCount();
        });
    }
    
    // Search functionality
    const userSearch = document.getElementById('userSearch');
    if (userSearch) {
        userSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            Array.from(userSelect.options).forEach(option => {
                const searchData = option.getAttribute('data-search');
                const matches = searchData && searchData.includes(searchTerm);
                option.style.display = matches || !searchTerm ? '' : 'none';
            });
        });
    }
    
    // Update counter when selection changes
    userSelect.addEventListener('change', updateSelectedCount);
    
    // Form validation
    form.addEventListener('submit', function(e) {
        const recipientType = document.querySelector('input[name="recipient_type"]:checked').value;
        if (recipientType === 'specific' && userSelect.selectedOptions.length === 0) {
            e.preventDefault();
            alert('Please select at least one recipient');
        }
    });
    
    // Initialize counter
    updateSelectedCount();
});
</script>
@endsection