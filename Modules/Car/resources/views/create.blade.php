@extends('car::layouts.master')

@section('content')

<div class="container mt-4">
    <form id="carForm" action="{{ route('car.storecar') }}" method="POST">
        @csrf

        <!-- Stepper Navigation -->
        <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-car-type-tab" data-bs-toggle="pill" href="#pills-car-type" role="tab" aria-controls="pills-car-type" aria-selected="true">Car Type</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-car-model-tab" data-bs-toggle="pill" href="#pills-car-model" role="tab" aria-controls="pills-car-model" aria-selected="false">Car Model</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-car-options-tab" data-bs-toggle="pill" href="#pills-car-options" role="tab" aria-controls="pills-car-options" aria-selected="false">Car Options</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-car-specifications-tab" data-bs-toggle="pill" href="#pills-car-specifications" role="tab" aria-controls="pills-car-specifications" aria-selected="false">Car Specifications</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-car-equipments-tab" data-bs-toggle="pill" href="#pills-car-equipments" role="tab" aria-controls="pills-car-equipments" aria-selected="false">Car Equipments</a>
            </li>
        </ul>

        <!-- Stepper Content -->
        <div class="tab-content" id="pills-tabContent">
            <!-- CarType -->
            <div class="tab-pane fade show active" id="pills-car-type" role="tabpanel" aria-labelledby="pills-car-type-tab">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Car Type</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="car_type_name">Car Type Name</label>
                                <input type="text" class="form-control" name="car_type_name" id="car_type_name" required>
                            </div>
                            <div class="form-group col-md-6">
                                @php
                                $categories = \App\Models\Category::with('children')->whereNull('parent_id')->get();
                                @endphp
                                
                                <select class="form-select mb-2" name="cat_id" data-control="select2" data-hide-search="true" data-placeholder="Select an option" id="kt_ecommerce_add_product_store_template">
                                    <option></option>
                                    <option value="default" selected="selected">Select</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" disabled>{{ $category->name }}</option>
                                        @foreach($category->children as $child)
                                            <option value="{{ $child->id }}">— {{ $child->name }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="nextTab('pills-car-model-tab')">Next</button>
            </div>

            <!-- CarModel -->
            <div class="tab-pane fade" id="pills-car-model" role="tabpanel" aria-labelledby="pills-car-model-tab">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Car Model</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="car_model_name">Car Model Name</label>
                                <input type="text" class="form-control" name="car_model_name" id="car_model_name" required>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" onclick="previousTab('pills-car-type-tab')">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextTab('pills-car-options-tab')">Next</button>
            </div>

            <!-- CarOptions -->
            <div class="tab-pane fade" id="pills-car-options" role="tabpanel" aria-labelledby="pills-car-options-tab">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Car Options</h5>
                    </div>
                    <div class="card-body">
                        <div id="car-options-container">
                            <div class="option-group form-row mb-2">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="car_options[0][key]" placeholder="Option Key" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="car_options[0][value]" placeholder="Option Value" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="addOption()">Add Option</button>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" onclick="previousTab('pills-car-model-tab')">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextTab('pills-car-specifications-tab')">Next</button>
            </div>

            <!-- CarSpecifications -->
            <div class="tab-pane fade" id="pills-car-specifications" role="tabpanel" aria-labelledby="pills-car-specifications-tab">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Car Specifications</h5>
                    </div>
                    <div class="card-body">
                        <div id="car-specifications-container">
                            <div class="spec-group form-row mb-2">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="car_specifications[0][key]" placeholder="Specification Key" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="car_specifications[0][value]" placeholder="Specification Value" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="addSpecification()">Add Specification</button>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" onclick="previousTab('pills-car-options-tab')">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextTab('pills-car-equipments-tab')">Next</button>
            </div>

            <!-- CarEquipments -->
            <div class="tab-pane fade" id="pills-car-equipments" role="tabpanel" aria-labelledby="pills-car-equipments-tab">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Car Equipments</h5>
                    </div>
                    <div class="card-body">
                        <div id="car-equipments-container">
                            <div class="equipment-group form-row mb-2">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="car_equipments[0][key]" placeholder="Equipment Key" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="car_equipments[0][value]" placeholder="Equipment Value" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="addEquipment()">Add Equipment</button>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" onclick="previousTab('pills-car-specifications-tab')">Previous</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</div>

<script>
    function nextTab(tabId) {
        const form = document.getElementById('carForm');
        if (form.checkValidity()) {
            showTab(tabId);
        } else {
            form.reportValidity();
        }
    }

    function previousTab(tabId) {
        showTab(tabId);
    }

    function showTab(tabId) {
        document.querySelectorAll('.nav-link').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.remove('show', 'active');
        });

        const targetTab = document.querySelector(`#${tabId}`);
        const targetPane = document.querySelector(`#${tabId.replace('tab', 'pane')}`);

        targetTab.classList.add('active');
        targetPane.classList.add('show', 'active');
    }

    function addOption() {
        const container = document.getElementById('car-options-container');
        const index = container.querySelectorAll('.option-group').length;
        const newOption = `
            <div class="option-group form-row mb-2">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="car_options[${index}][key]" placeholder="Option Key" required>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="car_options[${index}][value]" placeholder="Option Value" required>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', newOption);
    }

    function addSpecification() {
        const container = document.getElementById('car-specifications-container');
        const index = container.querySelectorAll('.spec-group').length;
        const newSpec = `
            <div class="spec-group form-row mb-2">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="car_specifications[${index}][key]" placeholder="Specification Key" required>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="car_specifications[${index}][value]" placeholder="Specification Value" required>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', newSpec);
    }

    function addEquipment() {
        const container = document.getElementById('car-equipments-container');
        const index = container.querySelectorAll('.equipment-group').length;
        const newEquipment = `
            <div class="equipment-group form-row mb-2">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="car_equipments[${index}][key]" placeholder="Equipment Key" required>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="car_equipments[${index}][value]" placeholder="Equipment Value" required>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', newEquipment);
    }
</script>
@endsection
