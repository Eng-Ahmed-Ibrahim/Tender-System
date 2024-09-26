@extends('admin.index')

@section('content')
<div class="container">
    <div class="row">
        <!-- Ad Details -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">{{ $normalAd->title }}</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Description:</strong>
                        <p>{{ $normalAd->description }}</p>
                    </div>

                    <div class="mb-3">
                        <span class="badge badge-primary">{{ __($normalAd->is_active ? 'publish' : 'draft') }}</span>
                    </div>

                    @if ($normalAd->photo)
                        <div class="mb-3">
                            <strong>Main Photo:</strong><br>
                            <img src="{{ asset('storage/' . $normalAd->photo) }}" alt="{{ $normalAd->title }}" class="img-fluid mb-3" id="previewImage" style="max-width: 100%; height: auto; cursor: pointer;" onclick="showPopup('{{ asset('storage/' . $normalAd->photo) }}')">
                        </div>
                    @endif

                    <div class="mb-3">
                        <strong>Additional Images:</strong><br>
                        @if($normalAd->images->isNotEmpty())
                            <div class="row">
                                @foreach ($normalAd->images as $image)
                                    <div class="col-md-2 mb-3">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Image for {{ $normalAd->title }}" class="img-thumbnail" style="cursor: pointer; max-height: 70px;" onclick="showPopup('{{ asset('storage/' . $image->image_path) }}')">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>No additional images available.</p>
                        @endif
                    </div>

                    <div class="card-footer text-end">
                        <a href="{{ route('normalads.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar or additional content -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Ad Details</h5>
                </div>
                <div class="card-body">
                    <strong>Category:</strong> {{ $normalAd->category->title ?? 'N/A' }}
                    <div class="mb-3">
                        <strong>Price:</strong> ${{ number_format($normalAd->price, 2) }}
                    </div>

                </div>

            </div>

            @if($normalAd->cars) <!-- Since it's a hasOne relation, no need for isNotEmpty() -->

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Cars</h5>
                </div>
        
                <div class="card-body">
                    <strong>Model:</strong> {{ $normalAd->cars->model }}
        
                    <div class="mb-3">
                        <strong>Year:</strong> {{ $normalAd->cars->year }}
                    </div>
                    <div class="mb-3">
                        <strong>Kilo meter:</strong> {{ $normalAd->cars->kilo_meters }}
                    </div>
                    <div class="mb-3">
                        <strong>Fuel Type:</strong> {{ $normalAd->cars->fuel_type }}
                    </div>
                    <div class="mb-3">
                        <strong>Brand:</strong> {{ $normalAd->cars->brands->title }}
                    </div>
                </div>
            </div>
        
        @endif
        


        @if($normalAd->bikes)

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Bikes</h5>
            </div>

            <div class="card-body">

                <strong>Model:</strong> {{   $normalAd->bikes->model }}

                <div class="mb-3">
                    <strong>Year:</strong> {{  $normalAd->bikes->year }}
                </div>
                <div class="mb-3">
                    <strong>Kilo meter:</strong> {{  $normalAd->bikes->kilo_meters }}
                </div>
                <div class="mb-3">
                    <strong>Status:</strong> {{   $normalAd->bikes->status }}
                </div>
       


            </div>

        </div>


    @endif
        
    @if($normalAd->houses)

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Houses</h5>
        </div>

        <div class="card-body">

            <strong>Room no:</strong> {{  $normalAd->houses->room_no }}

            <div class="mb-3">
                <strong>Area:</strong> {{  $normalAd->houses->area }}
            </div>
            <div class="mb-3">
                <strong>View:</strong> {{ $normalAd->houses->view }}
            </div>
            <div class="mb-3">
                <strong>Building Number:</strong> {{  $normalAd->houses->building_no }}
            </div>
            <div class="mb-3">
                <strong> History:</strong> {{  $normalAd->houses->history }}
            </div>
   


        </div>

    </div>


@endif


@if($normalAd->mobiles)

<div class="card">
    <div class="card-header">
        <h5 class="card-title">Mobiles</h5>
    </div>

    <div class="card-body">

        <strong>Storage</strong> {{  $normalAd->mobiles->storage }}

        <div class="mb-3">
            <strong>Ram:</strong> {{  $normalAd->mobiles->ram }}
        </div>
        <div class="mb-3">
            <strong>screen size:</strong> {{ $normalAd->mobiles->disply_size }}
        </div>
        <div class="mb-3">
            <strong>card Number:</strong> {{  $normalAd->mobiles->sim_no }}
        </div>
    



    </div>

</div>


@endif

        </div>
    </div>
</div>






















































<!-- Popup Image Container -->
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
        width: 600px;
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
