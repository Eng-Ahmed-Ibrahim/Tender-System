// firebase-messaging-sw.js
importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging.js');

const firebaseConfig = {
    apiKey: "AIzaSyAb8ObRWGuNLq-N0B4k3cLKuoi_a-WrtSU",
    authDomain: "magg-2425d.firebaseapp.com",
    projectId: "magg-2425d",
    storageBucket: "magg-2425d.appspot.com",
    messagingSenderId: "685388698763",
    appId: "1:685388698763:web:9229774ceb10a0acf0b08e",
    measurementId: "G-YCFBT52LEP"
};

// Initialize the Firebase app in the service worker
firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

// Handle background messages
messaging.onBackgroundMessage((payload) => {
    console.log('Received background message ', payload);
    // Customize notification here
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: '/firebase-logo.png' // Customize your icon
    };

    return self.registration.showNotification(notificationTitle,
        notificationOptions);
});
