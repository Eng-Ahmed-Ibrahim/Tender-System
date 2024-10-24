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
                <div class="mb-3">
                    <label class="form-label">Select Users</label>
                    <select name="users[]" multiple class="form-select" size="5">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple users</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" required class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea name="body" required rows="4" class="form-control"></textarea>
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
/* Optional: Custom styling for multiple select */
.form-select[multiple] {
    padding: 8px;
}

/* Optional: Make the form more compact */
.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0,0,0,.125);
}
</style>
@endsection