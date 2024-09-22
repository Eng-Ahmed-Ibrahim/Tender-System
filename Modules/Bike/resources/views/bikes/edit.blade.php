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
                <div class="card-title fs-3 fw-bold">{{ __('Edit Bike offer') }}</div>
            </div>

            <div class="card-body">
                @if($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif

                <form id="bike-form" action="{{ route('bike.update', $bike->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Step 1: Basic Info -->
                    <div id="step-1" class="stepper-content active">
                        <h2>{{ __('Step 1: Basic Info') }}</h2>
                        <div class="form-group">
                            <label for="title">{{ __('Bike Name') }}:</label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $bike->title) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="price">{{ __('Price') }}:</label>
                            <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $bike->price) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="cat_id">{{ __('Category') }}:</label>
                            <select id="cat_id" name="cat_id" class="form-control" required>
                                @foreach($categories as $category)
                                    @if($category->children->isNotEmpty())
                                        <option value="{{ $category->id }}" {{ $bike->cat_id == $category->id ? 'disabled' : '' }}>{{ $category->title }}</option>
                                        @foreach($category->children as $child)
                                            <option value="{{ $child->id }}" {{ $bike->cat_id == $child->id ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;{{ $child->title }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">{{ __('Next') }}</button>
                    </div>

                    <!-- Step 2: Upload Photos -->
                    <div id="step-2" class="stepper-content">
                        <h2>{{ __('Step 2: Upload Photos') }}</h2>
                        <div class="form-group">
                            <label for="images">{{ __('Bike Photos') }}:</label>
                            <input type="file" id="images" name="images[]" class="form-control" multiple>
                            @if($bike->images)
                                <div class="mt-3">
                                    @foreach(($bike->images) as $image)
                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ __('Bike Image') }}" class="img-thumbnail" width="100">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">{{ __('Previous') }}</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">{{ __('Next') }}</button>
                    </div>

                    <!-- Step 3: Add Features -->
                    <div id="step-3" class="stepper-content">
                        <h2>{{ __('Step 3: Add Features') }}</h2>
                        <div id="features-container">
                            <div class="form-group">
                                <label for="features">{{ __('Features') }}:</label>
                                @foreach($features as $feature)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="{{ $feature->id }}" id="feature{{ $feature->id }}" {{ $bike->features->contains($feature->id) ? 'checked' : '' }}>
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

                    <!-- Step 4: Bike Specifications -->
                    <div id="step-4" class="stepper-content">
                        <h2>{{ __('Step 4: Bike Specifications') }}</h2>
                        <div class="form-group">
                            <label for="model">{{ __('Model') }}:</label>
                            <input type="text" id="model" name="model" class="form-control" value="{{ old('model', $specifications->model) }}">
                        </div>
                        <div class="form-group">
                            <label for="year">{{ __('Year') }}:</label>
                            <input type="number" id="year" name="year" class="form-control" value="{{ old('year', $specifications->year ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="kilo_meters">{{ __('Kilometers') }}:</label>
                            <input type="number" id="kilo_meters" name="kilo_meters" class="form-control" value="{{ old('kilo_meters', $specifications->kilo_meters ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="status">{{ __('Status') }}:</label>
                            <input type="text" id="status" name="status" class="form-control" value="{{ old('status', $specifications->status ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label for="location">{{ __('Location') }}:</label>
                            <input type="text" id="location" name="location" class="form-control" value="{{ old('location', $specifications->location ?? '') }}">
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">{{ __('Previous') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Update Bike') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
function nextStep() {
    const currentStep = document.querySelector('.stepper-content.active');
    const nextStep = currentStep.nextElementSibling;
    if (nextStep && nextStep.classList.contains('stepper-content')) {
        currentStep.classList.remove('active');
        nextStep.classList.add('active');
    }
}

function prevStep() {
    const currentStep = document.querySelector('.stepper-content.active');
    const prevStep = currentStep.previousElementSibling;
    if (prevStep && prevStep.classList.contains('stepper-content')) {
        currentStep.classList.remove('active');
        prevStep.classList.add('active');
    }
}
</script>

@endsection
