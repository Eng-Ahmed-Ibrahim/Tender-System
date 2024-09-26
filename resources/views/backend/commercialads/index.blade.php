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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{__('Commercial Ads')}}</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                  
                    <!--end::Breadcrumb-->
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!-- Filter menu -->
                    <div class="m-0">
                        <!-- Menu toggle -->
                        <a href="#" class="btn btn-sm btn-flex btn-secondary fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>{{__('Filter')}}
                        </a>
                        <!-- Menu content -->
                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true">
                            <!-- Header -->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-dark fw-bold">{{__('Filter Options')}}</div>
                            </div>
                            <!-- Separator -->
                            <div class="separator border-gray-200"></div>
                            <!-- Form -->
                            <div class="px-7 py-5">
                                <form action="{{ route('commercialads.index') }}" method="GET">
                                    <!-- Status Filter -->
                                    <div class="mb-10">
                                        <label class="form-label fw-semibold">Status:</label>
                                        <div>
                                            <select class="form-select form-select-solid" name="is_active"  data-placeholder="Select status" data-dropdown-parent="#kt_menu_64b776126c90a" data-allow-clear="true">
                                                <option value="">{{__('Select status')}}</option>
                                                <option value="1" {{ request()->input('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ request()->input('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Category Filter -->
                                    <div class="mb-10">
                                        <label class="form-label fw-semibold">{{__('Category')}}:</label>
                                        <div>
                                            <select class="form-select form-select-solid" name="category_id"  data-placeholder="Select category" data-dropdown-parent="#kt_menu_64b776126c90a" data-allow-clear="true">
                                                <option value="">{{__('Select category')}}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ request()->input('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Customer Filter -->
                               
                                    <!-- Actions -->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">{{__('Reset')}}</button>
                                        <button type="submit" class="btn btn-sm btn-secondary" data-kt-menu-dismiss="true">{{__('Apply')}}</button>
                                    </div>
                                </form>
                            </div>
                            <!-- End Form -->
                        </div>
                        <!-- End Menu content -->
                    </div>
                    <!-- End Filter menu -->
                </div>
                
                    <!--end::Filter menu-->
                    <!--begin::Secondary button-->
                    <!--end::Secondary button-->
                    <!--begin::Primary button-->
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
                                <form action="{{ route('commercialads.index') }}" method="GET">
                                    <input type="text" name="search" value="{{ request()->input('search') }}" class="form-control form-control-solid w-250px ps-12" placeholder="{{__('Search Ads')}}" />
                                </form>                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Add customer-->
                            <a href="{{ route('commercialads.create')}}" class="btn btn-secondary">{{__('Add Commercial Ads')}}</a>
                            <!--end::Add customer-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('Title')}}</th>
                                    <th>{{__('Description')}}</th>
                                    <th>{{__('Photo')}}</th>
                                    <th>{{__('Category')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commercialAds as $ad)
                                    <tr>
                                        <td>{{ __($ad->title) }}</td>
                                        <td>{{ __($ad->description) }}</td>
                                        <td>
                                            @if($ad->photo_path)
                                                <img src="{{ asset('storage/' . $ad->photo_path) }}" alt="{{ $ad->title }}" style="width: 100px; height: auto;">
                                            @else
                                            {{__(' No Photo')}}
                                            @endif
                                        </td>
                                        <td>{{ $ad->category->title ?? __('No Category') }}</td>
                                        <td>
                                            @if($ad->is_active)
                                                <span class="badge bg-success">{{__('Active')}}</span>
                                            @else
                                                <span class="badge bg-danger">{{__('Not Active')}}</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <!-- Actions Dropdown -->
                                            <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editAdModal-{{ $ad->id }}">{{ __('Edit') }}</a>                                            <form action="{{ route('commercialads.destroy', $ad->id)}}" method="POST" class="d-inline-block">
                                                <form action="{{ route('commercialads.destroy', $ad->id)}}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-secondary">{{__('Delete')}}</button>
                                                </form>

                                                <form action="{{ route('commercial.toggleStatus', $ad->id) }}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-secondary btn-sm">
                                                        @if($ad->is_active)
                                                        {{__('Mark as Not Active')}}
                                                        @else
                                                        {{__('Mark as Active')}}
                                                        @endif
                                                    </button>
                                                </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editAdModal-{{ $ad->id }}" tabindex="-1" aria-labelledby="editAdModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAdModalLabel">{{ __('Edit Commercial Ad') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('commercialads.update', $ad->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">{{__('Title')}}</label>
                        <input type="text" class="form-control" id="editTitle" name="title" value="{{ $ad->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">{{__('Description')}}</label>
                        <textarea class="form-control" id="editDescription" name="description">{{ $ad->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editPhone">{{__('Phone')}}:</label>
                        <input type="text" id="editPhone" name="phone" class="form-control" value="{{ $ad->phone }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="editWhatsapp">{{__('Whatsapp')}}:</label>
                        <input type="text" id="editWhatsapp" name="whatsapp" class="form-control" value="{{ $ad->whatsapp }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPhoto" class="form-label">{{__('Photo')}}</label>
                        <input type="file" class="form-control" id="editPhoto" name="photo">
                        @if($ad->photo)
                            <img src="{{ asset('storage/' . $ad->photo) }}" alt="Current Photo" class="mt-2" style="max-width: 200px;">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="category">{{__('Category')}}:</label>
                        <select id="cat_id" name="cat_id" class="form-control" required>
                            <option value="">{{__('select category')}}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $ad->cat_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">{{__('Status')}}</label>
                        <select class="form-control" id="editStatus" name="is_active" required>
                            <option value="1" {{ $ad->is_active == 1 ? 'selected' : '' }}>{{__('Active')}}</option>
                            <option value="0" {{ $ad->is_active == 0 ? 'selected' : '' }}>{{__('Not Active')}}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                    <button type="submit" class="btn btn-secondary">{{__('Save changes')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Edit Modal -->

<script>
    document.getElementById('category_id_{{ $ad->id }}').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        document.getElementById('category_type_{{ $ad->id }}').value = selectedOption.getAttribute('data-type');
    });
</script>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        {{ $commercialAds->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
