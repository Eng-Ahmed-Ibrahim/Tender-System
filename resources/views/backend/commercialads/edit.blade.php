@extends('admin.index')
@section('content')

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Edit Product</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">eCommerce</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Catalog</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('commercialads.index') }}" class="btn btn-sm fw-bold btn-primary">Back to list</a>
                </div>
            </div>
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <form id="kt_ecommerce_edit_product_form" class="form d-flex flex-column flex-lg-row" action="{{ route('commercialads.update', $model->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10" style="padding-top:27px;">
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Thumbnail</h2>
                                </div>
                            </div>
                            <div class="card-body text-center pt-0">
                                <style>.image-input-placeholder { background-image: url('assets/media/svg/files/blank-image.svg'); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }</style>
                                <div class="image-input image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                    <div class="image-input-wrapper w-150px h-150px" style="background-image: url('{{ $model->photo }}');"></div>
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                        <i class="ki-duotone ki-pencil fs-7"></i>
                                        <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="avatar_remove" />
                                    </label>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                        <i class="ki-duotone ki-cross fs-2"></i>
                                    </span>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                        <i class="ki-duotone ki-cross fs-2"></i>
                                    </span>
                                </div>
                                <div class="text-muted fs-7">Set the product thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted</div>
                            </div>
                        </div>
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Status</h2>
                                </div>
                                <div class="card-toolbar">
                                    <div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_edit_product_status"></div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <select name="is_active" class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Select an option" id="kt_ecommerce_edit_product_status_select">
                                    <option value="1" {{ $model->is_active == 1 ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ $model->is_active == 0 ? 'selected' : '' }}>Draft</option>
                                </select>
                                <div class="text-muted fs-7">Set the product status.</div>
                                <div class="d-none mt-10">
                                    <label for="kt_ecommerce_edit_product_status_datepicker" class="form-label">Select publishing date and time</label>
                                    <input class="form-control" id="kt_ecommerce_edit_product_status_datepicker" placeholder="Pick date & time" />
                                </div>
                            </div>
                        </div>
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Customer</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <label for="kt_ecommerce_edit_product_store_template" class="form-label">Select a product template</label>
                                @php
                                    $customers = \App\Models\Customers::get();
                                @endphp
                                <select name="customer_id" class="form-select mb-2" data-control="select2" data-placeholder="Select an option">
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $model->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-muted fs-7">Customers are the ones who subscribe to your commercial.</div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="kt_ecommerce_edit_product_general" role="tab-panel">
                                <div class="d-flex flex-column gap-7 gap-lg-10">
                                    <div class="card card-flush py-4">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>General</h2>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="mb-10 fv-row">
                                                <label class="required form-label">Name (EN)</label>
                                                <input type="text" name="name" class="form-control mb-2" placeholder="Product name" value="{{ old('title', $model->title) }}" />
                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>
                                            </div>
                                        
                                            <div>
                                                <label class="form-label">Description (EN)</label>
                                                <textarea name="description" class="form-control">{{ old('description', $model->description) }}</textarea>
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('commercialads.index') }}" id="kt_ecommerce_edit_product_cancel" class="btn btn-light me-5">Cancel</a>
                                <button type="submit" id="kt_ecommerce_edit_product_submit" class="btn btn-primary">
                                    <span class="indicator-label">Save Changes</span>
                                    <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>

@endsection
