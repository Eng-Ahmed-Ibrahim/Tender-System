@extends('admin.index')

@section('content')

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bold">{{ __('Bike Offers') }}</div>
                <a href="{{ route('bike.create') }}" class="btn btn-primary">{{ __('Add New Bike Offer') }}</a>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Bike Name') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Images') }}</th>
                            <th>{{ __('Features') }}</th>
                            <th>{{ __('Specifications') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bikes as $bike)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $bike->title }}</td>
                            <td>{{ $bike->price }}</td>
                            <td>{{ $bike->category->title ?? __('N/A') }}</td>
                            <td>
                                @if($bike->images->isNotEmpty())
                                    @foreach($bike->images as $image)
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ __('Bike Image') }}" width="100" class="img-thumbnail">
                                    @endforeach
                                @else
                                    {{ __('No images') }}
                                @endif
                            </td>
                            <td>
                                @if($bike->features->isNotEmpty())
                                    <ul>
                                        @foreach($bike->features as $feature)
                                            <li>{{ $feature->title }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{ __('No features') }}
                                @endif
                            </td>
                        
                            <td>
                                <a href="{{ route('bike.edit', $bike->id) }}" class="btn btn-warning btn-sm">{{ __('Edit') }}</a>
                                <form action="{{ route('bike.destroy', $bike->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('Are you sure you want to delete this bike offer?') }}')">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $bikes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
