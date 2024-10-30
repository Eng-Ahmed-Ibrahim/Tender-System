<!-- resources/views/dashboard/notifications/index.blade.php -->
@extends('admin.index')
@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title m-0">{{__('Sent Notifications')}}</h3>
            <a href="{{ route('notifications.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>{{__('Send New Notification')}}
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>{{__('User')}}</th>
                            <th>{{__('Title')}}</th>
                            <th>{{__('Message')}}</th>
                            <th>{{__('Sent At')}}</th>
                            <th>{{__('Status')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notifications as $notification)
                            <tr>
                                <td>{{ $notification->user->name }}</td>
                                <td>{{ $notification->title }}</td>
                                <td>{{$notification->body }}</td>
                                <td>{{ $notification->created_at}}</td>
                                <td>
                                    @if($notification->is_read)
                                        <span class="badge bg-success">Read</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Unread</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-3">No notifications found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</div>

<style>
/* Optional: Custom styling for better appearance */
.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}

.table > :not(caption) > * > * {
    padding: 12px 1rem;
}

.badge {
    padding: 0.5em 0.8em;
}

/* Style for Laravel pagination when using Bootstrap */
.pagination {
    margin-bottom: 0;
}

.page-link {
    padding: 0.375rem 0.75rem;
}

.page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

/* Optional: Make the table more compact on mobile */
@media (max-width: 768px) {
    .table > :not(caption) > * > * {
        padding: 8px;
    }
    
    .table {
        font-size: 0.9rem;
    }
}
</style>

@push('scripts')
<script>
// Optional: Add DataTable for better table functionality
$(document).ready(function() {
    $('.table').DataTable({
        responsive: true,
        order: [[3, 'desc']], // Sort by Sent At column by default
        pageLength: 10,
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ notifications",
            emptyTable: "No notifications found"
        }
    });
});
</script>
@endpush
@endsection