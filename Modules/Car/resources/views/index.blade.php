@extends('admin.index')

@section('content')
<!--begin::Content-->
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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{__('Car Normal Ads')}}</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                   
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!-- Filter menu -->
                    <div class="m-0">
                        <!-- Menu toggle -->
                        <a class="btn btn-sm btn-flex btn-secondary fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>{{__('Filter Options')}}
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
                                <form action="{{ route('normalads.index') }}" method="GET">
                                    <!-- Status Filter -->
                                    <div class="mb-10">
                                        <label class="form-label fw-semibold">{{__('Status')}}</label>
                                        <div>
                                            <select class="form-select form-select-solid" name="is_active"  data-placeholder="{{ __('Select status')}}" data-dropdown-parent="#kt_menu_64b776126c90a" data-allow-clear="true">
                                                <option value="">Select status</option>
                                                <option value="1" {{ request()->input('is_active') == '1' ? 'selected' : '' }}>{{__('Active')}}</option>
                                                <option value="0" {{ request()->input('is_active') == '0' ? 'selected' : '' }}>{{__('Inactive')}}</option>
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
                                        <button type="submit" class="btn btn-sm  btn-secondary" data-kt-menu-dismiss="true">{{__('Apply')}}</button>
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
                                <form action="{{ route('normalads.index') }}" method="GET">
                                    <input type="text" name="search" value="{{ request()->input('search') }}" class="form-control form-control-solid w-250px ps-12" placeholder="{{__('Search Ads')}}" />
                                </form>                            </div>
                            <!--end::Search-->
                        </div>

                        
                        @php
                        $categories = \App\Models\Category::whereNull('parent_id')->get();
                        @endphp

<a class="btn btn-secondary" href="{{ route('car.create')}}">
    {{__('Add Car Ads')}}  
</a>
  



                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-150px">{{__('Title')}}</th>
                            <th class="min-w-150px">{{__('Photo')}}</th>
                            <th class="min-w-70px">{{__('Customer')}}</th>
                            <th class="min-w-70px">{{__('Category')}}</th>
                            <th class="min-w-70px">{{__('Price')}}</th>
                            <th class="min-w-70px">{{__('Status')}}</th>
                            <th class="text-end min-w-70px">{{__('Actions')}}</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach($ads as $ad)
                        <tr>
                            <td>{{ $ad->title }}</td>
                            <td>
                                <img src="{{ asset('storage/'.$ad->photo) }}" alt="{{ $ad->title }}" style="width: 60px; height: auto; margin-right: 5px;">
                            </td>
                            <td>
                                @if($ad->customer)
                                    {{ $ad->customer->name }}
                                @else
                                {{__('Not assigned')}}
                                @endif
                            </td>
                            <td>
                                @if($ad->category)
                                    {{ $ad->category->title }}
                                @else
                                {{__('Not assigned')}}
                                @endif
                            </td>
                            <td>{{ \App\Helpers\ConvertCurrency::convertPrice($ad->price, session('currency_code','USD')) }}</td>
                            <td>
                                @if($ad->is_active)
                                    <span class="badge bg-success">{{__('Active')}}</span>
                                @else
                                    <span class="badge bg-danger">{{__('Not Active')}}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <!-- Dropdown -->
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{__('Actions')}}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                      
                                        <li>
                                            <a class="dropdown-item" href="{{ route('normalads.show', $ad->id) }}">{{__('show')}}</a>
                                        </li>

                                        <li>
                                            <form action="{{ route('normalads.toggleStatus', $ad->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    @if($ad->is_active)
                                                    {{__('Mark as Not Active')}}
                                                    @else
                                                    {{__('Mark as Active')}}
                                                    @endif
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('normalads.destroy', $ad->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">{{__('Delete')}}</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
