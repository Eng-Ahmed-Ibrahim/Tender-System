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
                <div class="card-title fs-3 fw-bold">Add new House offer</div>
            </div>
            <!--end::Card header-->
            <!--begin::Form-->

            <div class="card-body">

                
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

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                <form id="house-form" action="{{ route('house.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                
                    <!-- Step 1: Basic Info -->
                    <div id="step-1" class="stepper-content active">
                        <h2>Step 1: Basic Info</h2>
                
                        <div class="form-group">
                            <label for="title">House Name:</label>
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
                    <div id="step-4" class="stepper-content">
                        <h2>Step 4: House Details</h2>
                        <div class="form-group">
                            <label for="room_no">Number of Rooms:</label>
                            <input type="number" id="room_no" name="room_no" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="area">Area:</label>
                            <input type="text" id="area" name="area" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="location">Location:</label>
                            <input type="text" id="location" name="location" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="view">View:</label>
                            <input type="text" id="view" name="view" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="building_no">Building Number:</label>
                            <input type="text" id="building_no" name="building_no" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="history">History:</label>
                            <textarea id="history" name="history" class="form-control"></textarea>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
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
