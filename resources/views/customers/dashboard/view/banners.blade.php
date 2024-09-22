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