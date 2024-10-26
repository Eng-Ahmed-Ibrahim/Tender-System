@php
$notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->get(); 
$unreadCount = auth()->user()->notifications()->where('is_read', false)->count(); 
@endphp

{{-- Add required Firebase scripts in the header --}}
@push('scripts')
<script src="https://www.gstatic.com/firebasejs/9.x.x/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.x.x/firebase-messaging-compat.js"></script>
@endpush

<div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
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
            <span class="badge badge-danger" id="notification-badge">{{ $unreadCount }}</span>
        @endif
    </div>

    <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
        <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
            <h3 class="text-white fw-semibold px-9 mt-10 mb-6">
                Notifications
                <span class="fs-8 opacity-75 ps-3" id="notification-count">{{ $notifications->count() }} reports</span>
            </h3>
            <button class="btn btn-sm btn-light-primary mx-9 mb-6" id="enable-notifications" style="display: none;">
                Enable Push Notifications
            </button>
        </div>
        
        <div class="tab-content">
            <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
                <div class="scroll-y mh-325px my-5 px-8" id="notifications-container">
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
                                <a href="#" 
                                   class="fs-6 text-gray-800 text-hover-primary fw-bold" 
                                   onclick="markAsRead({{ $notification->id }}); event.preventDefault();">
                                   {{ $notification->title }}
                                </a>
                                <div class="text-gray-400 fs-7">
                                    {{ $notification->body }}
                                </div>
                                <div class="text-gray-400 fs-7">
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        @if($notification->is_read)
                            <span class="badge badge-light fs-8 ms-2">Read</span>
                        @endif
                    </div>
                    @endforeach
                </div>
                <div class="py-3 text-center border-top">
                    <a href="{{ route('notifications.index') }}" class="btn btn-color-gray-600 btn-active-color-primary">
                        View All
                        <i class="ki-duotone ki-arrow-right fs-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Firebase Configuration
const firebaseConfig = {
    apiKey: "AIzaSyChZV9M5E8jh8HQWl5zUu6M9ZFGP2zUQmA",
    authDomain: "magg-2425d.firebaseapp.com",
    projectId: "magg-2425d",
    storageBucket: "magg-2425d.appspot.com",
    messagingSenderId: "268526652965",
    appId: "1:268526652965:web:8b867899f5b84e5d119bc4"
};

// Create and register service worker
const registerServiceWorker = async () => {
    if ('serviceWorker' in navigator) {
        try {
            const registration = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
            console.log('Service Worker registered with scope:', registration.scope);
            return registration;
        } catch (error) {
            console.error('Service Worker registration failed:', error);
            return null;
        }
    }
    return null;
};

// Generate the service worker content dynamically
const generateServiceWorker = () => {
    const swContent = `
        importScripts('https://www.gstatic.com/firebasejs/9.x.x/firebase-app-compat.js');
        importScripts('https://www.gstatic.com/firebasejs/9.x.x/firebase-messaging-compat.js');

        firebase.initializeApp({
            apiKey: "${firebaseConfig.apiKey}",
            authDomain: "${firebaseConfig.authDomain}",
            projectId: "${firebaseConfig.projectId}",
            storageBucket: "${firebaseConfig.storageBucket}",
            messagingSenderId: "${firebaseConfig.messagingSenderId}",
            appId: "${firebaseConfig.appId}"
        });

        const messaging = firebase.messaging();

        messaging.onBackgroundMessage((payload) => {
            const notificationTitle = payload.notification.title;
            const notificationOptions = {
                body: payload.notification.body,
                icon: '/assets/media/logos/favicon.ico',
                badge: '/assets/media/logos/favicon.ico',
                data: payload.data
            };

            return self.registration.showNotification(notificationTitle, notificationOptions);
        });
    `;

    // Create a Blob with the service worker content
    const blob = new Blob([swContent], { type: 'application/javascript' });
    return URL.createObjectURL(blob);
};

// Initialize Firebase
let messaging = null;

async function initializeFirebase() {
    try {
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        
        if (!firebase.messaging.isSupported()) {
            console.log('Firebase messaging is not supported');
            return;
        }

        // Register service worker dynamically
        const swUrl = generateServiceWorker();
        await navigator.serviceWorker.register(swUrl);
        
        messaging = firebase.messaging();

        // Request permission and get token
        const permission = await Notification.requestPermission();
        if (permission === 'granted') {
            try {
                const currentToken = await messaging.getToken({
                    vapidKey: "BF1lJfUSSXOSu55Qg5kUx_-hDgGrZ9-sHsk9_xA8i7GfpKXWG6QRf4Jn1pOhQvxbSUOlj56ZA9sPxwcdtmTIbZY"
                });
                
                if (currentToken) {
                    console.log('FCM Token:', currentToken);
                    await updateFcmToken(currentToken);
                }
            } catch (err) {
                console.error('Error getting token:', err);
            }
        }

        // Handle foreground messages
        messaging.onMessage((payload) => {
            console.log('Received foreground message:', payload);
            handleNotification(payload);
        });

    } catch (error) {
        console.error('Firebase initialization error:', error);
    }
}

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeFirebase();
    checkNotificationPermission();
});

// Rest of your existing functions...
function checkNotificationPermission() {
    const enableButton = document.getElementById('enable-notifications');
    if (enableButton && Notification.permission !== 'granted' && Notification.permission !== 'denied') {
        enableButton.style.display = 'block';
        enableButton.addEventListener('click', requestNotificationPermission);
    }
}

async function requestNotificationPermission() {
    try {
        const permission = await Notification.requestPermission();
        if (permission === 'granted') {
            document.getElementById('enable-notifications').style.display = 'none';
            initializeFirebase();
        }
    } catch (error) {
        console.error('Error requesting permission:', error);
    }
}

function handleNotification(payload) {
    // Show browser notification
    const notification = new Notification(payload.notification.title, {
        body: payload.notification.body,
        icon: '/assets/media/logos/favicon.ico'
    });

    // Add notification to the list
    const notificationHtml = createNotificationElement({
        id: payload.data?.notification_id || Date.now(),
        title: payload.notification.title,
        body: payload.notification.body,
        created_at: 'Just now'
    });

    const container = document.getElementById('notifications-container');
    if (container) {
        container.insertAdjacentHTML('afterbegin', notificationHtml);
        updateNotificationCounts(1);
    }
}

function createNotificationElement(notification) {
    return `
        <div class="d-flex flex-stack py-4" id="notification-${notification.id}">
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
                    <a href="#" 
                       class="fs-6 text-gray-800 text-hover-primary fw-bold" 
                       onclick="markAsRead(${notification.id}); event.preventDefault();">
                       ${notification.title}
                    </a>
                    <div class="text-gray-400 fs-7">${notification.body}</div>
                    <div class="text-gray-400 fs-7">${notification.created_at}</div>
                </div>
            </div>
        </div>
    `;
}

function updateNotificationCounts(increment) {
    const badge = document.getElementById('notification-badge');
    const countElement = document.getElementById('notification-count');
    
    if (badge) {
        let count = parseInt(badge.textContent || '0') + increment;
        if (count > 0) {
            badge.textContent = count;
            badge.style.display = 'inline';
        } else {
            badge.style.display = 'none';
        }
    }
    
    if (countElement) {
        let total = parseInt(countElement.textContent) + increment;
        countElement.textContent = `${total} reports`;
    }
}

async function updateFcmToken(token) {
    try {
        const response = await fetch('/api/update-fcm-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ token })
        });
        
        const data = await response.json();
        console.log('Token updated successfully:', data);
    } catch (error) {
        console.error('Error updating token:', error);
    }
}

function markAsRead(notificationId) {
    fetch(`/notifications/read/${notificationId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notificationElement = document.getElementById(`notification-${notificationId}`);
            if (!notificationElement.querySelector('.badge')) {
                const readLabel = document.createElement('span');
                readLabel.className = 'badge badge-light fs-8 ms-2';
                readLabel.innerText = 'Read';
                notificationElement.appendChild(readLabel);
            }
            updateNotificationCounts(-1);
        }
    })
    .catch(error => console.error('Error marking notification as read:', error));
}
</script>
@endpush