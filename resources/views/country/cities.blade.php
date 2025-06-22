@extends('admin.index')

@section('content')
<style>
    .flex-root {
    flex: 0;
    margin-top: 0;
}
</style>
<div class="container mt-4">
    <div class="d-flex justify-content-between">
        <h3>{{ __('Cities') }}</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCityModal">{{ __('Add City') }}</button>
    </div>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Name Ar') }}</th>
                <th>{{ __('Country') }}</th>
                <th style="width: 30%">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cities as $index => $city)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $city->name }}</td>
                    <td>{{ $city->name_ar }}</td>
                    <td>{{ $city->country->name }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" 
                            data-bs-toggle="modal"
                            data-bs-target="#editCityModal"
                            data-id="{{ $city->id }}"
                            data-name="{{ $city->name }}"
                            data-name_ar="{{ $city->name_ar }}"
                            data-country="{{ $city->country_id }}"
                        >{{ __('Edit') }}</button>
                        <form method="POST" action="{{ route('admin.city.destroy', $city->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add City Modal -->
<div class="modal fade" id="addCityModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.city.store') }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header"><h5>{{ __('Add City') }}</h5></div>
            <div class="modal-body">
                <input name="name" class="form-control mb-3" placeholder="{{ __('Name') }}" required>
                <input name="name_ar" class="form-control mb-3" placeholder="{{ __('Name Ar') }}" required>
                <select name="country_id" class="form-control" required>
                    <option value="">{{ __('Select Country') }}</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">{{ __('Save') }}</button>
            </div>
        </div>
    </form>
  </div>
</div>

<!-- Edit City Modal -->
<div class="modal fade" id="editCityModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" id="editCityForm">
        @csrf
        @method('PUT')
        <div class="modal-content">
            <div class="modal-header"><h5>{{ __('Edit City') }}</h5></div>
            <div class="modal-body">
                <input name="name" id="edit-name" class="form-control mb-3" required>
                <input name="name_ar" id="edit-name_ar" class="form-control mb-3" required>
                <select name="country_id" id="edit-country" class="form-control" required>
                    <option value="">{{ __('Select Country') }}</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success">{{ __('Update') }}</button>
            </div>
        </div>
    </form>
  </div>
</div>

@section('js')
<script>
    const editModal = document.getElementById('editCityModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const name_ar = button.getAttribute('data-name_ar');
        const country = button.getAttribute('data-country');

        document.getElementById('edit-name').value = name;
        document.getElementById('edit-name_ar').value = name_ar;
        document.getElementById('edit-country').value = country;

        document.getElementById('editCityForm').action = `/admin/cities/${id}`;
    });
</script>
@endsection

@endsection
