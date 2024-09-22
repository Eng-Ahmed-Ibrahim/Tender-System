@extends('admin.index')


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
                <div class="card-title fs-3 fw-bold">Add  House PopUp</div>
            </div>
            <!--end::Card header-->
            <!--begin::Form-->

            <div class="card-body">
                <form id="house-form" action="{{ route('house-popup.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                
                    <!-- Step 1: Basic Info -->
                    <div id="step-1" class="stepper-content active">
                        <h2>Step 1: Basic Info</h2>
                
                        <div class="form-group">
                            <label for="title">House Name:</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>
                
                        <div class="form-group">
                            <label for="cat_id">Category:</label>
                            <select id="cat_id" name="cat_id" class="form-control" required>
                                @foreach($categories as $category)

                                    @if($category->children->isNotEmpty())
                                        <option value="{{ $category->id }}" disabled  style="font-size:1.2em; color:black; "class="main-category">{{ $category->name }}</option>
                        
                                        @foreach($category->children as $child)
                                            <option value="{{ $child->id }}" class="child-category">&nbsp;&nbsp;&nbsp;{{ $child->name }}</option>
                                        @endforeach
                                    @endif

                                @endforeach
                            </select>
                        </div>
                        
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>
                
                    <!-- Step 2: Upload Photos -->
                    <div id="step-2" class="stepper-content">
                        <h2>Step 2: Upload Photos</h2>
                        <div class="form-group">
                            <label for="photo_path">House Photo:</label>
                            <input type="file" id="photo_path" name="image" class="form-control" required>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>
                
                    <!-- Step 3: Additional Info -->
                    <div id="step-3" class="stepper-content">
                        <h2>Step 3: Additional Info</h2>
                        
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
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
