@extends('admin.index')

@section('content')
<style>
    textarea {
        height: 200px;
    }
    .alert {
        display: none;
    }
</style>

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <div class="card-title fs-3 fw-bold">{{ __('Create Tender') }}</div>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title fs-3 fw-bold">{{ __('Create Tender') }}</div>
                    </div>
                    <div class="card-body">
                        <!-- Alert for success or error messages -->
                        <div class="alert alert-danger" id="error-message"></div>
                        <form id="tender-form">
                            @csrf
                            <input type="hidden" name="company_id" value="{{ auth()->user()->company_id }}">
                            
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" required></textarea>
                            </div>
                
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                
                            <div class="form-group">
                                <label for="show_applicants">Show Applicants</label>
                                <select name="show_applicants" id="show_applicants" class="form-control">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                
                            <button type="submit" class="btn btn-success">Create Tender</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
$(document).ready(function() {
    // Initialize CKEditor for the description textarea
    CKEDITOR.replace('description');

    $('#tender-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Update the textarea with CKEditor data before sending it
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        $.ajax({
            url: '{{ route('tenders.store') }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                // Reset the error message
                $('#error-message').hide().text('');

                // Display success message or redirect
                alert('Tender created successfully!');
                window.location.href = '{{ route('tenders.index') }}'; 
            },
            error: function(xhr) {
                // Hide previous success/error messages
                $('#error-message').show();
                
                // Clear existing errors
                $('#error-message').text('');

                // Iterate through the errors and display them
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';

                    $.each(errors, function(key, value) {
                        errorMessage += value[0] + '<br>'; // Append error messages
                    });

                    // Set the error message
                    $('#error-message').html(errorMessage);
                } else {
                    $('#error-message').html('An unexpected error occurred.');
                }
            }
        });
    });
});
</script>

@endsection
