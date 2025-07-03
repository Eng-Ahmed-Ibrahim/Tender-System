@extends('admin.index')

@section('content')
    <style>
        .flex-end {
            display: flex;
            justify-content: flex-end;
        }

        td,
        th {
            text-align: center;
        }
    </style>
    <style>
        .flex-root {
            flex: 0;
            margin-top: 0;
        }
    </style>
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid" style="flex: 0 !important;">
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">

                    <!-- Button to open create modal -->
                    <div class="mb-4 flex-end">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                            {{ __('Add Country') }}
                        </button>
                    </div>

                    <!-- Table of countries -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title fs-3 fw-bold">{{ __('Countries') }}</div>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Name Ar') }}</th>
                                        <th>{{ __('Currency') }}</th>
                                        <th>{{ __('Currency Ar') }}</th>
                                        <th style="    width: 30%;">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($countries as $key => $country)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $country->name }}</td>
                                            <td>{{ $country->name_ar }}</td>
                                            <td>{{ $country->currency }}</td>
                                            <td>{{ $country->currency_ar }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info editBtn" data-id="{{ $country->id }}"
                                                    data-name="{{ $country->name }}" data-bs-toggle="modal"
                                                    data-name_ar="{{ $country->name_ar }}"
                                                    data-currency="{{ $country->currency }}"
                                                    data-currency_ar="{{ $country->currency_ar }}"
                                                    data-bs-target="#editModal">
                                                    {{ __('Edit') }}
                                                </button>

                                                <form action="{{ route('admin.country.delete', $country->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('{{ __('Are you sure?') }}')">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div></div>

                    <!-- Create Modal -->
                    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.country.store') }}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createModalLabel">{{ __('Add Country') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">{{ __('Name') }}</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="name_ar" class="form-label">{{ __('Name Ar') }}</label>
                                            <input type="text" name="name_ar" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="currency" class="form-label">{{ __('Currency') }}</label>
                                            <input type="text" name="currency" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="currency_ar" class="form-label">{{ __('Currency Ar') }}</label>
                                            <input type="text" name="currency_ar" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="editForm" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">{{ __('Edit Country') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" id="edit_id">
                                        <div class="mb-3">
                                            <label for="edit_name" class="form-label">{{ __('Name') }}</label>
                                            <input type="text" name="name" id="edit_name" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_name_ar" class="form-label">{{ __('Name Ar') }}</label>
                                            <input type="text" name="name_ar" id="edit_name_ar" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_currency" class="form-label">{{ __('Currency') }}</label>
                                            <input type="text" name="currency" id="edit_currency"
                                                class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_currency_ar" class="form-label">{{ __('Currency Ar') }}</label>
                                            <input type="text" name="currency_ar" id="edit_currency_ar"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.editBtn');


            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const name_ar = this.getAttribute('data-name_ar');
                    const currency = this.getAttribute('data-currency');
                    const currency_ar = this.getAttribute('data-currency_ar');


                    // Fill the edit modal
                    document.getElementById('edit_id').value = id;
                    document.getElementById('edit_name').value = name;
                    document.getElementById('edit_name_ar').value = name_ar;
                    document.getElementById('edit_currency').value = currency;
                    document.getElementById('edit_currency_ar').value = currency_ar;

                    // Set the form action dynamically
                    const form = document.getElementById('editForm');
                    form.action = `/admin/countries/update-counry/${id}`; // Adjust path if needed
                });
            });
        });
    </script>
@endsection
