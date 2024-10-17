@extends('admin.index')

@section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{__('All Tenders')}}</h1>
                </div>
            </div>
        </div>
        
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card card-flush">
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <div class="card-title">
                            <form action="{{ route('tenders.index') }}" method="GET" class="d-flex align-items-center">
                                <input type="text" name="search" class="form-control" placeholder="Search tenders..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary ml-2">Search</button>
                            </form>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ route('tenders.create')}}" class="btn btn-secondary">{{__('Create')}}</a>
                        </div>
                    </div>
                    
                    <div class="card-body pt-0">
                        <form action="{{ route('tenders.index') }}" method="GET" class="mb-5">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="date" name="start_date" class="form-control" placeholder="Start Date" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="end_date" class="form-control" placeholder="End Date" value="{{ request('end_date') }}">
                                </div>
                                @if(auth()->user()->role === 'admin')
                                <div class="col-md-3">
                                    <select name="company" class="form-control">
                                        <option value="">All Companies</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}" {{ request('company') == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-md-2">
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>

                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    @if(auth()->user()->role === 'admin')
                                    <th>Company</th>
                                    @endif
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Show Applicants</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tenders as $tender)
                                <tr>
                                    <td>{{ $tender->id }}</td>
                                    <td>{{ $tender->title }}</td>
                                    <td>{{ $tender->first_insurance }}</td>
                                    <td>{{ $tender->last_insurance }}</td>
                                    <td>{!! $tender->description !!}</td>
                                    @if(auth()->user()->role === 'admin')
                                    <td>{{$tender->company->name}}</td>
                                    @endif
                                    <td>{{ $tender->end_date }}</td>
                                    <td>
                                        @if(\Carbon\Carbon::parse($tender->end_date)->isFuture())
                                            <span class="badge badge-success">Open</span>
                                        @else
                                            <span class="badge badge-danger">Closed</span>
                                        @endif
                                    </td>
                                    <td>{{ $tender->show_applicants ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <a href="{{ route('tenders.show', $tender->id) }}" class="btn btn-info">View</a>
                                        <a href="{{ route('tenders.edit', $tender->id) }}" class="btn btn-info">Edit</a>
                                        <button class="btn btn-primary show-qr-code" data-toggle="modal" data-target="#qrCodeModal" data-id="{{ $tender->id }}">Show QR Code</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        {{ $tenders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrCodeModalLabel">QR Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div id="qrCodeContainer">
                    <!-- QR Code will be displayed here -->
                </div>
                <!-- Add a Print button -->
                <button class="btn btn-primary mt-3" id="printQrCode">Print QR Code</button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Handle the click event on the Show QR Code button
    $('.show-qr-code').on('click', function() {
        var tenderId = $(this).data('id');

        // Make an AJAX request to get the QR code
        $.ajax({
            url: '/tenders/' + tenderId + '/qrcode', // Create this route in your web.php
            type: 'GET',
            success: function(response) {
                $('#qrCodeContainer').html(response); // Display the QR code in the modal
            },
            error: function() {
                $('#qrCodeContainer').html('<p>Error loading QR code.</p>'); // Handle errors
            }
        });
    });

    // Handle the print button click event
    $('#printQrCode').on('click', function() {
        var printContent = document.getElementById('qrCodeContainer').innerHTML;
        var originalContent = document.body.innerHTML;

        // Set up a temporary printing area
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;

        // Re-attach the event listeners after printing
        location.reload();
    });
});
</script>


@endsection

 