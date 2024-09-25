@extends('admin.index')

@section('content')

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="row">
                    <div class="col-md-4">
                        <!-- Customer Details Card -->
                        <div class="card card-flush">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Customer Details') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    @if($customer->photo) <!-- Assuming 'photo' is the attribute for the customer's photo -->
                                        <img src="{{ asset('storage/' . $customer->photo) }}" alt="{{ $customer->name }}" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                                    @else
                                        <img src="{{ asset('assets/images.jpeg') }}" alt="{{ $customer->name }}" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                                    @endif
                                </div>
                                
                                <p><strong>{{ __('Name:') }}</strong> {{ $customer->name }}</p>
                                <p><strong>{{ __('Email:') }}</strong> {{ $customer->email }}</p>
                                <p><strong>{{ __('Phone:') }}</strong> {{ $customer->phone }}</p>
                                <p><strong>{{ __('Address:') }}</strong> {{ $customer->address }}</p>
                                <p><strong>{{ __('Joined On:') }}</strong> {{ $customer->created_at->format('d-m-Y') }}</p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-8">
                        <!-- Tabs for Ads -->
                        <div class="card card-flush">
                            <div class="card-header align-items-center">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="normal-ads-tab" data-bs-toggle="tab" href="#normal-ads" role="tab" aria-controls="normal-ads" aria-selected="true">{{ __('Normal Ads') }}</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="commercial-ads-tab" data-bs-toggle="tab" href="#commercial-ads" role="tab" aria-controls="commercial-ads" aria-selected="false">{{ __('Commercial Ads') }}</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="subscription_ads_tab" data-bs-toggle="tab" href="#subscription_tab" role="tab" aria-controls="subscription_tab" aria-selected="false">{{ __('Subscriptions') }}</a>
                                    </li>
                                    <li class="nav-item" role="bilss">
                                        <a class="nav-link" id="bills_ads_tab" data-bs-toggle="tab" href="#bills_tab" role="tab" aria-controls="Bills_tab" aria-selected="false">{{ __('Bills') }}</a>
                                    </li>
                                </ul>
                            </div>
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
                                                <tr>
                                                    <th>{{ __('Title') }}</th>
                                                    <th>{{ __('Description') }}</th>
                                                    <th>{{ __('Photo') }}</th>
                                                    <th>{{ __('Status') }}</th>
                                                    <th>{{ __('Actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($customer->CommericalAds as $ad)
                                                    <tr>
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
                                                                <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                                                            </form>
                                                            <form action="{{ route('commercial.toggleStatus', $ad->id) }}" method="POST" class="d-inline-block">
                                                                @csrf
                                                                <button type="submit" class="btn btn-info btn-sm">
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
                                                <tr>
                                                    <th>{{ __('Plan') }}</th>
                                                    <th>{{ __('Start') }}</th>
                                                    <th>{{ __('End') }}</th>
                                                    <th>{{ __('Normal') }}</th>
                                                    <th>{{ __('Commercial') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Bill ID') }}</th>
                                                    <th>{{ __('Amount') }}</th>
                                                    <th>{{ __('Due Date') }}</th>
                                                    <th>{{ __('Actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customer->bills as $bill)
                                                <tr>
                                                    <td>{{ $bill->id }}</td>
                                                    <td>{{ $bill->amount }}</td>
                                                    <td>{{ $bill->due_date }}</td>
                                                    <td>
                                                        <a href="{{ route('bills.show', $bill->id) }}" class="btn btn-info">{{ __('View') }}</a>
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
