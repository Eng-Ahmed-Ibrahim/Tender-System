@extends('admin.index')

@section('content')
<div class="container">
    <h1>{{ __('Bill Details') }}</h1>

    <div class="card">
        <div class="card-header">{{ __('Bill ID: ') . $bill->id }}</div>
        <div class="card-body">
            <p><strong>{{ __('Customer Name:') }}</strong> {{ $bill->customerSubscription->customer->name }}</p>
            <p><strong>{{ __('Amount:') }}</strong> {{ $bill->amount }}</p>
            <p><strong>{{ __('Due Date:') }}</strong> {{ $bill->due_date }}</p>
            <p><strong>{{ __('Subscription Plan:') }}</strong> {{ $bill->subscriptionPlan->name }}</p>
            <p><strong>{{ __('Subscription Start Date:') }}</strong> {{ $bill->subscription_start_date }}</p>
            <p><strong>{{ __('Subscription End Date:') }}</strong> {{ $bill->subscription_end_date }}</p>
            <p><strong>{{ __('Remaining Ads (Normal):') }}</strong> {{ $bill->remaining_ads_normal }}</p>
            <p><strong>{{ __('Remaining Ads (Commercial):') }}</strong> {{ $bill->remaining_ads_commercial }}</p>
            <p><strong>{{ __('Remaining Ads (Popup):') }}</strong> {{ $bill->remaining_ads_popup }}</p>
            <p><strong>{{ __('Remaining Ads (Banners):') }}</strong> {{ $bill->remaining_ads_banners }}</p>
        </div>
    </div>
</div>
@endsection
