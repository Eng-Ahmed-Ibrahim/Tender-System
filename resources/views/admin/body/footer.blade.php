</div>
</div>
</div>
<footer class="footer text-center py-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center">
                    <div class="d-flex align-items-center mb-2">
                        <h3 style="color: rgb(184, 197, 197); padding-left:130px;" class="me-2">Development By
                            <img src="{{ asset('assets/footer_logo.png') }}" alt="Logo" class="footer-logo" style="height: 20px;" />
							All Rights Reserved
                        </h3>
                    </div>
                </div>
        </div>
    </div>
</footer>
<!--end::Footer-->

<script>var hostUrl = "assets/";</script>
<script>var hostUrl = "{{ asset('assets/') }}";</script>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>


<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>


    @stack('scripts')
        <!-- Your content here -->
    
        <script type="module">
            import { initializeApp } from "https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js";
            import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging.js";
    
            const firebaseConfig = {
                apiKey: "AIzaSyAb8ObRWGuNLq-N0B4k3cLKuoi_a-WrtSU",
                authDomain: "magg-2425d.firebaseapp.com",
                projectId: "magg-2425d",
                storageBucket: "magg-2425d.appspot.com",
                messagingSenderId: "685388698763",
                appId: "1:685388698763:web:9229774ceb10a0acf0b08e",
                measurementId: "G-YCFBT52LEP"
            };
    
            const app = initializeApp(firebaseConfig);
            const messaging = getMessaging(app);
    
            // Register the service worker
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/firebase-messaging-sw.js')
                    .then((registration) => {
                        console.log('Service Worker registered with scope:', registration.scope);
                    })
                    .catch((err) => {
                        console.log('Service Worker registration failed:', err);
                    });
            }
    
            getToken(messaging, { vapidKey: 'BCBSC5ESmnD0vJOqKcz4Lg_kewpTLrC0m9iI4uxgNdxwplx6ZvFm1NittJQC76JbKzHozO9MWhYvXEyRAEb3QL8' })
                .then((currentToken) => {
                    if (currentToken) {
                        console.log(currentToken);
                    } else {
                        console.log('No registration token available. Request permission to generate one.');
                    }
                })
                .catch((err) => {
                    console.log('An error occurred while retrieving token. ', err);
                });
        </script>
    </body>
    </html>
    
</body>
</html>

		