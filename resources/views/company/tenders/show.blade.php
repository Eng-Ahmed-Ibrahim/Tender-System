@extends('admin.index')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="display-4 mb-4">{{ $tender->title }}</h1>
            
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title text-primary">Tender Overview</h5>
                    <p class="lead">{!! $tender->description !!}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">{{ $tender->user->name }}</span>
                        <small class="text-muted">Created {{ $tender->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-success">End Date</h5>
                            <p class="card-text display-6">{{ $tender->end_date }}</p>
                            <p class="card-text"><small class="text-muted">{{ $tender->end_date }}</small></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-info">Location</h5>
                            <p class="card-text display-6">{{ $tender->city ?? 'N/A' }}</p>
                            @if($tender->qr_code)
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#qrCodeModal">
                                    View QR Code
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Detailed Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Description</dt>
                        <dd class="col-sm-8">{!!$tender->description !!}</dd>

                        <dt class="col-sm-4">Edit End Date</dt>
                        <dd class="col-sm-8">{{ $tender->edit_end_date ? $tender->edit_end_date: 'Not specified' }}</dd>

                        <dt class="col-sm-4">Change Uploads Date</dt>
                        <dd class="col-sm-8">{{ $tender->change_uploads ? $tender->change_uploads : 'Not specified' }}</dd>

                        <dt class="col-sm-4">Show Applicants</dt>
                        <dd class="col-sm-8">
                            <span class="badge {{ $tender->show_applicants ? 'bg-success' : 'bg-secondary' }}">
                                {{ $tender->show_applicants ? 'Yes' : 'No' }}
                            </span>
                        </dd>
                    </dl>
                </div>
            </div>

            @if($tender->show_applicants)
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Applicants</h5>
                    </div>
                    <div class="card-body">
                        {{-- Add code here to display applicants if you have that relationship set up --}}
                        <p class="text-muted">Applicant information will be displayed here.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@if($tender->qr_code)
    <!-- QR Code Modal -->
    <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrCodeModalLabel">QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">

                    {!!$qrCode!!}
                   
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    // Initialize all tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush