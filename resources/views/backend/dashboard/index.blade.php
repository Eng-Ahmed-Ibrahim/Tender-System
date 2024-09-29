@php
    // Counting ads and categories
    $normalCount = \App\Models\NormalAds::count();
    $commercialCount = \App\Models\CommercialAd::count();
    $categories = \App\Models\Category::count();
    $countries = \App\Models\Country::whereIn('name', ['Egypt', 'Saudi Arabia', 'Emirates', 'Qatar', 'China', 'Spain', 'France','Iraq','Bahrain','Kuwait'])->get();
@endphp

@extends('admin.index')
@section('content')

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!-- Displaying stats with graph -->
                <div class="row gx-5 gx-xl-10">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title"><i class="fas fa-ad me-2"></i> Normal Ads</h3>
                                <p>{{ $normalCount }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title"><i class="fas fa-business-time me-2"></i> Commercial Ads</h3>
                                <p>{{ $commercialCount }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title"><i class="fas fa-list me-2"></i> Categories</h3>
                                <p>{{ $categories }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Displaying charts for better analytics -->
             @Include('backend.dashboard.partial.widget-chart')

                <!-- Display countries with flags -->
                <div class="row gx-5 gx-xl-10 mt-5">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title"><i class="fas fa-globe me-2"></i> Countries we Are In</h3>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Flag</th>
                                            <th>Country</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($countries as $country)
                                        <tr>
                                            <td>
                                                <div class="symbol symbol-50px">
                                                    <img src="{{ asset('assets/media/flags/' . strtolower(str_replace(' ', '-', $country->name)) . '.svg') }}" 
                                                         alt="{{ $country->name }} flag" 
                                                         class="img-fluid" />
                                                </div>
                                            </td>
                                            <td>{{ $country->name }}</td>
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

@endsection

<!-- Including chart scripts -->
@section('js')


@endsection
