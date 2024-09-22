@extends('admin.index')

@section('content')
<div class="container my-4">
    <!-- House Images -->
    <div class="mb-4">
        <h2>{{ $mobile->title }}</h2>
        <div class="row">
            @foreach($mobile->images as $image)
                <div class="col-md-3 mb-3">
                        <img src="{{ asset($image->photo_path) }}"  alt="mobile Image" style="height: 70px; width:100px; object-fit:cover;  cursor: pointer;" onclick="showPopup('{{ asset($image->photo_path) }}')">

                </div>
            @endforeach
        </div>
    </div>

    <!-- House Details -->
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title">{{__('Features') }}</h2>

            @foreach($mobile->phoneFeatures as $feature)
            <p><strong>{{ __('Storage')}}:</strong> {{ $feature->storage }}</p>
            <p><strong>{{ __('Ram')}}:</strong> {{ $feature->ram }}</p>
            <p><strong>{{ __('Size')}}:</strong> {{ $feature->disply_size }}</p>
            <p><strong>{{ __('Sim No')}}:</strong> {{ $feature->sim_no }}</p>
            <p><strong>{{ __('Status')}}:</strong> {{ $feature->status}}</p>
            <p><strong>{{ __('description')}}:</strong> {{ $feature->description }}</p>
            @endforeach
        </div>
    </div>

</div>

<div id="popupContainer" class="popup-container" style="display: none;">
    <span class="popup-close" onclick="closePopup()">&times;</span>
    <img id="popupImage" class="popup-image" src="" alt="Popup Image">
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
        max-width: 90%;
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
