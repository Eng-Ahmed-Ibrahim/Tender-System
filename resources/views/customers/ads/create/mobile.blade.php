@extends('customers.index')

@section('content')
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
                <div class="card-title fs-3 fw-bold">Add Mobile </div>
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

                <form id="house-form" action="{{ route('mobile-normalAds.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Step 1: Basic Info -->
                    <div id="step-1" class="stepper-content active">
                        <h2>Step 1: Basic Info</h2>
                        <div class="form-group">
                            <label for="title">Mobile type:</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="title">Price:</label>
                            <input type="number" id="price" name="price" class="form-control" required>
                        </div>
                        <input type="hidden" name="cat_id" value="{{ $cat_id }}">       
                        
                        <input type="hidden" name="redirect_to" value="normal.customer.index">

                        <input type="hidden" name="customer_id" value="{{ auth()->guard('customer')->id() }} ">

                 
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>

                    <!-- Step 2: Upload Photos -->
                    <div id="step-2" class="stepper-content">
                        <h2>Step 2: Upload Photos</h2>
                        <div class="form-group">
                            <label for="mobile_images">{{ __('Mobile Images') }}</label>
                            <input type="file" name="amobile_images[]" id="mobile_images" class="form-control" multiple>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>

                    <!-- Step 3: Additional Info -->
                    <div id="step-3" class="stepper-content">
                        <h2>Step 3: Additional Info</h2>
                        <div class="form-group">
                            <label for="storage">{{ __('Storage') }}</label>
                            <input type="text" name="storage" id="storage" class="form-control" value="{{ old('storage') }}">
                        </div>
                        <div class="form-group">
                            <label for="ram">{{ __('RAM') }}</label>
                            <input type="text" name="ram" id="ram" class="form-control" value="{{ old('ram') }}">
                        </div>
                        <div class="form-group">
                            <label for="display_size">{{ __('Display Size') }}</label>
                            <input type="text" name="disply_size" id="display_size" class="form-control" value="{{ old('disply_size') }}">
                        </div>
                        <div class="form-group">
                            <label for="sim_no">{{ __('SIM Number') }}</label>
                            <input type="number" name="sim_no" id="sim_no" class="form-control" value="{{ old('sim_no') }}">
                        </div>
                        <div class="form-group">
                            <label for="status">{{ __('Status') }}</label>
                            <select name="status" id="status" class="form-control">
                                <option value="new">{{ __('New') }}</option>
                                <option value="used">{{ __('Used') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
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

function addFeature() {
    const container = document.getElementById('features-container');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'features[]';
    input.className = 'form-control mb-2';
    input.required = true;
    container.appendChild(input);
}  
</script>
@endsection
