@extends('admin.index')

@section('content')
<div class="container">
    <div class="container">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Create Car Brands')}}</h3>
                    </div>
                    <div class="card-body">  
                        <!-- Form for creating a new feature -->
                        <form id="create-feature-form" method="POST"> 
                            @csrf
                            <div class="form-group">
                                <label for="title">{{__('Title')}}</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                        </form>

                        <div id="form-response" class="mt-3"></div> <!-- To display success or error messages -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Table listing all features -->
    <div class="container">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Car Features')}}</h3>
                    </div>
                    <div class="card-body">  
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Title')}}</th>
                                    <th>{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody id="features-list">
                                @foreach($brands as $brand)
                                    <tr id="feature-{{ $brand->id }}">
                                        <td>{{ $brand->id }}</td>
                                        <td>{{ __($brand->title) }}</td>
                                        <td>
                                            <form action="{{ route('car-brands.destroy', $brand->id) }}" method="POST" class="d-inline delete-feature-form">
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
            </div>
        </div>
    </div>
</div>

<!-- AJAX Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle form submission via AJAX
        $('#create-feature-form').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: '{{ route('car-brands.store') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Add the new feature to the table
                    $('#features-list').append(`
                        <tr id="feature-${response.id}">
                            <td>${response.id}</td>
                            <td>${response.title}</td>
                            <td>
                                <form action="/car-brands/${response.id}" method="POST" class="d-inline delete-feature-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    `);

                    // Clear the form and display a success message
                    $('#create-feature-form')[0].reset();
                    $('#form-response').html('<div class="alert alert-success">Brand created successfully.</div>');
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = '<div class="alert alert-danger"><ul>';
                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value + '</li>';
                    });
                    errorHtml += '</ul></div>';
                    $('#form-response').html(errorHtml);
                }
            });
        });

        // Handle delete form submission via AJAX
        $(document).on('submit', '.delete-feature-form', function(e) {
            e.preventDefault();
            let form = $(this);
            let featureId = form.closest('tr').attr('id').split('-')[1];

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#feature-' + featureId).remove();
                },
                error: function(xhr) {
                    alert('Error deleting feature. Please try again.');
                }
            });
        });
    });
</script>
@endsection
