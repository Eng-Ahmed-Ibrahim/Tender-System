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
                <div class="card-title fs-3 fw-bold">{{ __('Add new Bike offer')}}</div>
            </div>

            <div class="card-body">
                @if($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif

                <form id="car-form" action="{{ route('bike.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                
                    <div id="step-1" class="stepper-content active">
                

                        <div class="mb-7">
                            <label class="form-label">{{ __('product_name') }}</label>
                            <input type="text" name="title" class="form-control" placeholder="{{ __('product_name_description') }}" />
                        </div>
                              <div class="mb-7">
                            <label class="form-label">{{ __('Address') }}</label>
                            <input type="text" name="address" class="form-control" placeholder="{{ __('product_name_description') }}" />
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-7">
                            <label class="form-label">{{ __('description') }}</label>
                            <textarea name="description" class="form-control" placeholder="{{ __('description_description') }}"></textarea>
                        </div>

                        <div class="mb-7">
                            <label class="form-label">{{ __('base_price') }}</label>
                            <input type="number" name="price" class="form-control" placeholder="{{ __('base_price') }}" />
                        </div>
                        <div class="form-group">
                            <label for="model">{{__('Model')}}:</label>
                            <input type="text" id="model" name="model" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="year">{{__('Year')}}:</label>
                            <input type="number" id="year" name="year" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="kilo_meters">{{__('Kilometers')}}:</label>
                            <input type="number" id="kilo_meters" name="kilo_meters" class="form-control">
                        </div>
                 
                        <div class="mb-7">
                            <div class="form-label">{{ __('select_option') }}</div>

                            <select class="form-select mb-2" name="cat_id" data-control="select2" data-hide-search="true" data-placeholder="{{ __('select_option') }}" id="kt_ecommerce_add_product_store_template">
                                <option value="default" selected="selected">{{ __('select') }}</option>
                                @foreach($cat_id as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                
                                @endforeach
                            </select>
                        </div>



        
                        
                
                        <button type="button" class="btn btn-primary" onclick="nextStep()">{{__('Next')}}</button>
                    </div>
                
                    <!-- Step 2: Upload Photos -->
                    <div id="step-2" class="stepper-content">

                             
                        <div class="form-group">
                            <label for="images">{{__('Featured Photos')}}:</label>
                            <input type="file" id="images" name="photo" class="form-control"  required>
                        </div>

                        <div class="form-group">
                            <label for="images">{{__('Car Photos')}}:</label>
                            <input type="file" id="images" name="images[]" class="form-control" multiple required>
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
                                        <input class="form-check-input" type="checkbox" name="features[]" value="{{ $feature->id }}" id="feature{{ $feature->id }}">
                                        <label class="form-check-label" for="feature{{ $feature->id }}">
                                            <b>{{ __($feature->title) }}</b>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
            


    <button type="button" class="btn btn-secondary" onclick="prevStep()">{{__('Previous')}}</button>
    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
</div>

<!-- JavaScript to handle adding new specification fields -->


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
