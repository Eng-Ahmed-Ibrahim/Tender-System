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
                <div class="card-title fs-3 fw-bold">{{__('Edit Mobile')}} </div>
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

                <form id="mobile-form" action="{{ route('mobile-normalAds.update', $mobile->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Step 1: Basic Info -->
                    <div id="step-1" class="stepper-content active">
                        <h2>Step 1: Basic Info</h2>
                        <div class="form-group">
                            <label for="title">{{__('Mobile type')}}</label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ $mobile->title }}" required>
                        </div>

                        <div class="form-group">
                            <label for="price">{{__('Price')}}</label>
                            <input type="number" id="price" name="price" class="form-control" value="{{ $mobile->price }}" required>
                        </div>
                        <div class="form-group">
                            <label for="cat_id">Category:</label>
                            <select id="cat_id" name="cat_id" class="form-control" required>
                                @foreach($categories as $category)
                                    @if($category->children->isNotEmpty())
                                        <option value="{{ $category->id }}" disabled class="main-category">{{ __($category->title) }}</option>
                                        @foreach($category->children as $child)
                                            <option value="{{ $child->id }}" class="child-category" {{ $mobile->cat_id == $child->id ? 'selected' : '' }}>
                                                &nbsp;&nbsp;&nbsp;{{ __($child->title) }}
                                            </option>
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
                            <label for="mobile_images">{{ __('Mobile Images') }}</label>
                            <input type="file" name="mobile_images[]" id="mobile_images" class="form-control" multiple>
                            @foreach($mobile->images as $image)
                                <div class="mt-2">
                                    <img src="{{ $image->photo_path }}" alt="Mobile Image" style="max-height: 150px;">
                                    <input type="checkbox" name="remove_images[]" value="{{ $image->id }}"> {{ __('Remove') }}
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>

                    <!-- Step 3: Additional Info -->
                    <div id="step-3" class="stepper-content">
                        <h2>Step 3: Additional Info</h2>
                        <div class="form-group">
                            <label for="storage">{{ __('Storage') }}</label>
                            <input type="text" name="storage" id="storage" class="form-control" value="{{ $mobile->phoneFeatures->storage }}">
                        </div>
                        <div class="form-group">
                            <label for="ram">{{ __('RAM') }}</label>
                            <input type="text" name="ram" id="ram" class="form-control" value="{{ $mobile->phoneFeatures->ram }}">
                        </div>
                        <div class="form-group">
                            <label for="display_size">{{ __('Display Size') }}</label>
                            <input type="text" name="disply_size" id="display_size" class="form-control" value="{{ $mobile->phoneFeatures->disply_size }}">
                        </div>
                        <div class="form-group">
                            <label for="sim_no">{{ __('SIM Number') }}</label>
                            <input type="number" name="sim_no" id="sim_no" class="form-control" value="{{ $mobile->phoneFeatures->sim_no }}">
                        </div>
                        <div class="form-group">
                            <label for="status">{{ __('Status') }}</label>
                            <select name="status" id="status" class="form-control">
                                <option value="new" {{ $mobile->phoneFeatures->status == 'new' ? 'selected' : '' }}>{{ __('New') }}</option>
                                <option value="used" {{ $mobile->phoneFeatures->status == 'used' ? 'selected' : '' }}>{{ __('Used') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea name="description" id="description" class="form-control">{{ $mobile->phoneFeatures->description }}</textarea>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                        <button type="submit" class="btn btn-primary">{{ __('Update')}}</button>
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
