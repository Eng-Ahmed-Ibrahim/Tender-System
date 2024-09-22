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
                <div class="card-title fs-3 fw-bold">{{ __('Add Mobile') }}</div>
            </div>
            <div class="card-body">
                @if($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif


                <form id="house-form" action="{{ route('mobile-normalAds.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                 
        <div class="form-group">
            <label for="title">{{ __('Title') }}</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="address">{{ __('Address') }}</label>
            <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
        </div>

        <div class="form-group">
            <label for="description">{{ __('Description') }}</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">{{ __('Price') }}</label>
            <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
        </div>

        <div class="form-group">
            <label for="cat_id">{{ __('Category') }}</label>
            <select name="cat_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="photo">{{ __('Main Photo') }}</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <div class="form-group">
            <label for="images">{{ __('Additional Photos') }}</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>

        <div class="form-group">
            <label for="storage">{{ __('Storage') }}</label>
            <input type="text" name="storage" class="form-control" value="{{ old('storage') }}" required>
        </div>

        <div class="form-group">
            <label for="ram">{{ __('RAM') }}</label>
            <input type="text" name="ram" class="form-control" value="{{ old('ram') }}" required>
        </div>

        <div class="form-group">
            <label for="disply_size">{{ __('Display Size') }}</label>
            <input type="text" name="disply_size" class="form-control" value="{{ old('disply_size') }}" required>
        </div>

        <div class="form-group">
            <label for="sim_no">{{ __('SIM Number') }}</label>
            <input type="number" name="sim_no" class="form-control" value="{{ old('sim_no') }}" required>
        </div>

        <div class="form-group">
            <label for="status">{{ __('Status') }}</label>
            <select name="status" class="form-control" required>
                <option value="used">{{ __('used') }}</option>
                <option value="new">{{ __('new') }}</option>
            </select>
        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
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
