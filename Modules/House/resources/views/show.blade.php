@extends('admin.index')

@section('content')
<div class="container my-4">
    <!-- House Images -->
    <div class="mb-4">
        <h2>{{ $house->title }}</h2>
        <div class="row">
            @foreach($house->images as $image)
                <div class="col-md-2 mb-3">
                    <div class="card">
                        <img src="{{ asset('storage/' . $image->image) }}"  alt="House Image" style="height: 70px; width:70px; object-fit: cover;"  onclick="showPopup('{{ asset('storage/' . $image->image) }}')">
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- House Details -->
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="card-title">{{ $house->title }}</h2>
            <p><strong>{{__('Category')}}</strong> {{ $house->category->name ?? 'N/A' }}</p>
            <p><strong>{{__('Room Number')}}</strong> {{ $house->details->room_no ?? 'N/A' }}</p>
            <p><strong>{{__('Area')}}</strong> {{ $house->details->area ?? 'N/A' }}</p>
            <p><strong>{{__('Location')}}</strong> {{ $house->details->location ?? 'N/A' }}</p>
            <p><strong>{{__('View')}}</strong> {{ $house->details->view ?? 'N/A' }}</p>
            <p><strong>{{__('Building Number')}}</strong> {{ $house->details->building_no ?? 'N/A' }}</p>
            <p><strong>{{__('History')}}</strong> {{ $house->details->history ?? 'N/A' }}</p>
        </div>
    </div>

   
<div class="card mb-4">
    <div class="card-body">
        <h2 class="card-title">{{__('Features')}}</h2>
        @foreach($house->features as $feature)
            <span class="badge badge-primary mr-2">{{ $feature->title }}</span>
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
