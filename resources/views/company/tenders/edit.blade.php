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


                                <input type="hidden" name="tender_id" id="tender_id" value="{{ $tender->id }}">


                                @if (auth()->user()->role === 'company')
                                    <input type="hidden" name="company_id" value="{{ auth()->user()->company_id }}">
                                @else
                                    <div class="form-group">
                                        <label for="company_id">{{ __('Company') }}</label>
                                        <select name="company_id" class="form-control" required>
                                            <option value="">{{ __('select company') }}</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}"
                                                    {{ $tender->company_id == $company->id ? 'selected' : '' }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif



                                <div class="form-group">
                                    <label for="title">{{ __('Title') }}</label>
                                    <input type="text" name="title" class="form-control" value="{{ $tender->title }}"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="title">{{ __('Title') }}(Arabic)</label>
                                    <input type="text" name="title_ar" class="form-control"
                                        value="{{ $tender->title_ar }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="title">{{ __('First Insurance') }}</label>
                                    <input type="number" name="first_insurance" class="form-control"
                                        value="{{ $tender->first_insurance }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="title">{{ __('Price') }}</label>
                                    <input type="number" name="price" class="form-control" value="{{ $tender->price }}"
                                        required>
                                </div>

 
                                <div class="form-group mb-4">
                                    <label for="countries" class="form-label">{{ __('Countries') }}</label>
                                    <select name="country_id" id="countries" class="form-control" required>
                                        <option value="">{{ __('Select Country') }}</option>
                                        @foreach ($countries as $country)
                                            <option {{ $country->id == $tender->country_id ? 'selected' : ' '}} value="{{ $country->id }}">{{ $country->name }}
                                                ({{ $country->name_ar }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="city" class="form-label">{{ __('City') }}</label>
                                    <select name="city_id" id="city" class="form-control" required>
                                        <option value="">{{ __('Select City') }}</option>
                           @foreach ($cities as $city)
                                            <option {{ $city->id == $tender->city_id ? 'selected' : ' ' }} value="{{ $city->id }}">{{ $city->name }}
                                                ({{ $city->name_ar }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control" required>{{ $tender->description }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="">{{ __('Description') }}(Arabic)</label>
                                    <textarea name="description_ar" class="form-control" required>{{ $tender->description_ar }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="end_date">{{ __('End Date') }}</label>
                                    <input type="datetime-local" name="end_date" class="form-control"
                                        value="{{ date('Y-m-d\TH:i', strtotime($tender->end_date)) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="end_date">{{ __('deadline to update') }}</label>
                                    <input type="date" name="edit_end_date" class="form-control"
                                        value="{{ $tender->edit_end_date }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="show_applicants">{{ __('Show Applicants') }}</label>
                                    <select name="show_applicants" id="show_applicants" class="form-control">
                                        <option value="0" {{ $tender->show_applicants == 0 ? 'selected' : '' }}>
                                            {{ __('No') }}</option>
                                        <option value="1" {{ $tender->show_applicants == 1 ? 'selected' : '' }}>
                                            {{ __('Yes') }}</option>
                                    </select>
                                </div>


                                <button type="submit" class="btn btn-success">{{ __('Update Tender') }}</button>
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
            // Form submission handling
            $('#tender-form').on('submit', function(e) {
                e.preventDefault();

                // Get form data
                const formData = $(this).serialize();
                const tenderId = $('#tender_id').val();

                // Show loading state
                const submitBtn = $(this).find('button[type="submit"]');
                const originalBtnText = submitBtn.text();
                submitBtn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2"></span>Updating...');

                $.ajax({
                    url: '/tenders/' + tenderId,
                    type: 'POST', // Laravel will handle the PUT method via _method in the form data
                    data: formData,
                    success: function(response) {
                        // Show success message
                        const successAlert = $('<div class="alert alert-success">' +
                            'Tender updated successfully!' +
                            '</div>');
                        successAlert.insertBefore('#tender-form').fadeIn();

                        // Reset button state
                        submitBtn.prop('disabled', false).text(originalBtnText);

                        // Redirect after a brief delay
                        setTimeout(function() {
                            window.location.href = '/tenders';
                        }, 1500);
                    },
                    error: function(xhr) {
                        // Reset button state
                        submitBtn.prop('disabled', false).text(originalBtnText);

                        // Handle validation errors
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessage = '<ul>';

                            // Clear previous validation errors
                            $('.is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').remove();

                            // Add new validation errors
                            Object.keys(errors).forEach(function(field) {
                                const input = $('[name="' + field + '"]');
                                input.addClass('is-invalid');

                                // Add error message below the input
                                if (input.next('.invalid-feedback').length === 0) {
                                    input.after('<div class="invalid-feedback">' +
                                         errors[field][0]  + '</div>');
                                }

                                errorMessage += '<li>' + errors[field][0] + '</li>';
                            });

                            errorMessage += '</ul>';
                            $('#error-message').html('Please correct the following errors: ' +
                                errorMessage).show();
                        } else {
                            // Show general error message
                            $('#error-message').text('Failed to update tender. ' + (xhr
                                .responseJSON?.message || 'Please try again.')).show();
                        }

                        console.error('Error updating tender:', xhr);
                    }
                });
            });
                    $('#countries').on('change', function() {
                var countryId = $(this).val();
                var citySelect = $('#city');

                citySelect.empty().append('<option value="">{{ __('Select City') }}</option>');

                if (countryId) {
                    $.ajax({
                        url: '/api/cities',
                        type: 'GET',
                        data: {
                            country_id: countryId
                        },
                        success: function(data) {
                            $.each(data.data, function(key, city) {


                                citySelect.append(
                                    $('<option>', {
                                        value: city.id,
                                        text: city.name + (city.name_ar ?
                                            ` (${city.name_ar})` : '')
                                    })
                                );
                            });
                        },
                        error: function() {
                            alert('Failed to load cities.');
                        }
                    });
                }
            });
        });
    </script>
@endsection
