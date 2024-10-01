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
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{__('bills')}}</h1>
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
                            </i>                        {{ __('Filter Bills') }}

                        </a>
                        <!-- Menu content -->
                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true">
                            <!-- Header -->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-dark fw-bold">{{ __('Filter Bills') }}
                                </div>
                            </div>
                            <!-- Separator -->
                            <div class="separator border-gray-200"></div>
                            <!-- Form -->
                            <div class="px-7 py-5">
                                <form action="{{ route('bills.index') }}" method="GET">
                                    <div class="row g-3">
                                        <!-- Customer Filter -->
                                        <div class="col-md-12">
                                            <label for="customer_id" class="form-label">{{ __('Customer') }}</label>
                                            <select name="customer_id" class="form-control">
                                                <option value="">{{ __('All Customers') }}</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                
                                        <!-- Subscription Plan Filter -->
                                        <div class="col-md-12">
                                            <label for="subscription_plan_id" class="form-label">{{ __('Subscription Plan') }}</label>
                                            <select name="subscription_plan_id" class="form-control">
                                                <option value="">{{ __('All Plans') }}</option>
                                                @foreach($subscriptionPlans as $plan)
                                                    <option value="{{ $plan->id }}" {{ request('subscription_plan_id') == $plan->id ? 'selected' : '' }}>
                                                        {{ $plan->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                
                                        <!-- Due Date Filter -->
                                        <div class="col-md-12">
                                            <label for="due_date" class="form-label">{{ __('Due Date') }}</label>
                                            <input type="date" name="due_date" class="form-control" value="{{ request('due_date') }}">
                                        </div>
                
                                        <!-- Min Amount Filter -->
                                        <div class="col-md-12">
                                            <label for="min_amount" class="form-label">{{ __('Min Amount') }}</label>
                                            <input type="number" step="0.01" name="min_amount" class="form-control" value="{{ request('min_amount') }}">
                                        </div>
                
                                        <!-- Max Amount Filter -->
                                        <div class="col-md-12">
                                            <label for="max_amount" class="form-label">{{ __('Max Amount') }}</label>
                                            <input type="number" step="0.01" name="max_amount" class="form-control" value="{{ request('max_amount') }}">
                                        </div>
                                    </div>
                
                                    <!-- Submit Button -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                        <button type="submit" class="btn btn-primary">{{ __('Apply Filter') }}</button>
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
                        

                





                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th>{{ __('Bill ID') }}</th>
                                    <th>{{ __('Customer Name') }}</th>
                                    <th>{{ __('Suscription plan') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Due Date') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($bills as $bill)
                                    <tr>
                                        <td>{{ $bill->id }}</td>
                                        <td>{{ $bill->customer->name }}</td>
                                        <td>{{  $bill->subscriptionPlan->name }}</td>
                                        <td>{{ $bill->amount }}</td>
                                        <td>{{ \Carbon\Carbon::parse($bill->due_date)->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('bills.show', $bill->id) }}" class="btn btn-secondary">{{ __('View') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Bills Table-->

            </div>
        </div>
        <!--end::Content-->
    </div>
</div>

<!--begin::Filter Modal-->

<!--end::Filter Modal-->

@endsection
