
<!--begin::Footer-->
<footer class="footer text-center py-4">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center">
                    <div class="d-flex align-items-center mb-2">
                        <h3 style="color: rgb(184, 197, 197)" class="me-2">Development By
                            <img src="{{ asset('assets/footer_logo.png') }}" alt="Logo" class="footer-logo" style="height: 20px;" />
							All Rights Reserved
                        </h3>
                    </div>
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

		@yield('js')
	


		