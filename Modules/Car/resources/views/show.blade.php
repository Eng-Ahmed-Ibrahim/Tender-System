@extends('admin.index')

@section('content')

<div class="container">
    <div class="row">
        <!-- Car Details -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">{{ $car->title }}</h3>
                </div>
                <div class="card-body">
                    <!-- Display Images First -->
                    @if ($car->images->isNotEmpty())
                        <div class="mb-3">
                            <strong>{{ __('Images:') }}</strong><br>
                            <div class="row">
                                @foreach ($car->images as $image)
                                    <div class="col-md-2 mb-3">
                                        <img src="{{ asset('storage/' . $image->photo) }}" alt="{{ __('Image for') }} {{ $car->title }}" class="img-fluid" style="max-height: 70px; cursor: pointer;" onclick="showPopup('{{ asset('storage/' . $image->photo) }}')">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p>{{ __('No images available.') }}</p>
                    @endif

                    <!-- Other Car Details -->
                    <div class="mb-3">
                        <strong>{{ __('Status') }}</strong> {{ $car->is_active ? __('Active') : __('Inactive') }}
                    </div>

                    @if ($car->specifications)
                        <div class="mb-3">
                            <strong>{{ __('Model') }}</strong> {{ $car->specifications->model ?? 'N/A' }}
                        </div>

                        <div class="mb-3">
                            <strong>{{ __('Year') }}</strong> {{ $car->specifications->year ?? 'N/A' }}
                        </div>

                        <div class="mb-3">
                            <strong>{{ __('Kilometers') }}</strong> {{ $car->specifications->kilo_meters ?? 'N/A' }}
                        </div>

                        <div class="mb-3">
                            <strong>{{ __('Fuel Type') }}</strong> {{ $car->specifications->fuel_type ?? 'N/A' }}
                        </div>

                        <div class="mb-3">
                            <strong>{{ __('Location') }}</strong> {{ $car->specifications->location ?? 'N/A' }}
                        </div>
                    @else
                        <p>{{ __('No specifications available.') }}</p>
                    @endif

                    <div class="mb-3">
                        <strong>{{ __('Description') }}</strong>
                        <p>{{ $car->description ?? 'N/A' }}</p>
                    </div>

                    @if ($car->features->isNotEmpty())
                        <div class="mb-3">
                            <strong>{{ __('Features') }}</strong>
                            <div class="d-flex flex-wrap">
                                @foreach ($car->features as $feature)
                                    <div class="p-2 m-1 border rounded bg-light">
                                        {{ $feature->title }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p>{{ __('No features listed.') }}</p>
                    @endif
                
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('car.index') }}" class="btn btn-primary">{{ __('Back to List') }}</a>
                    <a href="{{ route('car.edit', $car->id) }}" class="btn btn-warning">{{ __('Edit') }}</a>
                </div>
            </div>
        </div>

        <!-- Sidebar or additional content -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Car Details') }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>{{ __('Category:') }}</strong> {{ $car->category->title ?? 'N/A' }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>{{ __('Price:') }}</strong>{{ \App\Helpers\ConvertCurrency::convertPrice($car->price, session('currency_code','USD')) }}
                    </div>
                    <!-- Add more details if needed -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popup Image Container -->
<div id="popupContainer" class="popup-container" style="display: none;">
    <span class="popup-close" onclick="closePopup()">&times;</span>
    <img id="popupImage" class="popup-image" src="" alt="{{ __('Popup Image') }}">
</div>

<style>
    .popup-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }
    .popup-image {
        width: 500px;
        max-height: 80%;
    }
    .popup-close {
        position: absolute;
        top: 10px;
        right: 20px;
        font-size: 2em;
        color: #fff;
        cursor: pointer;
    }
</style>

<script>
    function showPopup(src) {
        document.getElementById('popupImage').src = src;
        document.getElementById('popupContainer').style.display = 'flex';
    }

    function closePopup() {
        document.getElementById('popupContainer').style.display = 'none';
    }
</script>
@endsection
