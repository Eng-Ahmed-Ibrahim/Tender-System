<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	@include('admin.body.header')

	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Page bg image-->
			<style>body { background-image: url('assets/media/auth/bg10.jpeg'); } [data-bs-theme="dark"] body { background-image: url('assets/media/auth/bg10-dark.jpeg'); }</style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Aside-->
				<div class="d-flex flex-lg-row-fluid">
					<!--begin::Content-->
					<div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
						<!--begin::Image-->
						@php
        $configuration = \App\Models\Configuration::first();
        @endphp						<img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{ asset('storage/' . $configuration->logo) }}" alt="" />
						<img class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src="{{ asset('storage/' . $configuration->logo) }}" alt="" />						
						<!--end::Text-->
					</div>
					<!--end::Content-->
				</div>
				<!--begin::Aside-->
				<!--begin::Body-->
				<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
					<!--begin::Wrapper-->
					<div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
						<!--begin::Content-->
						<div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
							<!--begin::Wrapper-->
							<div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
								<!--begin::Form-->
                                <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" method="POST" action="{{ route('register') }}">
    @csrf

    <!--begin::Heading-->
    <div class="text-center mb-11">
        <!--begin::Title-->
        <h1 class="text-dark fw-bolder mb-3">Sign Up</h1>
        <!--end::Title-->
        <!--begin::Subtitle-->
        <div class="text-gray-500 fw-semibold fs-6">Join Our Community</div>
        <!--end::Subtitle-->
    </div>
    <!--begin::Heading-->

    <!--begin::Login options-->
    
    <!--end::Login options-->

    <!--begin::Separator-->
    <div class="separator separator-content my-14">
        <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
    </div>
    <!--end::Separator-->

    <!--begin::Input group-->
    <div class="fv-row mb-8">
        <!--begin::Name-->
        <input type="text" placeholder="Name" name="name" id="name" :value="old('name')" required autofocus autocomplete="name" class="form-control bg-transparent" />
        <!--end::Name-->
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
    <!--end::Input group-->

    <!--begin::Input group-->
    <div class="fv-row mb-8">
        <!--begin::Email-->
        <input type="email" placeholder="Email" name="email" id="email" :value="old('email')" required autocomplete="username" class="form-control bg-transparent" />
        <!--end::Email-->
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
    <!--end::Input group-->

    <!--begin::Input group-->
    <div class="fv-row mb-8">
        <!--begin::Password-->
        <input type="password" placeholder="Password" name="password" id="password" required autocomplete="new-password" class="form-control bg-transparent" />
        <!--end::Password-->
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>
    <!--end::Input group-->

    <!--begin::Input group-->
    <div class="fv-row mb-8">
        <!--begin::Password Confirmation-->
        <input type="password" placeholder="Confirm Password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password" class="form-control bg-transparent" />
        <!--end::Password Confirmation-->
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>
    <!--end::Input group-->

    <!--begin::Submit button-->
    <div class="d-grid mb-10">
        <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
            <!--begin::Indicator label-->
            <span class="indicator-label">Sign Up</span>
            <!--end::Indicator label-->
            <!--begin::Indicator progress-->
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
            <!--end::Indicator progress-->
        </button>
    </div>
    <!--end::Submit button-->

    <!--begin::Sign up-->
    <div class="text-gray-500 text-center fw-semibold fs-6">Already registered?
        <a href="{{ route('login') }}" class="link-primary">Sign in</a>
    </div>
    <!--end::Sign up-->
</form>


								<!--end::Form-->
							</div>
							<!--end::Wrapper-->
							<!--begin::Footer-->
							<footer class="footer text-center py-4">
    <div class="container">
        <div class="d-flex flex-column align-items-center">
            <div class="d-flex align-items-center mb-2">
                <h3 style="color:rgb(184, 197, 197)"class="me-2">Development By
                <img src="{{asset('assets/footer_logo.png')}}" alt="Logo" class="footer-logo" style="height: 20px;" />

				All Right Reserved
				</h3>

            </div>
        </div>
    </div>
</footer>
							<!--end::Footer-->
						</div>
						<!--end::Content-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="assets/js/custom/authentication/sign-in/general.js"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>