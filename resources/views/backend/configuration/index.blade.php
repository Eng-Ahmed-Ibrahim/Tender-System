@extends('admin.index')

@section('content')
<style>
    textarea {
        height: 200px;
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
                                    <input type="text" class="form-control form-control-solid" name="whatsApp" value="{{ old('whatsApp', $configuration->whatsApp) }}" />
                                </div>
                            </div>

                            <!-- Phone Number Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Phone Number') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <input type="text" class="form-control form-control-solid" name="phone_number" value="{{ old('phone_number', $configuration->phone_number) }}" />
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Email') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <input type="email" class="form-control form-control-solid" name="email" value="{{ old('email', $configuration->email) }}" />
                                </div>
                            </div>

                            <!-- Owner Name Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Owner Name') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <input type="text" class="form-control form-control-solid" name="owner_name" value="{{ old('owner_name', $configuration->owner_name) }}" />
                                </div>
                            </div>

                            <!-- Terms and Conditions (English) Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Terms and Conditions (English)') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <textarea class="form-control form-control-solid" name="terms_condition_en">{{ old('terms_condition_en', $configuration->terms_condition_en) }}</textarea>
                                </div>
                            </div>

                            <!-- Terms and Conditions (Arabic) Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Terms and Conditions (Arabic)') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <textarea class="form-control form-control-solid" name="terms_condition_ar">{{ old('terms_condition_ar', $configuration->terms_condition_ar) }}</textarea>
                                </div>
                            </div>

                            <!-- Refund Policy (English) Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Refund Policy (English)') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <textarea class="form-control form-control-solid" name="refund_policy_en">{{ old('refund_policy_en', $configuration->refund_policy_en) }}</textarea>
                                </div>
                            </div>

                            <!-- Refund Policy (Arabic) Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Refund Policy (Arabic)') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <textarea class="form-control form-control-solid" name="refund_policy_ar">{{ old('refund_policy_ar', $configuration->refund_policy_ar) }}</textarea>
                                </div>
                            </div>

                            <!-- Privacy Policy (English) Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Privacy Policy (English)') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <textarea class="form-control form-control-solid" name="privacy_policy_en">{{ old('privacy_policy_en', $configuration->privacy_policy_en) }}</textarea>
                                </div>
                            </div>

                            <!-- Privacy Policy (Arabic) Field -->
                            <div class="row mb-8">
                                <div class="col-xl-3">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Privacy Policy (Arabic)') }}</div>
                                </div>
                                <div class="col-xl-9 fv-row">
                                    <textarea class="form-control form-control-solid" name="privacy_policy_ar">{{ old('privacy_policy_ar', $configuration->privacy_policy_ar) }}</textarea>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light me-3">{{ __('Discard') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
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
@endsection
