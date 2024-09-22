@extends('admin.index') <!-- or another layout you're using -->

@section('content')
<div class="container">

    <!-- Display House Details -->
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <!-- Image -->
            <div class="mb-3">
                <img src="{{ asset('storage/' . $commercialshouse->photo_path) }}" alt="Commercial House Image" class="img-fluid" style="max-width: 100%; height: auto;">
            </div>

            <!-- Basic Information -->
            <div class="mb-3">
                <h3>Basic Information</h3>
                <p><strong>Title:</strong> {{ __( $commercialshouse->title) }}</p>
                <p><strong>Description:</strong> {{ __( $commercialshouse->description) }}</p>
                <p><strong>Phone:</strong> {{ __( $commercialshouse->phone )?? 'N/A' }}</p>
                <p><strong>WhatsApp:</strong> {{ __( $commercialshouse->whatsapp) ?? 'N/A' }}</p>
            </div>

            <!-- Category -->
            <div class="mb-3">
                <h3>Category</h3>
                <p><strong>Category:</strong> {{ __($commercialshouse->category->name) ?? 'N/A' }}</p>
            </div>

            <!-- Country -->
            <div class="mb-3">
                <h3>Country</h3>
                <p><strong>Country:</strong>

                    @if($commercialshouse->country)
                    {{ __($commercialshouse->country->name) ?? 'N/A' }}
                    @endif
                </p>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('house.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
