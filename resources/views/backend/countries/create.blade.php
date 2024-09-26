@extends('admin.index')

@section('content')

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
                <div class="card-title fs-3 fw-bold">{{ __('Countries') }}</div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Form-->
            <form id="kt_project_settings_form" class="form" action="{{ route('countries.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-9">
                    <!-- Country Name Field -->
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Country Name') }}</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <input type="text" id="countryName" class="form-control form-control-solid" name="name" required>
                        </div>
                    </div>
                    
                    <!-- Country Code Field -->
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">{{ __('Code') }}</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <input type="text" id="countryCode" class="form-control form-control-solid" name="code" required>
                        </div>
                    </div>
        
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-light btn-active-light-primary me-2">{{ __('Discard') }}</button>
                    <button type="submit" class="btn btn-secondary" id="kt_project_settings_submit">{{ __('Save Changes') }}</button>
                </div>
            </form>
            <!--end:Form-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Content container-->
</div>

@endsection
