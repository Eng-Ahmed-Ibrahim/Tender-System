@extends('admin.index')

@section('content')

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="row">
                    <div class="col-md-4">
                        <!-- Customer Details Card -->
                        <div class="card mb-5 mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body pt-15 px-0">
                                <!--begin::Member-->
                                <div class="d-flex flex-column text-center mb-9 px-9">
                                    <!--begin::Photo-->
                                    <div class="symbol symbol-80px symbol-lg-150px mb-4">
                                        @if($customer->photo) <!-- Assuming 'photo' is the attribute for the customer's photo -->
                                        <img src="{{ asset('storage/' . $customer->photo) }}" alt="{{ $customer->name }}" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                                    @else
                                        <img src="{{ asset('assets/avatar.png') }}" alt="{{ $customer->name }}" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                                    @endif                                  
                                  </div>
                                    <!--end::Photo-->
                                    <!--begin::Info-->
                                    <div class="text-center">
                                        <!--begin::Name-->
                                        <a href="../../demo1/dist/pages/user-profile/overview.html" class="text-gray-800 fw-bold text-hover-primary fs-4">{{$customer->name}}</a>
                                        <!--end::Name-->
                                        <!--begin::Position-->
                                        <span class="text-muted d-block fw-semibold"></span>
                                        <!--end::Position-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--begin::Row-->
                                <div class="row px-9 mb-4">
                                    <!--begin::Col-->
                                    <div class="col-md-4 text-center">
                                        <div class="text-gray-800 fw-bold fs-3">
                                            <span class="m-0" data-kt-countup="true" data-kt-countup-value="{{ $normalCount }}">0</span>
                                        </div>
                                        <span class="text-gray-500 fs-8 d-block fw-bold">Normal</span>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-4 text-center">
                                        <div class="text-gray-800 fw-bold fs-3">
                                        <span class="m-0" data-kt-countup="true" data-kt-countup-value="{{ $commercialCount }}">0</span></div>
                                        <span class="text-gray-500 fs-8 d-block fw-bold">Commercial</span>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-4 text-center">
                                        <div class="text-gray-800 fw-bold fs-3">
                                        <span class="m-0" data-kt-countup="true" data-kt-countup-value="{{$billsCount}}">0</span></div>
                                        <span class="text-gray-500 fs-8 d-block fw-bold">bills</span>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Navbar-->
                                <div class="m-0">
                                    <!--begin::Navs-->
                                    <ul class="nav nav-pills nav-pills-custom flex-column border-transparent fs-5 fw-bold" id="myTab" role="tablist">
                                        <!-- Normal Ads Tab -->
                                        <li class="nav-item mt-5" role="presentation">
                                            <a class="nav-link text-muted text-active-primary ms-0 py-0 me-10 ps-9 border-0 active" id="normal-ads-tab" data-bs-toggle="tab" href="#normal-ads" role="tab" aria-controls="normal-ads" aria-selected="true">
                                                <i class="ki-duotone ki-row-horizontal fs-3 text-muted me-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>{{ __('Normal Ads') }}
                                                <span class="bullet-custom position-absolute start-0 top-0 w-3px h-100 bg-primary rounded-end"></span>
                                            </a>
                                        </li>
                                    
                                        <!-- Commercial Ads Tab -->
                                        <li class="nav-item mt-5" role="presentation">
                                            <a class="nav-link text-muted text-active-primary ms-0 py-0 me-10 ps-9 border-0" id="commercial-ads-tab" data-bs-toggle="tab" href="#commercial-ads" role="tab" aria-controls="commercial-ads" aria-selected="false">
                                                <i class="ki-duotone ki-chart-simple-2 fs-3 text-muted me-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>{{ __('Commercial Ads') }}
                                                <span class="bullet-custom position-absolute start-0 top-0 w-3px h-100 bg-primary rounded-end"></span>
                                            </a>
                                        </li>
                                    
                                        <!-- Subscriptions Tab -->
                                        <li class="nav-item mt-5" role="presentation">
                                            <a class="nav-link text-muted text-active-primary ms-0 py-0 me-10 ps-9 border-0" id="subscription_ads_tab" data-bs-toggle="tab" href="#subscription_tab" role="tab" aria-controls="subscription_tab" aria-selected="false">
                                                <i class="ki-duotone ki-profile-circle fs-3 text-muted me-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>{{ __('Subscriptions') }}
                                                <span class="bullet-custom position-absolute start-0 top-0 w-3px h-100 bg-primary rounded-end"></span>
                                            </a>
                                        </li>
                                    
                                        <!-- Bills Tab -->
                                        <li class="nav-item mt-5" role="presentation">
                                            <a class="nav-link text-muted text-active-primary ms-0 py-0 me-10 ps-9 border-0" id="bills_ads_tab" data-bs-toggle="tab" href="#bills_tab" role="tab" aria-controls="bills_tab" aria-selected="false">
                                                <i class="ki-duotone ki-setting-2 fs-3 text-muted me-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>{{ __('Bills') }}
                                                <span class="bullet-custom position-absolute start-0 top-0 w-3px h-100 bg-primary rounded-end"></span>
                                            </a>
                                        </li>
                                    </ul>
                                    
                                    <!--begin::Navs-->
                                </div>
                                <!--end::Navbar-->
                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                    <div class="col-md-8">
                                <div class="card card-flush">
                        
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent">
                                    <!-- Normal Ads Tab -->
                                    <div class="tab-pane fade show active" id="normal-ads" role="tabpanel" aria-labelledby="normal-ads-tab">
                                        <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                                            <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="min-w-150px">{{ __('Title') }}</th>
                                                    <th class="min-w-150px">{{ __('Photo') }}</th>
                                                    <th class="min-w-70px">{{ __('Price') }}</th>
                                                    <th class="min-w-70px">{{ __('Status') }}</th>
                                                    <th class="text-end min-w-70px">{{ __('Actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                @foreach($customer->NormalAds as $ad)
                                                <tr>
                                                    <td>{{ $ad->title }}</td>
                                                    <td>
                                                        <img src="{{ asset('storage/'.$ad->photo) }}" alt="{{ $ad->title }}" style="width: 60px; height: auto; margin-right: 5px;">
                                                    </td>
                                                    <td>{{ \App\Helpers\ConvertCurrency::convertPrice($ad->price, session('currency_code','USD')) }}</td>
                                                    <td>
                                                        @if($ad->is_active)
                                                            <span class="badge bg-success">{{ __('Active') }}</span>
                                                        @else
                                                            <span class="badge bg-danger">{{ __('Not Active') }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                                {{ __('Actions') }}
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <li><a class="dropdown-item" href="{{ route('normalads.show', $ad->id) }}">{{ __('Show') }}</a></li>
                                                                <li>
                                                                    <form action="{{ route('normalads.toggleStatus', $ad->id) }}" method="POST" class="d-inline-block">
                                                                        @csrf
                                                                        <button type="submit" class="dropdown-item">
                                                                            @if($ad->is_active)
                                                                                {{ __('Mark as Not Active') }}
                                                                            @else
                                                                                {{ __('Mark as Active') }}
                                                                            @endif
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('normalads.destroy', $ad->id) }}" method="POST" class="d-inline-block">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item text-danger">{{ __('Delete') }}</button>
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

                                    <!-- Commercial Ads Tab -->
                                    <div class="tab-pane fade" id="commercial-ads" role="tabpanel" aria-labelledby="commercial-ads-tab">
                                        <div class="table-responsive">

                                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                                            <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th>{{ __('Title') }}</th>
                                                    <th>{{ __('Description') }}</th>
                                                    <th>{{ __('Photo') }}</th>
                                                    <th>{{ __('Status') }}</th>
                                                    <th>{{ __('Actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                @foreach($customer->CommericalAds as $ad)
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <td>{{ $ad->title }}</td>
                                                        <td>{{ $ad->description }}</td>
                                                        <td>
                                                            @if($ad->photo_path)
                                                                <img src="{{ asset('storage/' . $ad->photo_path) }}" alt="{{ $ad->title }}" style="width: 100px; height: auto;">
                                                            @else
                                                                {{ __('No Photo') }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($ad->is_active)
                                                                <span class="badge bg-success">{{ __('Active') }}</span>
                                                            @else
                                                                <span class="badge bg-danger">{{ __('Not Active') }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="#" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editAdModal-{{ $ad->id }}">{{ __('Edit') }}</a>
                                                            <form action="{{ route('commercialads.destroy', $ad->id) }}" method="POST" class="d-inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-secondary">{{ __('Delete') }}</button>
                                                            </form>
                                                            <form action="{{ route('commercial.toggleStatus', $ad->id) }}" method="POST" class="d-inline-block">
                                                                @csrf
                                                                <button type="submit" class="btn btn-secondary btn-sm">
                                                                    @if($ad->is_active)
                                                                        {{ __('Mark as Not Active') }}
                                                                    @else
                                                                        {{ __('Mark as Active') }}
                                                                    @endif
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="subscription_tab" role="tabpanel" aria-labelledby="subscription_ads_tab">
                                        <div class="table-responsive">

                                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                                            <thead>
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th>{{ __('Plan') }}</th>
                                                    <th>{{ __('Start') }}</th>
                                                    <th>{{ __('End') }}</th>
                                                    <th>{{ __('Normal') }}</th>
                                                    <th>{{ __('Commercial') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                @foreach($customer->subscriptions as $subscription)
                                                    <tr>
                                                        <td>{{ $subscription->subscriptionPlan->name }}</td>
                                                        <td>{{ $subscription->start_date }}</td>
                                                        <td>{{ $subscription->end_date }}</td>
                                                        <td>{{ $subscription->remaining_ads_normal }}</td>
                                                        <td>{{ $subscription->remaining_ads_commercial }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="bills_tab" role="tabpanel" aria-labelledby="bills_ads_tab">
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
                                                @foreach ($customer->bills as $bill)
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
