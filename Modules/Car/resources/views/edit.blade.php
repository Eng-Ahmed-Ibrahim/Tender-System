@extends('admin.index')

@section('content')

<style>
    .stepper-content {
        display: none;
    }
    .stepper-content.active {
        display: block;
    }
    
    label,input,button{
        margin-bottom: 6px;
        margin-top: 6px;
    }

</style>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Navbar-->

        <!--begin::Card-->
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bold">{{__('Edit Car Offer')}}</div>
            </div>
            <!--end::Card header-->
            <!--begin::Form-->

            <div class="card-body">

                @if($errors->any())
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form id="car-form" action="{{ route('car.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Step 1: Basic Info -->
                    <div id="step-1" class="stepper-content active">

                        <div class="form-group">
                            <label for="title">{{__('Car Name')}}</label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ $car->title }}" required>
                        </div>
                        <div class="form-group">
                            <label for="price">{{__('Price')}}</label>
                            <input type="number" id="price" name="price" class="form-control" value="{{ $car->price }}" required>
                        </div>
                        <div class="form-group">
                            <label for="cat_id">{{__('Category')}}</label>
                            <select id="cat_id" name="cat_id" class="form-control" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $car->cat_id ? 'selected' : '' }}>
                                        {{ __($category->title) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="button" class="btn btn-primary" onclick="nextStep()">{{__('Next')}}</button>
                    </div>

                    <!-- Step 2: Upload Photos -->
                    <div id="step-2" class="stepper-content">
                        <div class="form-group">
                            <label for="images">{{__('Car Photos')}}:</label>
                            <input type="file" id="images" name="images[]" class="form-control" multiple>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">{{__('Previous')}}</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">{{__('Next')}}</button>
                    </div>

                    <!-- Step 3: Add Features -->
                    <div id="step-3" class="stepper-content">
                        <div id="features-container">
                            <div class="form-group">
                                <label for="features">{{__('Features')}}:</label>
                                @foreach($features as $feature)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="{{ $feature->id }}" id="feature{{ $feature->id }}"
                                            {{ $car->features->contains($feature->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature{{ $feature->id }}">
                                            <b>{{ $feature->title }}</b>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">{{__('Previous')}}</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">{{__('Next')}}</button>
                    </div>

                    <!-- Step 4: Car Specifications -->
                    <div id="step-4" class="stepper-content">
                        <div class="form-group">
                            <label for="model">{{__('Model')}}:</label>
                            <input type="text" id="model" name="model" class="form-control" value="{{ $specifications->model ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="year">{{__('Year')}}:</label>
                            <input type="number" id="year" name="year" class="form-control" value="{{ $specifications->year ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="kilo_meters">{{__('Kilometers')}}:</label>
                            <input type="number" id="kilo_meters" name="kilo_meters" class="form-control" value="{{ $specifications->kilo_meters ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="fuel_type">{{__('Fuel Type')}}:</label>
                            <input type="text" id="fuel_type" name="fuel_type" class="form-control" value="{{ $specifications->fuel_type ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="location">{{__('Location')}}:</label>
                            <input type="text" id="location" name="location" class="form-control" value="{{ $specifications->location ?? '' }}">
                        </div>

                        <button type="button" class="btn btn-secondary" onclick="prevStep()">{{__('Previous')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    </div>

                </form>

            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Content container-->
</div>

<script>
    let currentStep = 1;

    function showStep(step) {
        document.querySelectorAll('.stepper-content').forEach(content => {
            content.classList.remove('active');
        });
        document.querySelector(`#step-${step}`).classList.add('active');
    }

    function nextStep() {
        currentStep++;
        showStep(currentStep);
    }

    function prevStep() {
        currentStep--;
        showStep(currentStep);
    }

    showStep(currentStep);
</script>

@endsection
