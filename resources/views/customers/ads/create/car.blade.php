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
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Navbar-->
      
        <!--begin::Card-->
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bold">Add new Car offer</div>
            </div>
            <!--end::Card header-->
            <!--begin::Form-->

            <div class="card-body">
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif


                @if($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            

                <form id="house-form" action="{{ route('car.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                
                    <!-- Step 1: Basic Info -->
                    <div id="step-1" class="stepper-content active">
                        <h2>Step 1: Basic Info</h2>
                
                        <div class="form-group">
                            <label for="title">Car Name:</label>
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
                            <label for="images">House Photos:</label>
                            <input type="file" id="images" name="images[]" class="form-control" multiple required>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>
                
                    <!-- Step 3: Add Features -->
                    <div id="step-3" class="stepper-content">
                        <h2>Step 3: Add Features</h2>
                        <div id="features-container">
                            <div class="form-group">
                                <label for="features">Features:</label>
                                @foreach($features as $feature)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="features[]" value="{{ $feature->id }}" id="feature{{ $feature->id }}">
                                        <label class="form-check-label" for="feature{{ $feature->id }}">
                                            <b>{{ $feature->title }}</b>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>
                
                    <!-- Step 4: House Details -->
                  <!-- Step 4: Car Specifications -->
<div id="step-4" class="stepper-content">
    <h2>Step 4: Car Specifications</h2>

    <div class="form-group">
        <label for="model">Model:</label>
        <input type="text" id="model" name="model" class="form-control">
    </div>
    <div class="form-group">
        <label for="year">Year:</label>
        <input type="number" id="year" name="year" class="form-control">
    </div>
    <div class="form-group">
        <label for="kilo_meters">Kilometers:</label>
        <input type="number" id="kilo_meters" name="kilo_meters" class="form-control">
    </div>
    <div class="form-group">
        <label for="status">fuel type:</label>
        <input type="text" id="status" name="fuel_type" class="form-control">
    </div>
    <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" class="form-control">
    </div>

    <!-- Button to add a new specification field -->
    <button type="button" class="btn btn-secondary" onclick="addSpecification()">Add Specification</button>

    <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
    <button type="submit" class="btn btn-primary">Submit</button>
</div>

<!-- JavaScript to handle adding new specification fields -->

                </form>
                
             
                
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
