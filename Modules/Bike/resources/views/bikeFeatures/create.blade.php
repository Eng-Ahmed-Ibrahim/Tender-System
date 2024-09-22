@extends('admin.index')

@section('content')
<div class="container">
    
    <div class="container">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Products Table-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Create Bike Features')}}
                        </h3>
                    </div>
                    <div class="card-body">  
        <form action="{{ route('bike-features.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">{{__('Title')}}</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
        </form>
    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Table listing all features -->
    <div>

        <div class="container">
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <!--begin::Products Table-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('Bike Features')}}
                            </h3>
                        </div>
                        <div class="card-body">  
                            @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="table table-bordered">

           <thead>

                <tr>
                    <th>{{__('ID')}}</th>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Actions')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($features as $feature)
                    <tr>
                        <td>{{ $feature->id }}</td>
                        <td>{{ __($feature->title) }}</td>
                        <td>
                            <form action="{{ route('bike-features.destroy', $feature->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">{{__('Delete')}}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
