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
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Product Form</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">eCommerce</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Catalog</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Filter menu-->
                    <div class="m-0">
                        <!--begin::Menu toggle-->
                        <a href="#" class="btn btn-sm btn-flex btn-secondary fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>Filter</a>
                        <!--end::Menu toggle-->
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_64b77612a0893">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-dark fw-bold">Filter Options</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Menu separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Menu separator-->
                            <!--begin::Form-->
                            <div class="px-7 py-5">
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fw-semibold">Status:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div>
                                        <select class="form-select form-select-solid" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_64b77612a0893" data-allow-clear="true">
                                            <option></option>
                                            <option value="1">Approved</option>
                                            <option value="2">Pending</option>
                                            <option value="2">In Process</option>
                                            <option value="2">Rejected</option>
                                        </select>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fw-semibold">Member Type:</label>
                                    <!--end::Label-->
                                    <!--begin::Options-->
                                    <div class="d-flex">
                                        <!--begin::Options-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                            <input class="form-check-input" type="checkbox" value="1" />
                                            <span class="form-check-label">Author</span>
                                        </label>
                                        <!--end::Options-->
                                        <!--begin::Options-->
                                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="2" checked="checked" />
                                            <span class="form-check-label">Customer</span>
                                        </label>
                                        <!--end::Options-->
                                    </div>
                                    <!--end::Options-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="form-label fw-semibold">Notifications:</label>
                                    <!--end::Label-->
                                    <!--begin::Switch-->
                                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked" />
                                        <label class="form-check-label">Enabled</label>
                                    </div>
                                    <!--end::Switch-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                                    <button type="submit" class="btn btn-sm btn-secondary" data-kt-menu-dismiss="true">Apply</button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Form-->
                        </div>
                        <!--end::Menu 1-->
                    </div>
                    <!--end::Filter menu-->
                    <!--begin::Secondary button-->
                    <!--end::Secondary button-->
                    <!--begin::Primary button-->
                    <a href="#" class="btn btn-sm fw-bold btn-secondary" data-bs-toggle="model" data-bs-target="#kt_model_create_app">Create</a>
                    <!--end::Primary button-->
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
                <!--begin::Form-->
                <form id="kt_ecommerce_edit_product_form" class="form d-flex flex-column flex-lg-row" action="{{ route('normalads.update', $model->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10" style="padding-top:27px;">
                        <!-- Thumbnail settings -->
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Thumbnail</h2>
                                </div>
                            </div>
                            <div class="card-body text-center pt-0">
                                <style>.image-input-placeholder { background-image: url('assets/media/svg/files/blank-image.svg'); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }</style>
                                <div class="image-input image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                    <div class="image-input-wrapper w-150px h-150px" style="background-image: url('{{ asset('storage/'.$model->photo) }}');"></div>
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                        <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>
                                        <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="avatar_remove" />
                                    </label>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                        <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                                    </span>
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                        <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                                    </span>
                                </div>
                                <div class="text-muted fs-7">Set the product thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted</div>
                            </div>
                        </div>
                        <!-- Status -->
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
                                    <option value="1" {{ $model->is_active ? 'selected' : '' }}>Published</option>
                                    <option value="0" {{ !$model->is_active ? 'selected' : '' }}>Draft</option>
                                </select>
                                <div class="text-muted fs-7">Set the product status.</div>
                            </div>
                        </div>
                        <!-- Categories -->
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Categories</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                @php
                                $categories = \App\Models\Category::with('children')->whereNull('parent_id')->get();
                                @endphp
                                <select class="form-select mb-2" name="cat_id" data-control="select2" data-hide-search="true" data-placeholder="Select an option" id="kt_ecommerce_edit_product_store_template">
                                    <option></option>
                                    <option value="default" {{ is_null($model->category_id) ? 'selected' : '' }}>Select</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $model->category_id ? 'selected' : '' }} disabled>{{ $category->title }}</option>
                                        @foreach($category->children as $child)
                                            <option value="{{ $child->id }}" {{ $child->id == $model->category_id ? 'selected' : '' }}>— {{ $child->title }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                                <div class="text-muted fs-7">Assign a category to the product.</div>
                            </div>
                        </div>
                        <!-- Customer -->
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Customer</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                @php
                                $customers = \App\Models\Customers::get();
                                @endphp
                                <select class="form-select mb-2" name="customer_id" data-control="select2" data-hide-search="true" data-placeholder="Select an option" id="kt_ecommerce_edit_product_customer">
                                    <option></option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $customer->id == $model->customer_id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Main column -->
                    <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                        <!-- General options -->
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>General</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Product Name</label>
                                    <input type="text" name="title" class="form-control mb-2" placeholder="Product name" value="{{ $model->name }}" />
                                    <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>
                                </div>
                                <div>
                                    <label class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4">{{ $model->description }}</textarea>
                                    <div class="text-muted fs-7">Set a description for the product for better visibility.</div>
                                </div>
                            </div>
                        </div>
                        <!-- Media -->
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Media</h2>
                                </div>
                            </div>
                            @if($model->images->count())
                            <div class="row">
                                @foreach($model->images as $image)
                                <div class="col-3 mb-2" id="image-container-{{ $image->id }}">
                                    <div class="image-input image-input-outline">
                                        <img src="{{ asset('storage/'.$image->image_path) }}" class="img-thumbnail" alt="Image" style="width: 100%; height: auto;">
                                        <button type="button" class="btn btn-warning btn-sm mt-1" data-image-id="{{ $image->id }}" data-action="mark-remove">Mark for Removal</button>
                                        <input type="hidden" name="remove_images[]" value="" id="remove-image-{{ $image->id }}">
                                    </div>
                                </div>
                                
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        document.querySelectorAll('[data-action="mark-remove"], [data-action="undo-remove"]').forEach(function(button) {
                                            button.addEventListener('click', function() {
                                                var imageId = this.getAttribute('data-image-id');
                                                var hiddenInput = document.getElementById('remove-image-' + imageId);
                                                var imageContainer = document.getElementById('image-container-' + imageId);
                                
                                                if (this.getAttribute('data-action') === 'mark-remove') {
                                                    if (confirm('Are you sure you want to mark this image for removal?')) {
                                                        hiddenInput.value = imageId;  // Mark the image for removal
                                                        this.textContent = 'Undo Remove';  // Change button text
                                                        this.classList.remove('btn-warning');
                                                        this.classList.add('btn-secondary');
                                                        this.setAttribute('data-action', 'undo-remove');  // Update action
                                                        imageContainer.classList.add('marked-for-removal'); // Optionally add a visual cue
                                                    }
                                                } else if (this.getAttribute('data-action') === 'undo-remove') {
                                                    hiddenInput.value = '';  // Unmark the image for removal
                                                    this.textContent = 'Mark for Removal';  // Revert button text
                                                    this.classList.remove('btn-secondary');
                                                    this.classList.add('btn-warning');
                                                    this.setAttribute('data-action', 'mark-remove');  // Update action
                                                    imageContainer.classList.remove('marked-for-removal'); // Remove visual cue
                                                }
                                            });
                                        });
                                    });
                                </script>
                                
                                <style>
                                    /* Optionally style images that are marked for removal */
                                    .marked-for-removal {
                                        opacity: 0.5;
                                    }
                                </style>
                                
                                
                                @endforeach
                            </div>
                        @else
                            <p style="padding-left: 20px;">No images uploaded.</p>

                        @endif
                        <input style="padding-left: 20px;" type="file" name="images[]" multiple>

                        </div>
                        <!-- Pricing -->
                        <div class="card card-flush py-4">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Pricing</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Base Price</label>
                                    <input type="text" name="price" class="form-control mb-2" placeholder="Product price" value="{{ $model->price }}" />
                                </div>
                               
                        </div>
                    </div>
                    <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-secondary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
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