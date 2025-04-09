@extends('admin.index')
@section('content')
<style>
    .invalid-feedback {
        display: none;
        color: #f1416c;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    .is-invalid {
        border-color: #f1416c !important;
    }
</style>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Navbar-->
        <div class="alert alert-danger d-none" id="validation-errors"></div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!--end::Navbar-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header"> 
                <!--begin::Card title-->
                <div class="card-title fs-3 fw-bold">{{__('Edit User')}}</div>
                <!--end::Card title-->
            </div>
           
            <div class="card-body">
                <form method="POST" action="{{ route('AdminUsers.update', $user->id) }}" id="edit-user-form">
                    @csrf
                    @method('PUT')
           
                    <div class="form-group mb-4">
                        <label for="name" class="form-label">{{ __('Name')}}</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                        <div class="invalid-feedback" id="name-error">Please enter English characters only.</div>
                    </div>
           
                    <div class="form-group mb-4">
                        <label for="email" class="form-label">{{ __('Email')}}</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                        <div class="invalid-feedback" id="email-error">Please enter a valid email address.</div>
                    </div>
           
                    <div class="form-group mb-4">
                        <label for="password" class="form-label">{{ __('Password')}} ({{ __('Leave blank to keep current password') }})</label>
                        <input type="password" name="password" id="password" class="form-control">
                        <div class="invalid-feedback" id="password-error">Password must be at least 8 characters.</div>
                    </div>
           
                    <div class="form-group mb-4">
                        <label for="phone" class="form-label">{{ __('Phone')}}</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}" minlength="11" maxlength="11">
                        <div class="invalid-feedback" id="phone-error">Please enter a valid phone number (11 digits).</div>
                    </div>
           
                    <div class="form-group mb-4">
                        <label for="address" class="form-label">{{ __('Address')}}</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ $user->address }}">
                        <div class="invalid-feedback" id="address-error">Please enter English characters only.</div>
                    </div>
             
                    <div class="form-group mb-4">
                        <label for="role_id" class="form-label">{{ __('Role')}}</label>
                        <select name="role_id" id="role_id" class="form-control" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->title }}</option>
                            @endforeach
                        </select>
                    </div>
           
                    <div class="justify-content-end">
                        <a href="{{ route('AdminUsers.index') }}" class="btn btn-light me-3">{{ __('Cancel')}}</a>
                        <button type="submit" class="btn btn-secondary">{{ __('Update')}}</button>
                    </div>
                </form>
           
           
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Regular expressions for validation
    const englishRegex = /^[A-Za-z0-9\s.,!?@#$%^&*()_\-+=[\]{}|:;<>'"\/\\]+$/;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const phoneRegex = /^\d{11}$/;
    
    // Function to validate input based on pattern
    function validateField(field, regex, errorElementId) {
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
    
    // Real-time validation for fields
    $('#name, #address').on('input', function() {
        const fieldId = $(this).attr('id');
        validateField(this, englishRegex, `${fieldId}-error`);
    });
    
    // Email validation
    $('#email').on('input', function() {
        validateField(this, emailRegex, 'email-error');
    });
    
    // Phone validation
    $('#phone').on('input', function() {
        validateField(this, phoneRegex, 'phone-error');
    });
    
    // Password validation (only if not empty)
    $('#password').on('input', function() {
        const value = $(this).val();
        const errorElement = $('#password-error');
        
        if (value && value.length < 8) {
            $(this).addClass('is-invalid');
            errorElement.show();
        } else {
            $(this).removeClass('is-invalid');
            errorElement.hide();
        }
    });
    
    // Form submission
    $('#edit-user-form').on('submit', function(e) {
        let isValid = true;
        let errorMessages = [];
        
        // Validate English text fields
        const englishFields = ['name', 'address'];
        englishFields.forEach(field => {
            if ($(`#${field}`).val() && !validateField(`#${field}`, englishRegex, `${field}-error`)) {
                isValid = false;
                errorMessages.push(`${field.toUpperCase()}: Please enter English characters only.`);
            }
        });
        
        // Validate Email
        if (!validateField('#email', emailRegex, 'email-error')) {
            isValid = false;
            errorMessages.push('EMAIL: Please enter a valid email address.');
        }
        
        // Validate Phone (if not empty)
        if ($('#phone').val() && !validateField('#phone', phoneRegex, 'phone-error')) {
            isValid = false;
            errorMessages.push('PHONE: Please enter a valid phone number (11 digits).');
        }
        
        // Validate Password (if not empty)
        const password = $('#password').val();
        if (password && password.length < 8) {
            isValid = false;
            $('#password').addClass('is-invalid');
            $('#password-error').show();
            errorMessages.push('PASSWORD: Password must be at least 8 characters.');
        }
        
        // If validation fails, show errors and prevent form submission
        if (!isValid) {
            e.preventDefault();
            
            // Display all error messages
            const errorContainer = $('#validation-errors');
            errorContainer.html('');
            errorMessages.forEach(message => {
                errorContainer.append(`<div>${message}</div>`);
            });
            errorContainer.removeClass('d-none');
            
            // Scroll to the top to see errors
            $('html, body').animate({
                scrollTop: errorContainer.offset().top - 100
            }, 200);
        }
    });
});
</script>
@endsection