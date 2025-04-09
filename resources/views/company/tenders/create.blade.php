@extends('admin.index')

@section('content')
<style>
    textarea {
        height: 200px;
    }
    .alert {
        display: none;
    }
    .invalid-feedback {
        display: none;
        color: #f1416c;
        font-size: 0.875rem;
        margin-top: 0.25rem;
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

                            @if(auth()->user()->role === 'admin_company')
                                <input type="hidden" name="company_id" value="{{ auth()->user()->company_id }}">
                            @else
                                <div class="form-group mb-4">
                                    <label for="company_id" class="form-label">{{ __('Select Company')}}</label>
                                    <select name="company_id" class="form-control" required>
                                        <option value="">{{ __('select company')}}</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="form-group mb-4">
                                <label for="title" class="form-label">{{ __('Title')}} (English)</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                                <div class="invalid-feedback" id="title-error">Please enter English characters only.</div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="title_ar" class="form-label">{{ __('Title')}} (Arabic)</label>
                                <input type="text" name="title_ar" id="title_ar" class="form-control" dir="rtl" required>
                                <div class="invalid-feedback" id="title_ar-error">Please enter Arabic characters only.</div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="first_insurance" class="form-label">{{ __('First Insurance')}}</label>
                                <input type="number" name="first_insurance" id="first_insurance" class="form-control" required>
                                <div class="invalid-feedback" id="first_insurance-error">Please enter English characters only.</div>
                            </div>
  
                            <div class="form-group mb-4">
                                <label for="price" class="form-label">{{ __('Price')}}</label>
                                <input type="number" name="price" id="price" class="form-control" required>
                                <div class="invalid-feedback" id="price-error">Please enter English characters only.</div>
                            </div> 

                            <div class="form-group mb-4"> 
                                <label for="city" class="form-label">{{ __('City')}}</label>
                                <input type="text" name="city" id="city" class="form-control" required>
                                <div class="invalid-feedback" id="city-error">Please enter English characters only.</div>
                            </div>
                
                            <div class="form-group mb-4">
                                <label for="description" class="form-label">{{ __('Description')}} (English)</label>
                                <textarea name="description" id="description" class="form-control" required></textarea>
                                <div class="invalid-feedback" id="description-error">Please enter English characters only.</div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="description_ar" class="form-label">{{ __('Description')}} (Arabic)</label>
                                <textarea name="description_ar" id="description_ar" class="form-control" dir="rtl" required></textarea>
                                <div class="invalid-feedback" id="description_ar-error">Please enter Arabic characters only.</div>
                            </div> 

                            <div class="form-group mb-4"> 
                                <label for="end_date" class="form-label">{{ __('End Date')}}</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div> 

                            <div class="form-group mb-4">
                                <label for="edit_end_date" class="form-label">{{ __('Deadline to update')}}</label>
                                <input type="date" name="edit_end_date" id="edit_end_date" class="form-control" required>
                            </div>

                            <div class="form-group mb-4">
                                <label for="show_applicants" class="form-label">{{ __('Show Applicants')}}</label>
                                <select name="show_applicants" id="show_applicants" class="form-control">
                                    <option value="0">{{__('No')}}</option>
                                    <option value="1">{{__('Yes')}}</option>
                                </select> 
                            </div>
                
                            <button type="submit" class="btn btn-success">{{ __('Create Tender')}}</button>
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
    // Regular expressions for validation
    const arabicRegex = /^[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\s]+$/;
    const englishRegex = /^[A-Za-z0-9\s.,!?@#$%^&*()_\-+=[\]{}|:;<>'"\/\\]+$/;
    
    // Function to validate input based on language
    function validateLanguage(field, regex, errorElementId) {
        const value = $(field).val();
        const errorElement = $(`#${errorElementId}`);
        
        if (value && !regex.test(value)) {
            $(field).addClass('is-invalid');
            errorElement.show();
            return false;
        } else {
            $(field).removeClass('is-invalid');
            errorElement.hide();
            return true;
        }
    }
    
    // Real-time validation for Arabic fields
    $('#title_ar, #description_ar').on('input', function() {
        const fieldId = $(this).attr('id');
        validateLanguage(this, arabicRegex, `${fieldId}-error`);
    });
    
    // Real-time validation for English fields
    $('#title, #first_insurance, #price, #city, #description').on('input', function() {
        const fieldId = $(this).attr('id');
        validateLanguage(this, englishRegex, `${fieldId}-error`);
    });

    $('#tender-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission
        
        // Validate all fields before submission
        let isValid = true;
        
        // Validate Arabic fields
        isValid = validateLanguage('#title_ar', arabicRegex, 'title_ar-error') && isValid;
        isValid = validateLanguage('#description_ar', arabicRegex, 'description_ar-error') && isValid;
        
        // Validate English fields
        isValid = validateLanguage('#title', englishRegex, 'title-error') && isValid;
        isValid = validateLanguage('#first_insurance', englishRegex, 'first_insurance-error') && isValid;
        isValid = validateLanguage('#price', englishRegex, 'price-error') && isValid;
        isValid = validateLanguage('#city', englishRegex, 'city-error') && isValid;
        isValid = validateLanguage('#description', englishRegex, 'description-error') && isValid;
        
        if (!isValid) {
            return false; // Stop form submission if validation fails
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