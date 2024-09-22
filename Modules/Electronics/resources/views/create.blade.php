@extends('admin.index')

@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card">
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

                <form id="electronicsForm" action="{{ route('electronics.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="step step-1">
                        <h3>Step 1: Choose Type</h3>
                        <div class="form-group">
                            <label for="type">{{ __('Type') }}</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">{{ __('Select Type') }}</option>
                                <option value="mobile">{{ __('Mobile') }}</option>
                                <option value="device">{{ __('Device') }}</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>

                    <div class="step step-2" style="display:none;">
                        <h3>Step 2: General Information</h3>
                        <div class="form-group">
                            <label for="title">{{ __('Title') }}</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                        </div>
                  
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                    </div>

                    <div class="step step-3" style="display:none;">
                        <h3>Step 3: Specific Information</h3>
                        <div id="mobileFields" style="display:none;">
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
                                <input type="text" name="disply_size" id="display_size" class="form-control" value="{{ old('display_size') }}">
                            </div>
                            <div class="form-group">
                                <label for="sim_no">{{ __('SIM Number') }}</label>
                                <input type="number" name="sim_no" id="sim_no" class="form-control" value="{{ old('sim_no') }}">
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="mobile_images">{{ __('Mobile Images') }}</label>
                                <input type="file" name="mobile_images[]" id="mobile_images" class="form-control" multiple>
                            </div>
                        </div>
                        <div id="deviceFields" style="display:none;">
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
                            <div class="form-group">
                                <label for="device_images">{{ __('Device Images') }}</label>
                                <input type="file" name="device_images[]" id="device_images" class="form-control" multiple>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let currentStep = 1;

    function nextStep() {
        if (currentStep === 1) {
            document.querySelector('.step-1').style.display = 'none';
            document.querySelector('.step-2').style.display = 'block';
            currentStep++;
        } else if (currentStep === 2) {
            document.querySelector('.step-2').style.display = 'none';
            document.querySelector('.step-3').style.display = 'block';

            const type = document.getElementById('type').value;
            if (type === 'mobile') {
                document.getElementById('mobileFields').style.display = 'block';
                document.getElementById('deviceFields').style.display = 'none';
            } else if (type === 'device') {
                document.getElementById('mobileFields').style.display = 'none';
                document.getElementById('deviceFields').style.display = 'block';
            }

            currentStep++;
        }
    }

    function prevStep() {
        if (currentStep === 2) {
            document.querySelector('.step-2').style.display = 'none';
            document.querySelector('.step-1').style.display = 'block';
            currentStep--;
        } else if (currentStep === 3) {
            document.querySelector('.step-3').style.display = 'none';
            document.querySelector('.step-2').style.display = 'block';
            currentStep--;
        }
    }
</script>
@endsection
