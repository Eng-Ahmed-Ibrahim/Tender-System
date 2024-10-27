<!-- resources/views/dashboard/notifications/create.blade.php -->
@extends('admin.index')
@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Send Notification</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <form action="{{ route('notifications.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-bold">Select Recipients</label>
                    <div class="recipient-type mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="recipient_type" id="specificUsers" value="specific" checked>
                            <label class="form-check-label" for="specificUsers">Specific Users</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="recipient_type" id="allCompanies" value="companies">
                            <label class="form-check-label" for="allCompanies">All Companies</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="recipient_type" id="allUsers" value="all">
                            <label class="form-check-label" for="allUsers">All Users</label>
                        </div>
                    </div>

                    <div id="userSelectSection" class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <select name="users[]" multiple class="form-select user-select" size="8">
                                    <optgroup label="Companies">
                                        @foreach($users->where('role', 'company') as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Other Users">
                                        @foreach($users->where('role', '!=', 'company') as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple users</small>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">Quick Filters</h6>
                                        <button type="button" class="btn btn-outline-primary btn-sm mb-2 me-2 select-companies">
                                            Select All Companies
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm mb-2 me-2 select-others">
                                            Select All Other Users
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm mb-2 clear-selection">
                                            Clear Selection
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" required class="form-control @error('title') is-invalid @enderror">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea name="body" required rows="4" class="form-control @error('body') is-invalid @enderror"></textarea>
                    @error('body')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Send Notification
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.user-select {
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

.user-select optgroup {
    font-weight: 600;
    background-color: #f8f9fa;
}

.user-select option {
    padding: 8px;
    border-bottom: 1px solid #eee;
}

.user-select option:hover {
    background-color: #f0f0f0;
}

.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0,0,0,.125);
}

/* Make the select box more modern and attractive */
.form-select[multiple] {
    padding: 0;
}

.form-select[multiple] option {
    padding: 8px 12px;
}

.form-select[multiple] option:checked {
    background-color: #0d6efd linear-gradient(0deg, #0d6efd 0%, #0d6efd 100%);
    color: white;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const recipientTypeRadios = document.querySelectorAll('input[name="recipient_type"]');
    const userSelectSection = document.getElementById('userSelectSection');
    const userSelect = document.querySelector('select[name="users[]"]');
    
    // Handle recipient type change
    recipientTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            userSelectSection.style.display = this.value === 'specific' ? 'block' : 'none';
            if (this.value !== 'specific') {
                userSelect.selectedIndex = -1;
            }
        });
    });

    // Quick filter buttons
    document.querySelector('.select-companies').addEventListener('click', function() {
        Array.from(userSelect.options).forEach(option => {
            if (option.parentElement.label === 'Companies') {
                option.selected = true;
            }
        });
    });

    document.querySelector('.select-others').addEventListener('click', function() {
        Array.from(userSelect.options).forEach(option => {
            if (option.parentElement.label === 'Other Users') {
                option.selected = true;
            }
        });
    });

    document.querySelector('.clear-selection').addEventListener('click', function() {
        userSelect.selectedIndex = -1;
    });
});
</script>
@endsection