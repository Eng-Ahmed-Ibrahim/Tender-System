@extends('customers.index')

@section('cssfield')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    
    <!-- Dropdown for selecting a category --> 
    <form action="{{ route('customer.dashboard') }}" method="GET">
        <div class="form-group">
            <select name="category_id" id="category" class="form-control" style="width: 100%;">
                <option value="">-- Choose a Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->title }} {{$category->name}}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- Display related data if a category is selected -->
    @if($selectedCategory)
        <div class="selected-category mt-4">
            <h2>Category: {{ $selectedCategory->title }}</h2>

            <!-- Display Banners -->
    

            @if($selectedCategory->normalAds)
            
            @if($selectedCategory->normalAds->isNotEmpty())
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <div id="kt_app_content_container" class="app-container container-xxl">
                        <div class="card card-flush">
                            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                <div class="card-title">
                                    <h4>Normal Ads</h4>                  
                                </div>
                                <div class="card-toolbar">
                                    <!-- Additional toolbar items if needed -->
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-250px">Title</th>
                                            <th class="min-w-150px">Price</th>
                                            <th class="min-w-150px">Image</th>
                                            <th class="text-end min-w-70px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach($selectedCategory->normalAds as $ad)
                                            <tr>
                                                <td>{{ $ad->title }}</td>
                                                <td>{{ $ad->price }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/'.$ad->photo) }}" alt="Normal Ad Image" style="width: 100px;">
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('showNormalAd',$ad->id) }}" class="btn btn-sm btn-light btn-active-light-primary btn-flex btn-center">
                                                        Show
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @endif
            @if($selectedCategory->banners)

            @if($selectedCategory->banners->isNotEmpty())
            <div id="bannersCarousel" class="carousel slide mt-4" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($selectedCategory->banners as $index => $banner)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/'.$banner->photo_path) }}" class="d-block w-100" alt="Banner Image" style="height: 400px; object-fit: contain;">
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#bannersCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#bannersCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        @endif

        @endif
        @if($selectedCategory->commercialAds)
                    @if($selectedCategory->commercialAds->isNotEmpty())
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <div id="kt_app_content_container" class="app-container container-xxl">
                        <div class="card card-flush">
                            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                <div class="card-title">
                                    <h4>Commercial Ads</h4>                  
                                </div>
                                <div class="card-toolbar">
                                    <!-- Additional toolbar items if needed -->
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-250px">Title</th>
                                            <th class="min-w-150px">Description</th>
                                            <th class="min-w-150px">Image</th>
                                            <th class="text-end min-w-70px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach($selectedCategory->commercialAds as $ad)
                                            <tr>
                                                <td>{{ $ad->title }}</td>
                                                <td>{{ $ad->description }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/'.$ad->photo_path) }}" alt="Commercial Ad Image" style="width: 100px;">
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('showCommercialAd',$ad->id) }}" class="btn btn-sm btn-light btn-active-light-primary btn-flex btn-center">
                                                        Show
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
        </div>
        @endif

        @if($selectedCategory->house)
        @if($selectedCategory->house->isNotEmpty())
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="card-title">
                        <h4>Commercial Ads</h4>                  
                    </div>
                    <div class="card-toolbar">
                        <!-- Additional toolbar items if needed -->
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-250px">Title</th>
                                <th class="min-w-150px">Description</th>
                                <th class="min-w-150px">Image</th>
                                <th class="text-end min-w-70px">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @foreach($selectedCategory->house as $ad)
                            <tr>
                                <td>
                                    @php
                                        $firstImage = $ad->images->first();
                                    @endphp
                                    @if($firstImage)
                                        <img src="{{ asset('storage/' . $firstImage->image) }}" alt="House Photo" style="height: 100px; object-fit: contain;">
                                    @else
                                        <img src="https://via.placeholder.com/100x100" alt="Placeholder Image" style="height: 100px; object-fit: contain;">
                                    @endif
                                </td>
                                <td>{{ $ad->title }}</td>
                                <td>{{ $ad->description }}</td>
                                <td>
                                    <a href="{{ route('house.show', $ad->id) }}" class="btn btn-info btn-sm">View</a>
                                    @if($ad->phone)
                                        <a href="tel:{{ $ad->phone }}" class="btn btn-primary btn-sm">Call</a>
                                    @endif
                                    @if($ad->whatsapp)
                                        <a href="https://wa.me/{{ $ad->whatsapp }}" class="btn btn-success btn-sm" target="_blank">WhatsApp</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif

</div>
@endif
    @endif
</div>

@section('jsfield')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- Initialize Select2 on the category dropdown -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#category').select2({
            placeholder: 'Select a category',
            allowClear: true
        });

        // Automatically submit the form when a category is selected
        $('#category').on('change', function() {
            this.form.submit();
        });
    });
</script>

@endsection
@endsection
