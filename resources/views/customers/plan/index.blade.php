@extends('customers.index')

@section('cssfield')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@endsection

@section('content')
<style>
    .selected-plan {
        background-color: skyblue;
    }
</style>









<div class="container mt-5">
    <h1>Choose Your Subscription Plan</h1>

    <!-- Display success messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Subscription Plans Cards -->
    <div class="row">
        @foreach ($plans as $plan)
            <div class="col-md-4 mb-4">
                <div class="card {{ $plan->id == $selectedPlanId ? 'selected-plan' : '' }}">
                               <div class="card-body">
                        @if ($plan->featured_ads)
                            <div class="position-relative">
                                <i class="fas fa-crown fa-2x text-warning position-absolute" style="top: 10px; right: 10px;"></i>
                            </div>
                        @endif
                        <h5 class="card-title">${{ number_format($plan->price, 2) }}</h5>
                        <p class="card-text">
                            <strong>Details:</strong> {{ $plan->name }}<br>
                            <strong>Duration:</strong> {{ ucfirst($plan->duration) }}<br>
                            <strong>Normal Ads:</strong> {{ $plan->normalads }}<br>
                            <strong>Commercial Ads:</strong> {{ $plan->commercialads }}<br>
                            <strong>Popup Ads:</strong> {{ $plan->popupads }}<br>
                            <strong>Banners:</strong> {{ $plan->banners }}<br>
                            <strong>Featured Ads:</strong> <input type="checkbox" disabled {{ $plan->featured_ads ? 'checked' : '' }}>
                        </p>
                        <form action="{{ route('customers.subscriptions.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="subscription_plan_id" value="{{ $plan->id }}">
                            <button type="submit" class="btn btn-primary">Select Plan</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>















@endsection


















