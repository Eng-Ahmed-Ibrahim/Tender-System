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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{__('Bills')}}</h1>
                    

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
                      
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
    <thead>
        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th>{{ __('Bill ID') }}</th>
            <th>{{ __('Amount') }}</th>
            <th>{{ __('Due Date') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
    </thead>
    <tbody class="fw-semibold text-gray-600">
        @foreach ($bills as $bill)
        <tr>
            <td>{{ $bill->id }}</td>
            <td>{{ $bill->amount }}</td>
            <td>{{ $bill->due_date }}</td>
            <td>
                <a href="{{ route('bills.show', $bill->id) }}" class="btn btn-secondary">{{ __('View') }}</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


@endsection