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
                <div class="card-title fs-3 fw-bold">{{__('Edit Customers')}}</div>
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

            <!--end::Card header-->
            <!--begin::Form-->

            <div class="card-body">

    <form action="{{ route('customers.update', $model->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name Field -->
        <div class="form-group">
            <label for="name" class="mb-3">{{__('Name')}}</label>
            <input type="text" name="name" class="form-control mb-3" id="name" value="{{ old('name', $model->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="form-group">
            <label for="email" class="mb-3">{{__('Email')}}</label>
            <input type="email" name="email" class="form-control mb-3" id="email" value="{{ old('email', $model->email) }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password Field (Optional) -->
        <div class="form-group">
            <label for="password" class="mb-3">{{__('Password')}}</label>
            <input type="password" name="password" class="form-control mb-3" id="password">
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password Confirmation Field -->
        <div class="form-group">
            <label for="password_confirmation" class="mb-3">{{__('Confirm Password')}}</label>
            <input type="password" name="password_confirmation" class="form-control mb-3" id="password_confirmation">
            @error('password_confirmation')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Phone Field -->
        <div class="form-group">
            <label for="phone" class="mb-3">{{__('Phone')}}</label>
            <input type="text" name="phone" class="form-control mb-3" id="phone" value="{{ old('phone', $model->phone) }}">
            @error('phone')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Address Field -->
        <div class="form-group">
            <label for="address" class="mb-3">{{__('Address')}}</label>
            <input type="text" name="address" class="form-control mb-3" id="address" value="{{ old('address', $model->address) }}">
            @error('address')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Active Field -->
        <div class="form-group">
            <label for="is_active" class="mb-3">{{__('Active')}}</label>
            <select name="is_active" id="is_active" class="form-control mb-3">
                <option value="1" {{ old('is_active', $model->is_active) ? 'selected' : '' }}>{{__('Yes')}}</option>
                <option value="0" {{ old('is_active', $model->is_active) === 0 ? 'selected' : '' }}>{{__('No')}}</option>
            </select>
        </div>

        <button type="submit" class="btn btn-secondary">{{__('Update')}}</button>
    </form>
</div>
        </div>
    </div>
</div>

@endsection
