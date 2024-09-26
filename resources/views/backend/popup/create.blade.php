@extends('admin.index')
@section('content')

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif <!--begin::Content-->
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Content container-->
                    <div id="kt_app_content_container" class="app-container container-xxl">
                        <!--begin::Products Table-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('PopUp')}}</h3>
                            </div>
                            <div class="card-body">
                           <form action="{{ route('popup.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">{{__('Title')}}:</label>
                                <input type="text" id="title" name="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="title">{{__('Price')}}:</label>
                                <input type="number" id="title" name="price" class="form-control" required>
                            </div>
                        
                        
                            <div class="form-group">
                                <label for="description">{{__('Description')}}:</label>
                                <textarea id="description" name="description" class="form-control"></textarea>
                            </div>
                        
                            <div class="form-group">
                                <label for="photo_path">{{__('Photo Path')}}:</label>
                                <input type="file" id="photo" name="photo" class="form-control">
                            </div>
                        
                            <div class="form-group">
                                <label for="category">{{__('Category')}}:</label>
                                <select id="cat_id" name="cat_id" class="form-control" required>
                                    <option value="">{{__('select category')}}</option>

                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" >{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <button type="submit" class="btn btn-secondary">{{__('Save')}}</button>
                        </form>
                 
                        

     </div>
            </div>
        </div>
    </div>
</div>

</div>



@endsection



@section('js')

<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js')}}"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/save-product.js')}}"></script>


@endsection