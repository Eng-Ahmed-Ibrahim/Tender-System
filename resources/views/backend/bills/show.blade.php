@extends('admin.index')

@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!-- begin::Invoice 3-->
        <div class="card">
            <!-- begin::Body-->
            <div class="card-body py-20">
                <!-- begin::Wrapper-->
                <div class="mw-lg-950px mx-auto w-100">
                    <!-- begin::Header-->
                    <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
                        <h4 class="fw-bolder text-gray-800 fs-2qx pe-5 pb-7">{{ __('Invoice') }}</h4>
                        <!--end::Logo-->
                        <div class="text-sm-end">
                            @php
                            $configuration = \App\Models\Configuration::first();
                            
                            @endphp                        
                            
                            <a href="#" class="d-block mw-150px ms-sm-auto">

                                <img alt="Logo" src="{{ asset('storage/' .$configuration->logo) }}" class="w-100" />

                            </a>
                            <!--end::Logo-->
                            <!--begin::Text-->
                            <div class="text-sm-end fw-semibold fs-4 text-muted mt-7">
                                <div>{{ __('Customer Name:') }} {{ $bill->customerSubscription->customer->name }}</div>
                                <div>{{ __('Billing Address:') }}
                                {{ $bill->customerSubscription->customer->address }}</div>
                                <div>{{ __('Billing Date:') }}

                            {{ $bill->due_date }}</div>
                            </div>
                            <!--end::Text-->
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="pb-12">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-column gap-7 gap-md-10">
                            <!--begin::Message-->
                            <div class="fw-bold fs-2">{{ __('Dear') }} {{ $bill->customerSubscription->customer->name }},</div>
                            <div class="separator"></div>
                            <!--begin::Order details-->
                            <div class="d-flex flex-column flex-sm-row gap-7 gap-md-10 fw-bold">
                                <div class="flex-root d-flex flex-column">
                                    <span class="text-muted">{{ __('Bill ID') }}</span>
                                    <span class="fs-5">{{ $bill->id }}</span>
                                </div>
                                <div class="flex-root d-flex flex-column">
                                    <span class="text-muted">{{ __('Date') }}</span>
                                    <span class="fs-5">{{ $bill->created_at}}</span>
                                </div>
                                <div class="flex-root d-flex flex-column">
                                    <span class="text-muted">{{ __('Due Date') }}</span>
                                    <span class="fs-5">{{ $bill->due_date }}</span>
                                </div>
                            </div>
                            <!--end::Order details-->
                            <!--begin::Order summary-->
                            <div class="d-flex justify-content-between flex-column">
                                <div class="table-responsive border-bottom mb-9">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                        <thead>
                                            <tr class="border-bottom fs-6 fw-bold text-muted">
                                                <th class="min-w-175px pb-2">{{ __('Description') }}</th>
                                                <th class="min-w-100px text-end pb-2">{{ __('Amount') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                            <tr>
                                                <td>{{ __('Subscription Plan:') }} {{ $bill->subscriptionPlan->name }}</td>
                                                <td class="text-end">{{ $bill->amount }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __(' Ads (Normal):') }} {{ $bill->remaining_ads_normal }}</td>
                                                <td class="text-end"></td>
                                            </tr>
                                            <tr>
                                                <td>{{ __(' Ads (Commercial):') }} {{ $bill->remaining_ads_commercial }}</td>
                                                <td class="text-end"></td>
                                            </tr>
                                            <tr>
                                                <td>{{ __(' Ads (Popup):') }} {{ $bill->remaining_ads_popup }}</td>
                                                <td class="text-end"></td>
                                            </tr>
                                            <tr>
                                                <td>{{ __(' Ads (Banners):') }} {{ $bill->remaining_ads_banners }}</td>
                                                <td class="text-end"></td>
                                            </tr>
                                            <tr>
                                                <td class="fs-3 text-dark fw-bold">{{ __('Grand Total') }}</td>
                                                <td class="text-dark fs-3 fw-bolder text-end">{{ $bill->amount }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end:Order summary-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Body-->
                    <!-- begin::Footer-->
                    <div class="d-flex flex-stack flex-wrap mt-lg-20 pt-13">
                        <!-- begin::Actions-->
                        <div class="my-1 me-5">
                            <button type="button" class="btn btn-success my-1 me-12" onclick="window.print();">{{ __('Print Invoice') }}</button>
                            <button type="button" class="btn btn-light-success my-1">{{ __('Download') }}</button>
                        </div>
                        <!-- end::Actions-->
                        <!-- begin::Action-->
                        <!-- end::Action-->
                    </div>
                    <!-- end::Footer-->
                </div>
                <!-- end::Wrapper-->
            </div>
            <!-- end::Body-->
        </div>
        <!-- end::Invoice 1-->
    </div>
    <!--end::Content container-->
</div>
@endsection

