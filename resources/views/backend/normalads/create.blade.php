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

           
                                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{__('Add Normal Ads')}}</h1>
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
                <!--begin::Form-->
                <form id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" action="{{ route('normalads.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10" style="padding-top:27px;">
                        <!--begin::Thumbnail settings-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif                                <div class="card-title">
                                    <h2>{{ __('thumbnail') }}</h2>
                                </div>
                                <!--end::Card title-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body text-center pt-0">
                                <!--begin::Image input-->
                                <!--begin::Image input placeholder-->
                                <style>.image-input-placeholder { background-image: url('assets/media/svg/files/blank-image.svg'); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }</style>
                                <!--end::Image input placeholder-->
                                <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-150px h-150px"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="{{ __('change_avatar') }}">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="avatar_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="{{ __('cancel_avatar') }}">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="{{ __('remove_avatar') }}">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">{{ __('thumbnail_description') }}</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Thumbnail settings-->
                        <!--begin::Status-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <h2>{{ __('status') }}</h2>
                                </div>
                                <!--end::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_add_product_status"></div>
                                </div>
                                <!--begin::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Select2-->
                                <select name="is_active" class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="{{ __('select_option') }}" id="kt_ecommerce_add_product_status_select">
                                    <option value="1" selected="selected">{{ __('published') }}</option>
                                    <option value="0">{{ __('draft') }}</option>
                                </select>
                                <!--end::Select2-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">{{ __('select_publishing_date') }}</div>
                                <!--end::Description-->
                                <!--begin::Datepicker-->
                                <div class="d-none mt-10">
                                    <label for="kt_ecommerce_add_product_status_datepicker" class="form-label">{{ __('select_publishing_date') }}</label>
                                    <input class="form-control" id="kt_ecommerce_add_product_status_datepicker" placeholder="{{ __('select_publishing_date') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{ __('categories') }}</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                @php
                                $categories = \App\Models\Category::where('parent_id',$cat_id)->get();
                                @endphp
                                <select class="form-select mb-2" name="cat_id" data-control="select2" data-hide-search="true" data-placeholder="{{ __('select_option') }}" id="kt_ecommerce_add_product_store_template">
                                    <option value="default" selected="selected">{{ __('select') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    
                                    @endforeach
                                </select>
                                <div class="text-muted fs-7">{{ __('select_option') }}</div>
                            </div>
                        </div>
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{ __('customer') }}</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Select store template-->
                                <label for="kt_ecommerce_add_product_store_template" class="form-label">{{ __('select') }}</label>
                                @php
                                $customers = \App\Models\Customers::all();
                                @endphp
                                <select class="form-select mb-2" name="customer_id" data-control="select2" data-hide-search="true" data-placeholder="{{ __('select_option') }}" id="kt_ecommerce_add_product_store_template">
                                    <option></option>
                                    <option value="default" selected="selected">{{ __('select') }}</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                          
                                <div class="text-muted fs-7">{{ __('select_option') }}</div>
                            </div>
                        </div>
                    </div>
               
                    <div class="d-flex flex-column flex-lg-row w-100">
                        <!--begin::Main column-->
                        <div class="w-100 w-lg-700px">
                            <div class="card card-flush py-4">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h2>{{ __('product_name') }}</h2>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                         
                                <div class="card-body pt-0">
                                    <!--begin::Input group-->
                                    <div class="mb-7">
                                        <label class="form-label">{{ __('product_name') }}</label>
                                        <input type="text" name="title" class="form-control" placeholder="{{ __('product_name_description') }}" />
                                        <div class="text-muted fs-7">{{ __('product_name') }}</div>
                                    </div>
                                          <div class="mb-7">
                                        <label class="form-label">{{ __('Address') }}</label>
                                        <input type="text" name="address" class="form-control" placeholder="{{ __('product_name_description') }}" />
                                        <div class="text-muted fs-7">{{ __('Address') }}</div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-7">
                                        <label class="form-label">{{ __('description') }}</label>
                                        <textarea name="description" class="form-control" placeholder="{{ __('description_description') }}"></textarea>
                                        <div class="text-muted fs-7">{{ __('description_description') }}</div>
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Product details-->
                            <!--begin::Media-->
                            <div class="card card-flush py-4">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>{{ __('media') }}</h2>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::File input-->
                                    <div class="mb-7">
                                        <label class="form-label">{{ __('set_product_media_gallery') }}</label>
                                        <input type="file" name="images[]" multiple class="form-control" />
                                        <div class="text-muted fs-7">{{ __('set_product_media_gallery') }}</div>
                                    </div>
                                    <!--end::File input-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Media-->
                            <!--begin::Price-->
                            <div class="card card-flush py-4">
                                <!--begin::Card header-->
                                <div class="card-header">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>{{ __('base_price') }}</h2>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::Input group-->
                                    <div class="mb-7">
                                        <label class="form-label">{{ __('base_price') }}</label>
                                        <input type="number" name="price" class="form-control" placeholder="{{ __('base_price') }}" />
                                        <div class="text-muted fs-7">{{ __('base_price') }}</div>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                               
                                    <!--end::Input group-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-secondary">{{ __('save_changes') }}</button>
                            </div>                      
                        
                        <!--end::Main column-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Actions-->
              
                    <!--end::Actions-->
                </form>
                
                <!--end::Form-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
    <!--begin::Footer-->

    <!--end::Footer-->
</div>



@endsection



@section('js')

<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js')}}"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/save-product.js')}}"></script>


@endsection