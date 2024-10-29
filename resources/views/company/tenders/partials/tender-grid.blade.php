@foreach($tenders as $tender)
<div class="col-xl-4 col-md-6">
    <div class="card h-100 border-0 shadow-sm rounded-4 hover-shadow-lg transition-all">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge bg-{{ \Carbon\Carbon::parse($tender->end_date)->isFuture() ? 'success' : 'danger' }} rounded-pill px-3 py-2">
                    {{ \Carbon\Carbon::parse($tender->end_date)->isFuture() ? 'Active' : 'Closed' }}
                </span>
                <div class="dropdown">
                    <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{ route('tenders.show', $tender->id) }}">
                            <i class="fas fa-eye me-2"></i>{{__('View Details')}}
                        </a>
                        <a class="dropdown-item" href="{{ route('tenders.edit', $tender->id) }}">
                            <i class="fas fa-edit me-2"></i>{{__('Edit')}}
                        </a>
                        <a class="dropdown-item show-qr-code" href="#" data-id="{{ $tender->id }}">
                            <i class="fas fa-qrcode me-2"></i>{{__('Show QR Code')}}
                        </a>
                    </div>
                </div>
            </div>

            <h5 class="card-title mb-3">{{ $tender->title }}</h5>
            <div class="mb-3 text-muted small">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-building me-2"></i>
                    {{ $tender->company->name }}
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-calendar-alt me-2"></i>
                    {{__('Ends')}}: {{ \Carbon\Carbon::parse($tender->end_date)->format('M d, Y') }}
                </div>
            </div>

            <div class="description-truncate mb-3">
                {!! $tender->description !!}
            </div>

            <div class="d-flex justify-content-between align-items-center mt-auto">
                <button class="btn btn-primary btn-sm rounded-pill px-3" 
                        onclick="window.location.href='{{ route('tenders.show', $tender->id) }}'">
                        {{__('View Details')}}
                </button>
                <span class="text-muted small">
                    <i class="fas fa-clock me-1"></i>
                    {{ \Carbon\Carbon::parse($tender->created_at)->diffForHumans() }}
                </span>
            </div>
        </div>
    </div>
</div>
@endforeach

@if($tenders->hasPages())
<div class="col-12">
    <div class="d-flex justify-content-center mt-5">
        {{ $tenders->links('pagination::bootstrap-5') }}
    </div>
</div>
@endif