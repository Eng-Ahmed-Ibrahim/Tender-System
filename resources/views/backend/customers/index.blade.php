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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{__('Customers')}}</h1>
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
                                <form action="{{ route('customers.index') }}" method="GET">
                                    <input type="text" name="search" value="{{ request()->input('search') }}" class="form-control form-control-solid w-250px ps-12" placeholder="{{__('Search Customer')}}" />
                                </form>                                                        </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Add customer-->
                            <a href="{{ route('customers.create')}}" class="btn btn-secondary">{{__('Add Customer')}}</a>
                            <!--end::Add customer-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_category_table .form-check-input" value="1" />
                                        </div>
                                    </th>
                                    <th class="min-w-150px">{{__('Name')}}</th>
                                    <th class="min-w-150px">{{__('Email')}}</th>
                                    <th class="min-w-150px">{{__('Phone')}}</th>
                                    <th class="min-w-150px">{{__('Country')}}</th>
                                    <th class="min-w-150px">{{__('is Active')}}</th>
                                    <th class="min-w-150px">{{__('Create At')}}</th>
                                    <th class="text-end min-w-70px">{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">

                                @foreach ($models as $customer)

                                <tr>
                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1" />
                                        </div> 
                                    </td>
                                  
                                    <td>
                                   {{ $customer->name }}
                                    </td>
                                


                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>
                                        @if($customer->country)
                                        {{ $customer->country->name }}
                                    @else 

                                   N/A

                                    @endif
                                    </td>
                                    <td>
                                @if($customer->is_active)
                                    <span class="badge bg-success">{{__('Active')}}</span>
                                @else
                                    <span class="badge bg-danger">{{__('BAN')}}</span>
                                @endif
                            </td>
                                    <td>{{ $customer->created_at }}</td>

                                  
                                    
                                    <td class="text-end">
                                        <!--begin::Menu-->

                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{__('Actions')}}
            
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                             
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->

                                                <li>
                                                    <a class="dropdown-item" href="{{ route('customers.edit', $customer->id) }}">{{__('Edit')}}</a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item" href="{{ route('customers.show', $customer->id) }}">{{__('Show')}}</a>
                                                </li>
                                              
                                              
                                        <li>
                                            <form action="{{ route('customers.toggleStatus', $customer->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    @if($customer->is_active)
                                                    {{__('BAN')}}
                                                    @else
                                                    {{__('active')}}
                                                    @endif
                                                </button>
                                            </form>
                                        </li>
                                             
                                                <li>
                                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">{{__('Delete')}}</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                </tr>
                             @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
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
    <!--begin::Footer-->
   
    <!--end::Footer-->
</div>

@endsection