@extends('admin.index')

@section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Edit Banners </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('banners.index') }}" class="text-muted text-hover-primary">Back to Banners</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Edit Banners</li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card card-flush">
                    <div class="card-body pt-0">
                        <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="category">{{__('Category')}}:</label>
                                <select id="cat_id" name="cat_id" class="form-control" required>
                                    <option value="">{{__('select category')}}</option>
                
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" >{{ $category->title }}</option>
                                    @endforeach
                                </select>
                
                            </div>
                   

                     
                            <div class="mb-5">
                                <label class="form-label">Photos</label>
                                <div class="row">
                                        <div class="col-md-4">
                                            <img src="{{ asset('storage/' . $banner->photo_path) }}" alt="Banner Image" class="img-thumbnail mb-3">
                                        </div>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Add New Photos</label>
                                <input type="file" name="new_photos[]" class="form-control" multiple>
                            </div>

                            <button type="submit" class="btn btn-secondary">Update Banners</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.remove-photo').forEach(button => {
        button.addEventListener('click', function() {
            let bannerId = this.dataset.id;

            $.ajax({
                type: 'DELETE',
                url: `/banners/photo/${bannerId}`,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    // Show success message
                    let alertHtml = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${data.success}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    $('#kt_app_content_container').prepend(alertHtml);

                    // Optionally, remove the photo element from the DOM
                    $(`.remove-photo[data-id="${bannerId}"]`).closest('.col-md-4').remove();
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
    });
</script>

@endsection
