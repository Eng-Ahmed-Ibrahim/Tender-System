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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{ __('Subscriptions') }}</h1>
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
            <th>{{ __('ID') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Price') }}</th>
            <th>{{ __('Duration') }}</th>
            <th>{{ __('Normal Ads') }}</th>
            <th>{{ __('Commercial Ads') }}</th>
            <th>{{ __('Popup Ads') }}</th>
            <th>{{ __('Banners') }}</th>
            <th>{{ __('Featured Ads') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($subscriptionPlans as $plan)
            <tr>
                <td>{{ $plan->id }}</td>
                <td>{{ $plan->name }}</td>
                <td>{{ $plan->price }}</td>
                <td>{{ ucfirst($plan->duration) }}</td>
                <td>{{ $plan->normalads }}</td>
                <td>{{ $plan->commercialads }}</td>
                <td>{{ $plan->popupads }}</td>
                <td>{{ $plan->banners }}</td>
                <td>
                    <input type="checkbox" disabled {{ $plan->featured_ads ? 'checked' : '' }}>
                </td>
                <td>
                    <!-- Edit and Delete Actions -->
                    <form action="{{ route('subscriptions.destroy', $plan->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('{{ __('Are you sure you want to delete this plan?') }}')">{{ __('Delete') }}</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" class="text-center">{{ __('No subscription plans found.') }}</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
