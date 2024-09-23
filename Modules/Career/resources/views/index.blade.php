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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0"></h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
              
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Filter menu-->
            
                    <!--end::Filter menu-->
                    <!--begin::Primary button-->
                    <a href="{{ route('career.create')}}" class="btn btn-sm fw-bold btn-primary">Create</a>
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
                <!--begin::Products Table-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('careers')}}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
        <thead>
            <tr>
              
                <th>{{ __('Experience Year') }}</th>
                <th>{{ __('Experience Level') }}</th>
                <th>{{ __('CV File') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($careers as $career)
                <tr>
 
 
                    <td>{{ $career->experience_year }}</td>
                    <td>{{ $career->experience_level }}</td>
                    <td><a href="{{ asset('storage/' . $career->cv_file) }}" target="_blank">{{ __('View CV') }}</a></td>
                    
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
