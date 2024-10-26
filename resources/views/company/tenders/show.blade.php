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
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Applicants</h5>
                    <span class="badge bg-primary">Total: {{ $tender->applicants->count() }}</span>
                </div>
                <div class="card-body">
                    @if($tender->applicants->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Applicant</th>
                                        <th>Files</th>
                                        <th>Applied Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tender->applicants as $applicant)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-35px me-2">
                                                        <span class="symbol-label bg-light-primary">
                                                            {{ strtoupper(substr($applicant->name ?? 'U', 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-800 fw-bold">{{ $applicant->name }}</span>
                                                        <br>
                                                        <small class="text-muted">{{ $applicant->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($applicant->pivot->files)
                                                    @php
                                                        $fileArray = array_filter(explode(',', $applicant->pivot->files));
                                                        $fileCount = count($fileArray);
                                                    @endphp
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-light-info dropdown-toggle" 
                                                                type="button" 
                                                                data-bs-toggle="dropdown">
                                                            Files ({{ $fileCount }})
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            @foreach($fileArray as $file)
                                                                <li>
                                                                    <a class="dropdown-item" 
                                                                       href="{{ asset('storage/' . trim($file)) }}" 
                                                                       target="_blank">
                                                                        <i class="ki-duotone ki-file fs-5 me-2">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                        {{ basename(trim($file)) }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <span class="badge badge-light-warning">No files</span>
                                                @endif
                                            </td>
                                            <td>{{ $applicant->pivot->created_at->format('M d, Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" 
                                                            class="btn btn-sm btn-icon btn-light-primary" 
                                                            title="Send Message"
                                                            onclick="sendMessage('{{ $applicant->id }}')">
                                                        <i class="ki-duotone ki-message-text-2 fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
    
                                        <!-- Details Modal for each applicant -->
                                        <div class="modal fade" id="detailsModal{{ $applicant->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Application Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! $applicant->pivot->application_details !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="ki-duotone ki-people fs-3hx text-muted mb-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                            <p class="text-muted">No applicants yet</p>
                        </div>
                    @endif
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
// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});

// Function to handle sending messages to applicants
function sendMessage(userId) {
    // You can implement your message sending functionality here
    // For example, opening a chat modal or redirecting to a messaging page
    console.log('Sending message to user:', userId);
}

// Initialize any dropdowns
var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
    return new bootstrap.Dropdown(dropdownToggleEl)
});
</script>
@endpush