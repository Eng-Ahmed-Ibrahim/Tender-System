@extends('admin.index')
@section('content')

<div class="col-md-8 offset-md-2">
    <div class="card">
        <div class="card-header">
            <h3>{{ __('Role')}}</h3>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('role.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="name">{{ __('Name')}}</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name',  $role->title ) }}" required>
                </div>

    
                <button type="submit" class="btn btn-secondary">{{ __('Update')}}</button>
            </form>
        </div>
    </div>
</div>

@endsection
