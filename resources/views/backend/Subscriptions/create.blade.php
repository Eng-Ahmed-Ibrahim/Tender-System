@extends('admin.index')

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif <!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
<!--begin::Content container-->
<div id="kt_app_content_container" class="app-container container-xxl">
    <!--begin::Products Table-->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('Subscription') }}</h3>
        </div>
        <div class="card-body">

<!-- Subscription Plan Form -->
<form action="{{ route('subscriptions.store') }}" method="POST">
   @csrf

   <div class="form-group">
       <label for="price">{{ __('Price') }}</label>
       <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ old('price') }}" required>
   </div>
   <div class="form-group">
    <label for="name">{{ __('Description') }}</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
</div>
   <div class="form-group">
       <label for="duration">{{ __('Duration') }}</label>
       <select name="duration" id="duration" class="form-control" required>
           <option value="monthly" {{ old('duration') == 'monthly' ? 'selected' : '' }}>{{ __('Monthly') }}</option>
           <option value="3 month" {{ old('duration') == '3 month' ? 'selected' : '' }}>{{ __('3 month') }}</option>
           <option value="6 month" {{ old('duration') == '6 month' ? 'selected' : '' }}>{{ __('6 month') }}</option>
           <option value="9 month" {{ old('duration') == '9 month' ? 'selected' : '' }}>{{ __('9 month') }}</option>
           <option value="yearly" {{ old('duration') == 'yearly' ? 'selected' : '' }}>{{ __('Yearly') }}</option>
       </select>
   </div>

   <div class="form-group">
       <label for="normalads">{{ __('Normal Ads') }}</label>
       <input type="number" name="normalads" id="normalads" class="form-control" value="{{ old('normalads') }}" required>
   </div>

   <div class="form-group">
       <label for="commercialads">{{ __('Commercial Ads') }}</label>
       <input type="number" name="commercialads" id="commercialads" class="form-control" value="{{ old('commercialads') }}" required>
   </div>

   <div class="form-group">
       <label for="popupads">{{ __('Popup Ads') }}</label>
       <input type="number" name="popupads" id="popupads" class="form-control" value="{{ old('popupads') }}" required>
   </div>

   <div class="form-group">
       <label for="banners">{{ __('Banners') }}</label>
       <input type="number" name="banners" id="banners" class="form-control" value="{{ old('banners') }}" required>
   </div>

   <div class="form-group">
       <label for="featured_ads">{{ __('Featured Ads') }}</label>
       <input type="checkbox" name="featured_ads" id="featured_ads" value="1" {{ old('featured_ads') ? 'checked' : '' }}>
   </div>

   <button type="submit" class="btn btn-secondary">{{ __('Create Plan') }}</button>
</form>

@endsection
