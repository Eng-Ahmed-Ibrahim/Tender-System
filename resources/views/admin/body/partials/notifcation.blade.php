@php
$notifications = auth()->user()->notifications; 
$unreadCount = auth()->user()->unreadNotifications->count(); 
@endphp

<div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
    <!-- Menu Wrapper -->
    <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" 
         data-kt-menu-trigger="{default: 'click', lg: 'hover'}" 
         data-kt-menu-attach="parent" 
         data-kt-menu-placement="bottom-end" 
         id="kt_menu_item_wow">
        <i class="ki-duotone ki-notification-status fs-2">
            <span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
            <span class="path4"></span>
        </i>
        @if($unreadCount > 0)
            <span class="badge badge-danger">{{ $unreadCount }}</span>
        @endif
    </div>

    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
        <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
            <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications
            <span class="fs-8 opacity-75 ps-3">{{ $notifications->count() }} reports</span></h3>
        </div>
        
        <div class="tab-content">
            <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
                <div class="scroll-y mh-325px my-5 px-8">
                    @foreach ($notifications as $notification)
                    <div class="d-flex flex-stack py-4" id="notification-{{ $notification->id }}">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-35px me-4">
                                <span class="symbol-label bg-light-primary">
                                    <i class="ki-duotone ki-abstract-28 fs-2 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <div class="mb-0 me-2">
                                <a href="{{ route('notifications.read', $notification->id) }}" 
                                   class="fs-6 text-gray-800 text-hover-primary fw-bold" 
                                   onclick="markAsRead({{ $notification->id }}); event.preventDefault();">{{ $notification->data['message'] }}</a>
                                <div class="text-gray-400 fs-7">
                                    {{ $notification->created_at->diffForHumans() }}
                                    @if($notification->read_at)
                                        <span class="badge badge-light fs-8 ms-2">Read</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <span class="badge badge-light fs-8">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="py-3 text-center border-top">
                    <a href="{{ route('notifications.index') }}" class="btn btn-color-gray-600 btn-active-color-primary">View All
                    <i class="ki-duotone ki-arrow-right fs-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function markAsRead(notificationId) {
    fetch(`/notifications/read/${notificationId}`, {
        method: 'POST', 
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
    .then(response => {
        if (response.ok) {
            // Add the 'read' class to change styles, if any
            document.getElementById(`notification-${notificationId}`).classList.add('read');

            // Update the notification UI to show it's read
            const notificationElement = document.getElementById(`notification-${notificationId}`);
            const readLabel = document.createElement('span');
            readLabel.className = 'badge badge-light fs-8 ms-2';
            readLabel.innerText = 'Read';
            notificationElement.querySelector('.text-gray-400').appendChild(readLabel);
        } else {
            console.error('Failed to mark notification as read');
        }
    })
    .catch(error => console.error('Error marking notification as read:', error));
}
</script>
