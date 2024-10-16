@extends('admin.index')

@section('content')

<style>

    .user-info {
        display: flex;
        align-items: center;
    }
    
    .user-avatar img {
        width: 40px; /* Adjust size as needed */
        height: 40px; /* Adjust size as needed */
        border-radius: 50%; /* Make the image circular */
        margin-right: 10px; /* Add spacing between image and name */
    }
    
    .card {
        margin-top: 20px;
    }

</style>

<!-- Include SweetAlert CSS and JavaScript -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@10" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{__('All Tenders')}}</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
               
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
        
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Category-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                                                                    </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Add customer-->
                            <a href="{{ route('tenders.create')}}" class="btn btn-secondary">{{__('Create')}}</a>
                            <!--end::Add customer-->
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">

<div class="card">



        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>End Date</th>
                        <th>Show Applicants</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tenders as $tender)
                    <tr>
                        <td>{{ $tender->id }}</td> <!-- ID added here -->
                        <td>{{ $tender->title }}</td>
                        <td>{{ $tender->description }}</td>
                        <td>{{ $tender->end_date }}</td>
                        <td>{{ $tender->show_applicants ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('tenders.show', $tender->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('tenders.edit', $tender->id) }}" class="btn btn-info">edit</a>
                            <button class="btn btn-primary show-qr-code" data-toggle="modal" data-target="#qrCodeModal" data-id="{{ $tender->id }}">Show QR Code</button>
                            <!-- QR Code Modal -->

                        </td>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
</div>



                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
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
