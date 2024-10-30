@extends('admin.index')

@section('content')


<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Navbar-->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif        <!--end::Navbar-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title fs-3 fw-bold">{{__('Create Users')}}</div>
                <!--end::Card title-->
            </div>



            
            <div class="card-body">
        <form method="POST" action="{{ route('AdminUsers.store') }}">
            @csrf
        
            <div class="form-group">
                <label for="name">{{ __('Name')}}</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
        
            <div class="form-group">
                <label for="email">{{ __('Email')}}</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
        
            <div class="form-group">
                <label for="password">{{ __('Password')}}</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
        
            <div class="form-group">
                <label for="phone">{{ __('Phone')}}</label>
                <input type="text" name="phone" id="phone" class="form-control">
            </div>
        
            <div class="form-group">
                <label for="address">{{ __('Address')}}</label>
                <input type="text" name="address" id="address" class="form-control">
            </div>
        
            <div class="form-group">
                <label for="role_id">{{ __('Role')}}</label>
                <select name="role_id" id="role_id" class="form-control" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->title }}</option>
                    @endforeach
                </select>
            </div>
        
            <button type="submit" class="btn btn-secondary">{{ __('Create')}}</button>
        </form>
        
        
    </div>
</div>

@endsection
