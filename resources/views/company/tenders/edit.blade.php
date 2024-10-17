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
                    <div class="card-title fs-3 fw-bold">{{ __('Edit Tender') }}</div>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title fs-3 fw-bold">{{ __('Edit Tender') }}</div>
                    </div>
                    <div class="card-body">
                        <!-- Alert for success or error messages -->
                        <div class="alert alert-danger" id="error-message"></div>
                        <form id="tender-form">
                            @csrf
                            @method('PUT')


                             @if(auth()->user()->role === 'company')
                            <input type="hidden" name="company_id" value="{{ auth()->user()->company_id }}">
                        @else
                            <select name="company_id" class="form-control" required>
                                <option value="">{{ __('select company')}}</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        @endif
                        

                            <input type="hidden" name="tender_id" id="tender_id" value="{{ $tender->id }}">

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                
                            <div class="form-group">
                                <label for="title">First Insurance</label>
                                <input type="number" name="first_insurance" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="title">Last Insurance</label>
                                <input type="number" name="last_insurance" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" required></textarea>
                            </div>
                
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div>
                
                            <div class="form-group">
                                <label for="show_applicants">Show Applicants</label>
                                <select name="show_applicants" id="show_applicants" class="form-control">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                
                            <button type="submit" class="btn btn-success">Update Tender</button>
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

    // Fetch existing tender data and populate the form fields
    $.ajax({
        url: '{{ route('tenders.show', $tender->id) }}', // Endpoint to fetch tender details
        type: 'GET',
        success: function(response) {
            $('#title').val(response.title);
            $('#end_date').val(response.end_date);
            $('#show_applicants').val(response.show_applicants);

            // Set CKEditor content
            CKEDITOR.instances['description'].setData(response.description);
        },
        error: function(xhr) {
            console.error('Error fetching tender data:', xhr);
        }
    });

    $('#tender-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Update the textarea with CKEditor data before sending it
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        $.ajax({
            url: '{{ route('tenders.update', $tender->id) }}', // Update endpoint
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                // Reset the error message
                $('#error-message').hide().text('');

                // Display success message or redirect
                alert('Tender updated successfully!');
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
