@extends('admin.index')
@section('content')
<style>
    .custom-input-group {
        position: relative;
        display: flex;
        width: 100%;
    }
    
    .input-icon-wrapper {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-right: none;
        border-radius: 8px 0 0 8px;
        color: #6c757d;
    }
    
    .custom-form-control {
        height: 48px;
        padding-left: 56px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        font-size: 0.95rem;
        width: 100%;
    }
    
    .custom-form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.15);
        outline: none;
    }
    
    .form-label {
        font-size: 0.9rem;
        font-weight: 500;
        color: #344767;
        margin-bottom: 0.5rem;
    }
    
    .required-label::after {
        content: "*";
        color: #dc3545;
        margin-left: 4px;
    }
    
    .file-upload-wrapper {
        position: relative;
        width: 100%;
    }
    
    .file-upload-input {
        position: relative;
        z-index: 2;
        width: 100%;
        height: 48px;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        background-color: #fff;
        cursor: pointer;
    }
    </style>
    
<div class="container-fluid">
    <!-- Alerts -->
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Error!</h5>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Page Header -->
    <div class="bg-white shadow-sm rounded-3 p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1">{{__('Create New Company')}}</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                <i class="fas fa-chevron-left me-2"></i>{{__('Back to List')}}
                        <li class="breadcrumb-item"><a href="">{{__('Dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">{{__('Companies')}}</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('companies.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-chevron-left me-2"></i>{{__('Back to List')}}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data" id="createCompanyForm">
                @csrf
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <!-- Company Information Card -->
                <div class="card shadow-sm mb-4 border-0 rounded-3">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex align-items-center">
                            <div class="feature-icon bg-primary bg-gradient p-3 rounded-3 me-3">
                                <i class="fas fa-building text-white fs-4"></i>
                            </div>
                            <div>
                                <h4 class="card-title mb-0">{{__('Company Information')}}</h4>
                                <small class="text-muted">{{__('Basic company details and contact information')}}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Company Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    {{__('Company Name')}}<span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       placeholder="{{__('Enter company name')}}"
                                       required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{__('Company Email')}}<span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <input type="email" 
                                           name="email" 
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           placeholder="{{__('company@example.com')}}"
                                           required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{__('Phone Number')}}</label>
                                <div class="input-group input-group-lg">
                                    <input type="tel" 
                                           name="phone" 
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}"
                                           minlength="11"
                                           maxlength="11"
                                           placeholder="01xxxxxxxxx"
                                           >
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                    
                            <!-- Website -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{__('Website')}}</label>
                                <div class="input-group input-group-lg">
                                    <input type="url" 
                                           name="website" 
                                           class="form-control @error('website') is-invalid @enderror"
                                           value="{{ old('website') }}"
                                           placeholder="https://example.com">
                                    @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{__('Commercial photo')}}</label>
                                <input type="file" 
                                       name="commercial_photo" 
                                       class="form-control form-control-lg @error('commercial_photo') is-invalid @enderror"
                                       accept="image/*">
                                @error('commercial_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    {{__('Recommended size: 200x200px (Max: 2MB)')}}
                                </small>
                            </div>
                            <!-- Logo -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{__('Company Logo')}}</label>
                                <input type="file" 
                                       name="logo" 
                                       class="form-control form-control-lg @error('logo') is-invalid @enderror"
                                       accept="image/*">
                                @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    {{__('Recommended size: 200x200px (Max: 2MB)')}}
                                </small>
                            </div>

                            <!-- Address -->
                            <div class="col-12">
                                <label class="form-label fw-bold">{{__('Address')}}</label>
                                <textarea name="address" 
                                          rows="3" 
                                          class="form-control @error('address') is-invalid @enderror"
                                          placeholder="{{__('Enter company address')}}">{{ old('address') }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Account Card -->
                <div class="card shadow-sm mb-4 border-0 rounded-3">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex align-items-center">
                            <div class="feature-icon bg-success bg-gradient p-3 rounded-3 me-3">
                                <i class="fas fa-user-shield text-white fs-4"></i>
                            </div>
                            <div>
                                <h4 class="card-title mb-0">{{__('Admin Account')}}</h4>
                                <small class="text-muted">{{__('Create administrator account for the company')}}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Admin Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{__('Admin Name')}}<span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="admin_name" 
                                       class="form-control form-control-lg @error('admin_name') is-invalid @enderror"
                                       value="{{ old('admin_name') }}"
                                       required
                                       placeholder="{{__('Enter admin name')}}">
                                @error('admin_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Admin Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{__('Admin Email')}}<span class="text-danger">*</span></label>
                                <input type="email" 
                                       name="admin_email" 
                                       class="form-control form-control-lg @error('admin_email') is-invalid @enderror"
                                       value="{{ old('admin_email') }}"
                                       required
                                       placeholder="admin@example.com">
                                @error('admin_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{__('Admin Phone')}}<span class="text-danger">*</span></label>
                                <input type="tel" 
                                       name="admin_phone" 
                                       class="form-control form-control-lg @error('admin_phone') is-invalid @enderror"
                                       value="{{ old('admin_phone') }}"
                                       required
                                       minlength="11"
                                       maxlength="11"
                                       placeholder="011xxxxxxx">
                                @error('admin_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Password -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{__('Password')}}<span class="text-danger">*</span></label>
                                <input type="password" 
                                       name="password" 
                                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       required
                                       placeholder="{{__('Enter password')}}">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    {{__('Minimum 8 characters, include numbers and special characters')}}
                                </small>
                            </div>

                            {{-- <!-- Confirm Password -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{__('Confirm Password')}}<span class="text-danger">*</span></label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       class="form-control form-control-lg"
                                       required
                                       placeholder="{{__('Confirm password')}}">
                            </div> --}}
                        </div>
                    </div>
                </div>

                <!-- Settings Card -->
                <div class="card shadow-sm mb-4 border-0 rounded-3">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex align-items-center">
                            <div class="feature-icon bg-warning bg-gradient p-3 rounded-3 me-3">
                                <i class="fas fa-cogs text-white fs-4"></i>
                            </div>
                            <div>
                                <h4 class="card-title mb-0">{{__('Company Settings')}}</h4>
                                <small class="text-muted">{{__('Additional company configuration')}}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Status -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{__('Status')}}</label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input type="radio" 
                                               name="status" 
                                               value="active" 
                                               class="form-check-input" 
                                               {{ old('status', 'active') == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label">{{__('Active')}}</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" 
                                               name="status" 
                                               value="unactive" 
                                               class="form-check-input"
                                               {{ old('status') == 'inactive' ? 'checked' : '' }}>
                                        <label class="form-check-label">{{__('Inactive')}}</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Timezone -->
                         
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="justify-content-end mb-4">
                    <a href="{{ route('companies.index') }}" class="btn btn-light btn-lg px-4 me-3">
                        <i class="fas fa-times me-2"></i>{{__('Cancel')}}
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-save me-2"></i>{{__('Create Company')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Setup CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        const form = $('#createCompanyForm');
        const submitBtn = form.find('button[type="submit"]');
        const loadingHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';
        const originalBtnHTML = submitBtn.html();
    
        // Form submission handler
        form.on('submit', function(e) {
            e.preventDefault();
            
            // Clear previous errors
            clearErrors();
            
            // Show loading state
            setLoadingState(true);
    
            // Create FormData object
            const formData = new FormData(this);
            
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    handleSuccess(response);
                },
                error: function(xhr) {
                    handleError(xhr);
                }
            });
        });
    
        // Helper Functions
        function clearErrors() {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
        }
    
        function setLoadingState(isLoading) {
            submitBtn.prop('disabled', isLoading);
            submitBtn.html(isLoading ? loadingHTML : originalBtnHTML);
        }
    
        function handleSuccess(response) {
    Swal.fire({
        icon: 'success',
        title: "{{ __('Success') }}",
        text: response.message || "{{ __('Company created successfully') }}",
        showConfirmButton: false,
        timer: 2000,
        willClose: () => {
            window.location.href = response.redirect || "{{ route('companies.index') }}";
        }
    });
}

        function handleError(xhr) {
    setLoadingState(false);
    
    if (xhr.status === 422) {
        handleValidationErrors(xhr.responseJSON.errors);
    } else {
        handleGeneralError(xhr);  // Pass the xhr object
    }
}
        function handleValidationErrors(errors) {
            Object.keys(errors).forEach(field => {
                const input = $(`[name="${field}"]`);
                const errorMsg = errors[field][0];
                
                // Add error class and message
                input.addClass('is-invalid');
                
                // Handle input groups
                if (input.parent('.input-group').length) {
                    input.parent('.input-group')
                        .after(`<div class="invalid-feedback d-block">${errorMsg}</div>`);
                } else {
                    input.after(`<div class="invalid-feedback">${errorMsg}</div>`);
                }
            });
    
            // Show error toast
            showToast('error', 'Validation Error', 'Please check the form and try again');
            
            // Scroll to first error
            const firstError = $('.is-invalid').first();
            if (firstError.length) {
                $('html, body').animate({
                    scrollTop: firstError.offset().top - 100
                }, 500);
            }
        }
    
        function handleGeneralError(xhr) {
    // Default error message
    let errorMessage = 'Something went wrong! Please try again.';
    
    try {
        if (xhr && xhr.responseJSON) {
            // Get the message from response
            if (xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
                
                // Check for integrity constraint violation error
                if (errorMessage.includes('Integrity constraint violation') && 
                    errorMessage.includes('cannot be null')) {
                    
                    // Extract the column name
                    const matches = errorMessage.match(/Column '(\w+)' cannot be null/);
                    if (matches && matches[1]) {
                        const fieldName = matches[1].charAt(0).toUpperCase() + matches[1].slice(1);
                        errorMessage = `${fieldName} is required. Please provide a value.`;
                    } else {
                        errorMessage = 'A required field is missing. Please fill all required fields.';
                    }
                }
            }
        }
    } catch (e) {
        console.error('Error parsing error response:', e);
    }
    
    // Log the error to console for debugging
    console.error('Server error:', xhr);
    
    // Show error toast
    Swal.fire({
        icon: 'error',
        title: {{ __('Error')}},
        text: errorMessage,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true
    });
    
    return false;
}
        function showToast(icon, title, text) {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }
    
        // Real-time validation
        form.find('input, select, textarea').on('input change', function() {
            $(this).removeClass('is-invalid')
                .siblings('.invalid-feedback').remove();
        });
    
        // File input preview
        $('input[type="file"]').on('change', function() {
            const file = this.files[0];
            if (file) {
                // Update file name display
                $(this).next('.custom-file-label').html(file.name);
                
                // Basic file size validation
                if (file.size > 2 * 1024 * 1024) { // 2MB
                    showToast('error', 'File Too Large', 'Please select a file under 2MB');
                    this.value = '';
                    return;
                }
            }
        });
    });
    </script>
    <script>
        $(document).ready(function() {
            // Logo preview functionality
            $('input[name="logo"]').change(function() {
                const file = this.files[0];
                const preview = $('#logoPreview');
                
                if (file) {
                    // Validate file size
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                             title: @json(__("File Too Large")),
    text: @json(__("Please select an image under 2MB")),  
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        this.value = '';
                        preview.addClass('d-none');
                        return;
                    }
        
                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.removeClass('d-none')
                            .find('img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.addClass('d-none');
                }
            });
        });
        </script>
@endsection