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
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card">

            <div class="card-header">
                <div class="card-title fs-3 fw-bold">{{ __('Add new House offer') }}</div>
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

                <form id="house-form" action="{{ route('house.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                
                    <!-- Step 1: Basic Info -->
                    <div id="step-1" class="stepper-content active">
                        <h2>{{ __('Step 1: Basic Info') }}</h2>
                        <div class="form-group">
                            <label for="title">{{ __('House Name:') }}</label>
                            <input type="text" id="title" name="title" class="form-control" required>
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

                        <div class="mb-7">
                            <div class="form-label">{{ __('select_option') }}</div>

                            <select class="form-select mb-2" name="cat_id" data-control="select2" data-hide-search="true" data-placeholder="{{ __('select_option') }}" id="kt_ecommerce_add_product_store_template">
                                <option value="default" selected="selected">{{ __('select') }}</option>
                                @foreach($cat_id as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                
                                @endforeach
                            </select>
                        </div>



                    
                        <button type="button" class="btn btn-primary" onclick="nextStep(2)">{{ __('Next') }}</button>
                    </div>
                
                    <!-- Step 2: Upload Photos -->
                    <div id="step-2" class="stepper-content">
                        <h2>{{ __('Step 2: Upload Photos') }}</h2>
                        <div class="form-group">
                            <label for="images">{{__('Featured Photos')}}:</label>
                            <input type="file" id="images" name="photo" class="form-control"  required>
                        </div>

                        <div class="form-group">
                            <label for="images">{{__('House Photos')}}:</label>
                            <input type="file" id="images" name="images[]" class="form-control" multiple required>
                        </div>
                        
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">{{__('Previous')}}</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">{{__('Next')}}</button>
                    </div>
                
                        <button type="button" class="btn btn-secondary" onclick="prevStep(1)">{{ __('Previous') }}</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep(3)">{{ __('Next') }}</button>
                    </div>
                
                    <!-- Step 3: Add Features -->
                    <div id="step-3" class="stepper-content">
                        <h2>{{ __('Step 3: Add Features') }}</h2>
                        <div id="features-container">
                            <div class="form-group">
                                <label for="features">{{ __('Features:') }}</label>
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
                        <button type="button" class="btn btn-secondary" onclick="prevStep(2)">{{ __('Previous') }}</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep(4)">{{ __('Next') }}</button>
                    </div>
                
                    <!-- Step 4: House Details -->
                    <div id="step-4" class="stepper-content">
                        <h2>{{ __('Step 4: House Details') }}</h2>
                        <div class="form-group">
                            <label for="room_no">{{ __('Number of Rooms:') }}</label>
                            <input type="number" id="room_no" name="room_no" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="area">{{ __('Area:') }}</label>
                            <input type="text" id="area" name="area" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="location">{{ __('Location:') }}</label>
                            <input type="text" id="location" name="location" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="view">{{ __('View:') }}</label>
                            <input type="text" id="view" name="view" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="building_no">{{ __('Building Number:') }}</label>
                            <input type="text" id="building_no" name="building_no" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="history">{{ __('History:') }}</label>
                            <textarea id="history" name="history" class="form-control"></textarea>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep(3)">{{ __('Previous') }}</button>
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
function nextStep(step) {
    $('.stepper-content').removeClass('active');
    $('#step-' + step).addClass('active');
}

function prevStep(step) {
    $('.stepper-content').removeClass('active');
    $('#step-' + step).addClass('active');
}
</script>
@endsection
