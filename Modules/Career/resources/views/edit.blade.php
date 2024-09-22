@extends('admin.index')

@section('content')

<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Navbar-->
      
        <!--begin::Card-->
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bold">{{ __('Edit') }}</div>
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


                <form action="{{ route('career.update', $career->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">{{ __('Title') }}</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $career->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $career->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="cat_id">{{ __('Category') }}</label>
                        <select name="cat_id" id="cat_id" class="form-control @error('cat_id') is-invalid @enderror" required>
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('cat_id', $career->cat_id) == $category->id ? 'selected' : '' }}>
                                    {{ __($category->title) }}
                                </option>
                            @endforeach
                        </select>
                        @error('cat_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="experience_year">{{ __('Experience Year') }}</label>
                        <input type="text" name="experience_year" id="experience_year" class="form-control @error('experience_year') is-invalid @enderror" value="{{ old('experience_year', $career->experience_year) }}" required>
                        @error('experience_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="experience_level">{{ __('Experience Level') }}</label>
                        <input type="text" name="experience_level" id="experience_level" class="form-control @error('experience_level') is-invalid @enderror" value="{{ old('experience_level', $career->experience_level) }}" required>
                        @error('experience_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="cv_file">{{ __('CV File') }}</label>
                        <input type="file" name="cv_file" id="cv_file" class="form-control-file @error('cv_file') is-invalid @enderror">
                        @if($career->cv_file)
                            <p>Current file: <a href="{{ asset('storage/'.$career->cv_file) }}" target="_blank">{{ __('View CV') }}</a></p>
                        @endif
                        @error('cv_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    <a href="{{ route('career.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </form>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Content container-->
</div>
<!--end::Content-->
@endsection
