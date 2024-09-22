@extends('admin.index')

@section('content')

<div class="container">
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Products Table-->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Create Electronics Categories') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('electronic-categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('Category Name') }}</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="parent_id">{{ __('Parent Category') }}</label>
                            <select name="parent_id" class="form-control">
                                <option value="">{{ __('None') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ __($category->title) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">{{ __('Create') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
