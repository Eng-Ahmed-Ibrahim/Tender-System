@extends('admin.index')
@section('content')

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{ __('Bills') }}</h1>
                </div>
                <!--end::Page title-->

                <!--begin::Filter Button-->
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                        {{ __('Filter Bills') }}
                    </button>
                </div>
                <!--end::Filter Button-->
            </div>
        </div>
        <!--end::Toolbar-->
        
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">

                <!--begin::Bills Table-->
                <div class="card card-flush">
                    <div class="card-header align-items-center py-5">
                        <div class="card-title">
                            <h3 class="card-title">{{ __('Bills List') }}</h3>
                        </div>
                    </div>

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
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">{{ __('Filter Bills') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('bills.index') }}" method="GET">
                    <div class="row g-3">
                        <!-- Customer Filter -->
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <label for="due_date" class="form-label">{{ __('Due Date') }}</label>
                            <input type="date" name="due_date" class="form-control" value="{{ request('due_date') }}">
                        </div>

                        <!-- Min Amount Filter -->
                        <div class="col-md-6">
                            <label for="min_amount" class="form-label">{{ __('Min Amount') }}</label>
                            <input type="number" step="0.01" name="min_amount" class="form-control" value="{{ request('min_amount') }}">
                        </div>

                        <!-- Max Amount Filter -->
                        <div class="col-md-6">
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
        </div>
    </div>
</div>
<!--end::Filter Modal-->

@endsection
