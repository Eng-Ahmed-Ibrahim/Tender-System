@extends('admin.index')

@section('content')

 
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Navbar-->
      
        <!--end::Navbar-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title fs-3 fw-bold">{{__('Permissions')}}</div>
                <!--end::Card title-->
            </div>

            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

            <!--end::Card header-->
            <!--begin::Form-->

            <div class="card-body">
            

                <div id="success-message" class="alert alert-success mt-3" style="display:none;"></div>
                            <form id="permission-form">
                @csrf
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                    <div id="name-error" class="text-danger"></div>
                    <div class="form-group">
                        <label for="name">{{ __('Group')}}</label>
                        <input type="text" name="group_name" id="group-name" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Create Permission') }}</button>
            </form>

            <!-- Table displaying existing permissions -->
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Group') }}</th>
                    </tr>
                </thead>
                <tbody id="permissions-table">
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->group_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $('#permission-form').on('submit', function(e) {
                e.preventDefault();
    
                var form = $(this);
                var formData = form.serialize();
                var url = '{{ route('permissions.store') }}';
    
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    success: function(response) {

                        $('#permissions-table').append('<tr><td>' + response.id + '</td><td>' + response.name + '</td><td>'+response.group_name+'</td></tr>');
                        form[0].reset();
                        $('#name-error').text('');
                        $('#success-message').text('Permission created successfully').show().delay(3000).fadeOut();
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $('#name-error').text(errors.name[0]);
                        }
                    }
                });
            });
        });
    </script>
    
@endsection
