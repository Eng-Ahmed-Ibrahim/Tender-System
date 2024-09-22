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
                <h3 class="card-title">{{ __('Representative') }}</h3>
            </div>
            <div class="card-body">
                <form id="representativeForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ __('Name:') }}</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="photo">{{ __('Photo Path:') }}</label>
                        <input type="file" id="photo" name="photo" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="phone">{{ __('Phone:') }}</label>
                        <input type="number" id="phone" name="phone" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="whatsapp">{{ __('Whatsapp:') }}</label>
                        <input type="number" id="whatsapp" name="whatsapp" class="form-control" required>
                    </div>

                    <button id="save_representative" class="btn btn-primary">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).on('click', '#save_representative', function(e) {
    e.preventDefault();

    $.ajax({
        type: 'post',
        url: "{{ route('representative.store') }}",
        data: new FormData($('#representativeForm')[0]),
        processData: false,
        contentType: false, 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function(data) {
            // Create a Bootstrap alert element
            let alertHtml = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ${data.success}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            // Append the alert to the top of the content area
            $('#kt_app_content_container').prepend(alertHtml);

            // Reset the form fields
            $('#representativeForm')[0].reset();

            // Optionally, redirect to another page
        },

        error: function(reject) {
            // Handle error, display error messages
            let errors = reject.responseJSON.errors;
            let errorHtml = '<ul>';
            $.each(errors, function(key, value) {
                errorHtml += '<li>' + value[0] + '</li>';
            });
            errorHtml += '</ul>';
            $('.alert-danger').html(errorHtml).show();
        }
    });
});
</script>

@endsection
