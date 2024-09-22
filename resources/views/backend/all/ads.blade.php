@extends('admin.index')

@section('content')
<div class="container">

    {{-- Subcategories Section --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h2>Subcategories</h2>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach($subCategories as $subCategory)
                            <li>{{ $subCategory->title }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Normal Ads Section --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h2>Normal Ads</h2>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach($normalAds as $normalAd)
                            <li>{{ $normalAd->title }} - {{ $normalAd->description }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Commercial Ads Section --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h2>Commercial Ads</h2>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach($commercialAds as $commercialAd)
                            <li>{{ $commercialAd->title }} - {{ $commercialAd->description }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Banners Section --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h2>Banners</h2>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach($banners as $banner)
                            <li>banner</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Popup Ads Section --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h2>Popup Ads</h2>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach($popupAds as $popupAd)
                            <li>{{ $popupAd->title }} - {{ $popupAd->description }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
