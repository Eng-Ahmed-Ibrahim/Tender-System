<div class="container">
    <h1>Dashboard</h1>
    
    <div class="categories">
        @foreach($categories as $category)
            <div class="category">
                <h2>{{ $category->title }}</h2>
                
                <!-- Display Banners -->
                @if($category->banners->isNotEmpty())
                    <h4>Banners:</h4>
                    <ul>
                        @foreach($category->banners as $banner)
                            <li>
                                <img src="{{ asset('storage/'.$banner->photo_path) }}" alt="Banner" style="width: 100px;">
                            </li>
                        @endforeach
                    </ul>
                @endif

                <!-- Display Commercial Ads -->
                @if($category->commercialAds->isNotEmpty())
                    <h4>Commercial Ads:</h4>
                    <ul>
                        @foreach($category->commercialAds as $ad)
                            <li>{{ $ad->title }}</li>
                            <li>
                                <img src="{{ asset($ad->photo_path) }}"  style="width: 100px;">
                            </li>
                        @endforeach
                    </ul>
                @endif

                <!-- Display Normal Ads -->
                @if($category->normalAds->isNotEmpty())
                    <h4>Normal Ads:</h4>
                    <ul>
                        @foreach($category->normalAds as $ad)
                            <li>{{ $ad->title }} - ${{ $ad->price }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
    </div>
</div>