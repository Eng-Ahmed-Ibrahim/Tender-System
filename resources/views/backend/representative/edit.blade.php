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
@endif 

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Representative</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('representative.update', $representative->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $representative->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo:</label>
                        <input type="file" id="photo" name="photo" class="form-control">
                        @if($representative->photo)
                            <img src="{{ asset('storage/' . $representative->photo) }}" alt="Representative Photo" width="100" class="img-thumbnail mt-2">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $representative->phone) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="whatsapp">Whatsapp:</label>
                        <input type="text" id="whatsapp" name="whatsapp" class="form-control" value="{{ old('whatsapp', $representative->whatsapp) }}" required>
                    </div>

                    <button type="submit" class="btn btn-secondary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
