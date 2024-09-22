@extends('admin.index')
@section('content')

<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Navbar-->
        <!--end::Navbar-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title fs-3 fw-bold">{{__('Edit')}} {{__('popup')}}</div>
                <!--end::Card title-->
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li> 
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
            <!--end::Card header-->
            <!--begin::Form-->
        <form action="{{ route('popup.update', $ad->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">{{__('Title')}}:</label>
                <input type="text" id="title" name="name" class="form-control" value="{{ $ad->name }}" required>
            </div>

            <div class="form-group">
                <label for="price">{{__('Price')}}:</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ $ad->price }}" required>
            </div>

            <div class="form-group">
                <label for="description">{{__('Description')}}:</label>
                <textarea id="description" name="description" class="form-control">{{ $ad->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="photo">{{__('Photo Path')}}:</label>
                <input type="file" id="photo" name="photo" class="form-control">
                <img src="{{ asset('storage/' . $ad->photo) }}" alt="Ad Photo" width="100">
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
            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>

        </form>
    </div>
</div>

@endsection
