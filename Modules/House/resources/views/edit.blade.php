@extends('admin.index')

@section('content')
<style>
    .stepper-content {
        display: none;
    }
    .stepper-content.active {
        display: block;
    }
</style>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bold">{{ __('Edit House Offer') }}</div>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="house-form" action="{{ route('house.update', $house->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Step 1: Basic Info -->
                    <div id="step-1" class="stepper-content active">
                        <h2>{{ __('Step 1: Basic Info') }}</h2>

                        <div class="form-group">
                            <label for="title">{{ __('House Name:') }}</label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $house->title) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="price">{{ __('Price:') }}</label>
                            <input type="text" id="price" name="price" class="form-control" value="{{ old('price', $house->price) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="cat_id">{{ __('Category:') }}</label>
                            <select id="cat_id" name="cat_id" class="form-control" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $house->cat_id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="button" class="btn btn-primary" onclick="nextStep()">{{ __('Next') }}</button>
                    </div>

                    <!-- Step 2: Upload Photos -->
                    <div id="step-2" class="stepper-content">
                        <h2>{{ __('Step 2: Upload Photos') }}</h2>
                        <div class="form-group">
                            <label for="images">{{ __('House Photos:') }}</label>
                            <input type="file" id="images" name="images[]" class="form-control" multiple>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">{{ __('Previous') }}</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">{{ __('Next') }}</button>
                    </div>

                    <!-- Step 3: Add Features -->
                    <div id="step-3" class="stepper-content">
                        <h2>{{ __('Step 3: Add Features') }}</h2>
                        <div id="features-container">
                            <div class="form-group">
                                <label for="features">{{ __('Features:') }}</label>
                                @foreach($features as $feature)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="{{ $feature->id }}" id="feature{{ $feature->id }}" {{ in_array($feature->id, $house->features->pluck('id')->toArray()) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature{{ $feature->id }}">
                                            <b>{{ $feature->title }}</b>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">{{ __('Previous') }}</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">{{ __('Next') }}</button>
                    </div>

                    <!-- Step 4: House Details -->
                    <div id="step-4" class="stepper-content">
                        <h2>{{ __('Step 4: House Details') }}</h2>
                        <div class="form-group">
                            <label for="room_no">{{ __('Number of Rooms:') }}</label>
                            <input type="number" id="room_no" name="room_no" class="form-control" value="{{ old('room_no', $house->details->room_no ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="area">{{ __('Area:') }}</label>
                            <input type="text" id="area" name="area" class="form-control" value="{{ old('area', $house->details->area ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="location">{{ __('Location:') }}</label>
                            <input type="text" id="location" name="location" class="form-control" value="{{ old('location', $house->details->location ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="view">{{ __('View:') }}</label>
                            <input type="text" id="view" name="view" class="form-control" value="{{ old('view', $house->details->view ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="building_no">{{ __('Building Number:') }}</label>
                            <input type="text" id="building_no" name="building_no" class="form-control" value="{{ old('building_no', $house->details->building_no ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="history">{{ __('History:') }}</label>
                            <textarea id="history" name="history" class="form-control">{{ old('history', $house->details->history ?? '') }}</textarea>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">{{ __('Previous') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let currentStep = 1;
    const totalSteps = 4;

    function showStep(step) {
        for (let i = 1; i <= totalSteps; i++) {
            document.getElementById(`step-${i}`).classList.toggle('active', i === step);
        }
    }

    function nextStep() {
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    }
</script>
@endsection
