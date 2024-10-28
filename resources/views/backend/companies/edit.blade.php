@extends('admin.index')
@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="bg-white rounded-3 shadow-sm p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1">Edit Company</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Companies</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.show', $company->id) }}">{{ $company->name }}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form id="editCompanyForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <!-- Company Logo -->
                            <div class="col-12 text-center mb-4">
                                <div class="position-relative d-inline-block">
                                    <div class="company-logo-preview rounded-3 mb-3" style="width: 120px; height: 120px; overflow: hidden;">
                                        @if($company->logo)
                                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" class="img-fluid">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                                <i class="fas fa-building fa-3x text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <label class="btn btn-sm btn-primary position-absolute bottom-0 start-50 translate-middle-x">
                                        <i class="fas fa-camera me-2"></i>
                                        <input type="file" name="logo" class="d-none" accept="image/*">
                                    </label>
                                </div>
                            </div>

                            <!-- Company Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Company Name<span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control form-control-lg" 
                                       value="{{ $company->name }}" 
                                       required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email<span class="text-danger">*</span></label>
                                <input type="email" 
                                       name="email" 
                                       class="form-control form-control-lg" 
                                       value="{{ $company->email }}" 
                                       required>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Phone Number</label>
                                <input type="tel" 
                                       name="phone" 
                                       class="form-control form-control-lg" 
                                       value="{{ $company->phone }}">
                            </div>

                            <!-- Website -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Website</label>
                                <input type="url" 
                                       name="website" 
                                       class="form-control form-control-lg" 
                                       value="{{ $company->website }}">
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Status<span class="text-danger">*</span></label>
                                <select name="status" class="form-select form-select-lg" required>
                                    <option value="active" {{ $company->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $company->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <!-- Address -->
                            <div class="col-12">
                                <label class="form-label fw-bold">Address</label>
                                <textarea name="address" 
                                          class="form-control" 
                                          rows="3">{{ $company->address }}</textarea>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="col-12 text-end">
                                <a href="{{ route('companies.show', $company->id) }}" class="btn btn-light btn-lg me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Side Card -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4">Company Information</h5>
                    <div class="info-list">
                        <div class="info-item mb-3">
                            <label class="text-muted small mb-1">Created Date</label>
                            <p class="mb-0 fw-medium">{{ $company->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="info-item mb-3">
                            <label class="text-muted small mb-1">Last Updated</label>
                            <p class="mb-0 fw-medium">{{ $company->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="info-item">
                            <label class="text-muted small mb-1">Total Users</label>
                            <p class="mb-0 fw-medium">{{ $company->users->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.company-logo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.form-control:focus,
.form-select:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.15);
}

.info-item {
    padding: 1rem;
    background-color: #f8f9fa;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}
</style>

<script>
$(document).ready(function() {
    // Logo preview
    $('input[name="logo"]').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('.company-logo-preview').html(`
                    <img src="${e.target.result}" alt="Company Logo" class="img-fluid">
                `);
            }
            reader.readAsDataURL(file);
        }
    });

    // Form submission
    $('#editCompanyForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Saving...');

        const formData = new FormData(this);
        
        $.ajax({
            url: '{{ route("companies.update", $company->id) }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Company updated successfully',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = '{{ route("companies.show", $company->id) }}';
                });
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Save Changes');
                
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(field => {
                        const input = form.find(`[name="${field}"]`);
                        input.addClass('is-invalid')
                            .after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                    });
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please check the form and try again',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    });

    // Clear validation on input
    $('input, select, textarea').on('input', function() {
        $(this).removeClass('is-invalid')
            .siblings('.invalid-feedback').remove();
    });
});
</script>
@endsection