@extends('admin.index')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('Applicants.update', $applicant->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{__('Full Name')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $applicant->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> 
                             
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{__('Email Address')}} <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $applicant->email) }}" required>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> 
                        </div> 

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">{{__('Password')}} <small class="text-muted">{{__('(Leave blank to keep current)')}}</small></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">{{__('Phone Number')}}</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $applicant->phone) }}">
                                    @error('phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="photo" class="form-label">{{__('Profile Photo')}}</label>
                                    @if($applicant->photo)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/photos/' . $applicant->photo) }}" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                                    @error('photo')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                         
                        </div>

                    

                        <div class="application-section mt-4 mb-3" style="display: none;">
                            <h5>{{__('Application Documents')}}</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="files" class="form-label">{{__('Upload Documents')}}</label>
                                        <input type="file" class="form-control @error('files.*') is-invalid @enderror" id="files" name="files[]" multiple>
                                        @error('files.*')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">{{__('Update User')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

      
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Show/hide application section based on tender selection
        $('#tender_id').change(function() {
            if ($(this).val()) {
                $('.application-section').slideDown();
            } else {
                $('.application-section').slideUp();
            }
        });

        // Trigger change on page load for default value
        $('#tender_id').trigger('change');
    });
</script>
@endsection