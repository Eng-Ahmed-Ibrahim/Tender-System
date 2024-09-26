@extends('admin.index')

@section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{ __('Categories') }}</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Category-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <form method="GET" action="{{ route('categories.index') }}" id="categoryFilterForm">
                                    <select name="category_type" class="form-control" onchange="this.form.submit()">
                                        <option value="all" {{ $categoryType === 'all' ? 'selected' : '' }}>{{ __('All Categories') }}</option>
                                        <option value="main" {{ $categoryType === 'main' ? 'selected' : '' }}>{{ __('Main Categories') }}</option>
                                        <option value="sub" {{ $categoryType === 'sub' ? 'selected' : '' }}>{{ __('Sub Categories') }}</option>
                                    </select>
                                </form>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <button class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                                {{ __('Add Category') }}
                            </button>
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th  class="min-w-150px">{{ __('ID') }}</th>
                                    <th  class="min-w-150px">{{ __('Category') }}</th>
                                    <th  class="min-w-150px">{{ __('photo') }}</th>
                                    <th  class="min-w-150px">{{ __('Type') }}</th>
                                    <th  class="min-w-150px">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ ($category->id) }}</td>
                                        <td>{{ __($category->title) }}</td>
                                        <td><img src="{{asset('storage/'.$category->photo)}}" style="width:100px;"></td>
                                        <td>{{ $category->parent_id === null ? __('Main Categories') : __('Sub Categories') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                                                <i class="bi bi-box-arrow-up-right"></i> {{ __('Edit') }}
                                            </button>
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-secondary">
                                                    <i class="bi bi-trash"></i> {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Category Modal -->
                                    <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">{{ __('Edit Category') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="title">{{ __('Category Name') }}</label>
                                                            <input type="text" name="title" class="form-control" value="{{ $category->title }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="parent_id">{{ __('Parent Category') }}</label>
                                                            <select name="parent_id" class="form-control">
                                                                <option value="">{{ __('None') }}</option>
                                                                @foreach($categories as $parentCategory)
                                                                    <option value="{{ $parentCategory->id }}" {{ $parentCategory->id == $category->parent_id ? 'selected' : '' }}>{{ __($parentCategory->title) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="photo">{{ __('Category Photo') }}</label>
                                                            <input type="file" name="photo" class="form-control">
                                                        </div>

                                                        <button type="submit" class="btn btn-secondary">{{ __('Update') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Category-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">{{ __('Create Category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ __('Category Name') }}</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    
                    @php
                    
                    $parentCategory =\App\Models\Category::whereNull('parent_id')->get()
                    @endphp
                    
                    <div class="form-group">
                        <label for="parent_id">{{ __('Parent Category') }}</label>
                        <select name="parent_id" class="form-control">
                            <option value="">{{ __('None') }}</option>
                            @foreach($parentCategory as $category)
                                <option value="{{ $category->id }}">{{ __($category->title) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="photo">{{ __('Category Photo') }}</label>
                        <input type="file" name="photo" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-secondary">{{ __('Create') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
