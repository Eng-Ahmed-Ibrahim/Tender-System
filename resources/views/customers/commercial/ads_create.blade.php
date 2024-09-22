@extends('customers.index')

@section('content')

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

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Products Table-->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Commercial</h3>
                </div>
                <div class="card-body">
                    <!-- resources/views/commercialads/create.blade.php -->
                    <form action="{{ route('commercial.customer.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea id="description" name="description" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="photo_path">Photo Path:</label>
                            <input type="file" id="photo_path" name="photo_path" class="form-control">
                        </div>

                     

                        <!-- Hidden input for cat_id -->
                        <input type="hidden"  id="category_id"  name="category_id" value="{{ $cat_id }}">
                        <input type="hidden" id="category_type" name="category_type" value="{{ $type }}">

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/save-product.js') }}"></script>

@endsection
