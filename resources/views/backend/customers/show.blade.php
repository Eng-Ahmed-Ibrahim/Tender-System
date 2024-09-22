@extends('admin.index')

@section('content')
<div class="container">
    <h1>Show {{ class_basename($model) }}</h1>

    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $model->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $model->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $model->email }}</td>
            </tr>
            <tr>
                <th>Email Verified At</th>
                <td>{{ $model->email_verified_at }}</td>
            </tr>
            <tr>
                <th>Password</th>
                <td>******</td> <!-- Hidden for security reasons -->
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $model->phone }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $model->address }}</td>
            </tr>
            <tr>
                <th>Is Active</th>
                <td>{{ $model->is_active ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th>Remember Token</th>
                <td>{{ $model->remember_token }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $model->created_at }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $model->updated_at }}</td>
            </tr>
        </table>
    </div>

    <a href="{{ route('customers.index') }}" class="btn btn-primary">Back to List</a>
</div>
@endsection

                         
