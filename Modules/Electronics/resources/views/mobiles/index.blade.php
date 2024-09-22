@extends('admin.index')

@section('content')
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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('Mobiles') }}
                    </h1>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Category-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Add customer-->
                            <!--end::Add customer-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Storage') }}</th>
                                    <th>{{ __('RAM') }}</th>
                                    <th>{{ __('Display Size') }}</th>
                                    <th>{{ __('SIM Number') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Images') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mobiles as $index => $mobile)
                                    @foreach($mobile->phoneFeatures as $feature)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ __($mobile->title) }}</td>
                                            <td>{{ __($mobile->category->title) }}</td> <!-- Assuming Mobile model has a category relationship -->
                                            <td>{{ __($feature->storage) }}</td>
                                            <td>{{ __($feature->ram) }}</td>
                                            <td>{{ __($feature->disply_size) }}</td>
                                            <td>{{ __($feature->sim_no) }}</td>
                                            <td>{{ __($feature->status) }}</td>
                                            <td>{{ __($feature->description) }}</td>
                                            <td>
                                                @foreach($mobile->images as $image)
                                                    <img src="{{ $image->photo_path }}" alt="{{ __('Mobile Image') }}" style="width: 50px; height: auto;">
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Category-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>
@endsection
