@extends('admin.index')

@section('content')
<style>
    textarea {
        height: 200px;
    }
    .invalid-feedback {
        display: none;
        color: #f1416c;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    .is-invalid {
        border-color: #f1416c !important;
    }
</style>

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Navbar-->
                <!--end::Navbar-->
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title fs-3 fw-bold">{{ __('Configurations') }}</div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Form-->
                    <form id="kt_project_settings_form" class="form" action="{{ route('configurations.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body p-9">
                            <!-- Alert for validation errors -->
                            <div class="alert alert-danger d-none" id="validation-errors"></div>

                            <!-- Logo Upload Section -->
                            <div class="row mb-5">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Logo') }}</div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('{{ $configuration->logo ? asset('storage/' . $configuration->logo) : 'assets/media/svg/avatars/blank.svg' }}')">
                                        <div class="image-input-wrapper w-125px h-125px bgi-position-center" style="background-size: 75%; background-image: url('{{ $configuration->logo ? asset('storage/' . $configuration->logo) : 'assets/media/svg/brand-logos/volicity-9.svg' }}')"></div>
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="{{ __('Change logo') }}">
                                            <i class="ki-duotone ki-pencil fs-7">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="logo_remove" />
                                        </label>
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="{{ __('Cancel logo') }}">
                                            <i class="ki-duotone ki-cross fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="{{ __('Remove logo') }}">
                                            <i class="ki-duotone ki-cross fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                    </div>
                                    <div class="form-text">{{ __('Allowed file types: png, jpg, jpeg.') }}</div>
                                </div>
                            </div>

                            <!-- WhatsApp Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('WhatsApp') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <input type="text" class="form-control form-control-solid" id="whatsApp" name="whatsApp" value="{{ old('whatsApp', $configuration->whatsApp) }}" />
                                    <div class="invalid-feedback" id="whatsApp-error">Please enter English characters only.</div>
                                </div>
                            </div>

                            <!-- Phone Number Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Phone Number') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <input type="text" class="form-control form-control-solid" id="phone_number" name="phone_number" value="{{ old('phone_number', $configuration->phone_number) }}" />
                                    <div class="invalid-feedback" id="phone_number-error">Please enter English characters only.</div>
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Email') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <input type="email" class="form-control form-control-solid" id="email" name="email" value="{{ old('email', $configuration->email) }}" />
                                    <div class="invalid-feedback" id="email-error">Please enter a valid email address.</div>
                                </div>
                            </div>

                            <!-- Owner Name Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Owner Name') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <input type="text" class="form-control form-control-solid" id="owner_name" name="owner_name" value="{{ old('owner_name', $configuration->owner_name) }}" />
                                    <div class="invalid-feedback" id="owner_name-error">Please enter English characters only.</div>
                                </div>
                            </div>

                            <!-- Terms and Conditions (English) Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Terms and Conditions (English)') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <textarea class="form-control form-control-solid" id="terms_condition_en" name="terms_condition_en">{{ old('terms_condition_en', $configuration->terms_condition_en) }}</textarea>
                                    <div class="invalid-feedback" id="terms_condition_en-error">Please enter English characters only.</div>
                                </div>
                            </div>

                            <!-- Terms and Conditions (Arabic) Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Terms and Conditions (Arabic)') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <textarea class="form-control form-control-solid" id="terms_condition_ar" name="terms_condition_ar" dir="rtl">{{ old('terms_condition_ar', $configuration->terms_condition_ar) }}</textarea>
                                    <div class="invalid-feedback" id="terms_condition_ar-error">Please enter Arabic characters only.</div>
                                </div>
                            </div>

                            <!-- Refund Policy (English) Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Refund Policy (English)') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <textarea class="form-control form-control-solid" id="refund_policy_en" name="refund_policy_en">{{ old('refund_policy_en', $configuration->refund_policy_en) }}</textarea>
                                    <div class="invalid-feedback" id="refund_policy_en-error">Please enter English characters only.</div>
                                </div>
                            </div>

                            <!-- Refund Policy (Arabic) Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Refund Policy (Arabic)') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <textarea class="form-control form-control-solid" id="refund_policy_ar" name="refund_policy_ar" dir="rtl">{{ old('refund_policy_ar', $configuration->refund_policy_ar) }}</textarea>
                                    <div class="invalid-feedback" id="refund_policy_ar-error">Please enter Arabic characters only.</div>
                                </div>
                            </div>

                            <!-- Privacy Policy (English) Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Privacy Policy (English)') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <textarea class="form-control form-control-solid" id="privacy_policy_en" name="privacy_policy_en">{{ old('privacy_policy_en', $configuration->privacy_policy_en) }}</textarea>
                                    <div class="invalid-feedback" id="privacy_policy_en-error">Please enter English characters only.</div>
                                </div>
                            </div>

                            <!-- Privacy Policy (Arabic) Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Privacy Policy (Arabic)') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <textarea class="form-control form-control-solid" id="privacy_policy_ar" name="privacy_policy_ar" dir="rtl">{{ old('privacy_policy_ar', $configuration->privacy_policy_ar) }}</textarea>
                                    <div class="invalid-feedback" id="privacy_policy_ar-error">Please enter Arabic characters only.</div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light me-3">{{ __('Discard') }}</button>
                                <button type="submit" id="submit-btn" class="btn btn-secondary">{{ __('Save Changes') }}</button>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Regular expressions for validation
    const arabicRegex = /^[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\s.,!?@#$%^&*()_\-+=[\]{}|:;<>'"\/\\]+$/;
    const englishRegex = /^[A-Za-z0-9\s.,!?@#$%^&*()_\-+=[\]{}|:;<>'"\/\\]+$/;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const phoneRegex = /^[0-9+\-\s()]+$/;
    
    // Function to validate input based on language
    function validateLanguage(field, regex, errorElementId) {
        const value = $(field).val();
        const errorElement = $(`#${errorElementId}`);
        
        if (value && !regex.test(value)) {
            $(field).addClass('is-invalid');
            errorElement.show();
            return false;
        } else {
            $(field).removeClass('is-invalid');
            errorElement.hide();
            return true;
        }
    }
    
    // Real-time validation for Arabic fields
    $('#terms_condition_ar, #refund_policy_ar, #privacy_policy_ar').on('input', function() {
        const fieldId = $(this).attr('id');
        validateLanguage(this, arabicRegex, `${fieldId}-error`);
    });
    
    // Real-time validation for English fields
    $('#owner_name, #terms_condition_en, #refund_policy_en, #privacy_policy_en').on('input', function() {
        const fieldId = $(this).attr('id');
        validateLanguage(this, englishRegex, `${fieldId}-error`);
    });
    
    // Special validation for phone fields
    $('#whatsApp, #phone_number').on('input', function() {
        const fieldId = $(this).attr('id');
        validateLanguage(this, phoneRegex, `${fieldId}-error`);
    });
    
    // Special validation for email field
    $('#email').on('input', function() {
        const fieldId = $(this).attr('id');
        validateLanguage(this, emailRegex, `${fieldId}-error`);
    });
    
    // Form submission validation
    $('#kt_project_settings_form').on('submit', function(e) {
        let isValid = true;
        let errorMessages = [];
        
        // Validate Arabic fields
        const arabicFields = ['terms_condition_ar', 'refund_policy_ar', 'privacy_policy_ar'];
        arabicFields.forEach(field => {
            if (!validateLanguage(`#${field}`, arabicRegex, `${field}-error`)) {
                isValid = false;
                errorMessages.push(`${field.replace(/_/g, ' ').toUpperCase()}: Please enter Arabic characters only.`);
            }
        });
        
        // Validate English fields
        const englishFields = ['owner_name', 'terms_condition_en', 'refund_policy_en', 'privacy_policy_en'];
        englishFields.forEach(field => {
            if (!validateLanguage(`#${field}`, englishRegex, `${field}-error`)) {
                isValid = false;
                errorMessages.push(`${field.replace(/_/g, ' ').toUpperCase()}: Please enter English characters only.`);
            }
        });
        
        // Validate Phone fields
        const phoneFields = ['whatsApp', 'phone_number'];
        phoneFields.forEach(field => {
            if (!validateLanguage(`#${field}`, phoneRegex, `${field}-error`)) {
                isValid = false;
                errorMessages.push(`${field.replace(/_/g, ' ').toUpperCase()}: Please enter a valid phone number.`);
            }
        });
        
        // Validate Email field
        if (!validateLanguage('#email', emailRegex, 'email-error')) {
            isValid = false;
            errorMessages.push('EMAIL: Please enter a valid email address.');
        }
        
        // If validation fails, show errors and prevent form submission
        if (!isValid) {
            e.preventDefault();
            
            // Display all error messages
            const errorContainer = $('#validation-errors');
            errorContainer.html('');
            errorMessages.forEach(message => {
                errorContainer.append(`<div>${message}</div>`);
            });
            errorContainer.removeClass('d-none');
            
            // Scroll to the top of the form to see errors
            $('html, body').animate({
                scrollTop: errorContainer.offset().top - 100
            }, 200);
        }
    });
});
</script>
@endsection