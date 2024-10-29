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


                            <input type="hidden" name="tender_id" id="tender_id" value="{{ $tender->id }}">

                        
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
                        


                            <div class="form-group">
                                <label for="title">{{ __('Title')}}</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="title">{{ __('First Insurance')}}</label>
                                <input type="text" name="first_insurance" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="title">{{ __('Price')}}</label>
                                <input type="text" name="price" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="title">{{ __('City')}}</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                
                            <div class="form-group">
                                <label for="">{{ __('Description')}}</label>
                                <textarea name="description" class="form-control" required></textarea>
                            </div>
                
                            <div class="form-group">
                                <label for="end_date">{{ __('End Date')}}</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="end_date">{{ __('deadline to update')}}</label>
                                <input type="date" name="edit_end_date" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="show_applicants">{{ __('Show Applicants')}}</label>
                                <select name="show_applicants" id="show_applicants" class="form-control">
                                    <option value="0">{{ __('No')}}</option>
                                    <option value="1">{{ __('Yes')}}</option>
                                </select>
                            </div>
                
                            <button type="submit" class="btn btn-success">{{ __('Update Tender')}}</button>
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

});
</script>

@endsection
