@extends('admin.index')
@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;
@endphp
@section('css')
<style>
.tender-header {
    background: linear-gradient(135deg, #1a365d 0%, #2563eb 100%);
    border-radius: 1.5rem;
    padding: 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.tender-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 300px;
    height: 300px;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 100%);
    border-radius: 50%;
    transform: translate(100px, -100px);
}

.content-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
}

.content-card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    transform: translateY(-3px);
}

.countdown-section {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 1rem;
    padding: 1.5rem;
    backdrop-filter: blur(10px);
    margin-top: 1.5rem;
}

.countdown-item {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    padding: 1rem;
    text-align: center;
    transition: all 0.3s ease;
}

.countdown-item h3 {
    color: white;
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    transition: transform 0.2s ease, opacity 0.2s ease;
}

.countdown-item small {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

@keyframes pulseWarning {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
    50% { transform: scale(1.03); box-shadow: 0 0 0 10px rgba(245, 158, 11, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
}

@keyframes pulseExpired {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
    50% { transform: scale(1.03); box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
}

.countdown-warning {
    animation: pulseWarning 2s infinite;
    color: #f59e0b !important;
}

.countdown-expired {
    animation: pulseExpired 2s infinite;
    color: #ef4444 !important;
}

.tender-stats {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-item {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    padding: 1rem;
    flex: 1;
    text-align: center;
}

.stat-item h4 {
    font-size: 1.5rem;
    margin-bottom: 0.25rem;
    color: white;
}

.stat-item p {
    margin: 0;
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.875rem;
}

.simple-countdown {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    padding: 0.75rem 1.5rem;
    display: inline-flex;
    align-items: center;
    margin-top: 1rem;
}

.simple-countdown i {
    margin-right: 0.75rem;
    opacity: 0.7;
}

/* Rest of your existing styles... */
</style>
@endsection

@section('content')
<div class="container-fluid p-4">
    <!-- Tender Header -->
   <!-- Tender Header -->
<div class="tender-header text-white">
    <div class="row align-items-start">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h1 class="display-5 fw-bold mb-3">{{ $tender->title }}</h1>
                    <div class="d-flex flex-wrap gap-4 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-building me-2 opacity-75"></i>
                            <span>{{ $tender->company->name }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar me-2 opacity-75"></i>
                            <span>Created {{ Carbon::parse($tender->created_at)->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    
                    @if($tender->end_date > now() )
                    <form action="{{route('stopTender',$tender->id)}}" method="post">
                        @csrf
                    <button class="btn btn-danger {{ $tender->status == 0 ? 'disabled' : '' }}" type="submit">
                        <i class="fas fa-stop-circle me-2"></i>
                     
                    </button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- Simple Countdown -->
            <div class="simple-countdown" id="simple-countdown">
                <i class="fas fa-clock"></i>
                <span id="simple-countdown-text">Calculating...</span>
            </div>

            <!-- Description Preview -->
            <div class="mt-4">
                <p class="lead opacity-75 mb-0">
                    {!! Str::limit(strip_tags($tender->description), 150) !!}
                </p>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Detailed Countdown -->
            <div class="countdown-section">
                <h5 class="text-white mb-3">{{ __('Time Remaining') }}</h5>
                <div id="detailed-countdown" data-end="{{ $tender->end_date }}">
                    <div class="row g-3">
                        <div class="col-3">
                            <div class="countdown-item">
                                <h3 id="days">00</h3>
                                <small>{{ __('Days') }}</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="countdown-item">
                                <h3 id="hours">00</h3>
                                <small>{{ __('Hours') }}</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="countdown-item">
                                <h3 id="minutes">00</h3>
                                <small>{{ __('Min') }}</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="countdown-item">
                                <h3 id="seconds">00</h3>
                                <small>{{ __('Sec') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Badge -->
            @if($tender->status == 0)
            <div class="alert alert-danger mt-3 text-center">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ __('This tender has been stopped') }}
            </div>
            @endif
        </div>
    </div>
</div>


    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Tender Details -->
            <div class="content-card">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">{{ __('Tender Details') }}</h5>
                    <div class="tender-description mb-4">
                        {!! $tender->description !!}
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-section">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box me-3">
                                        <i class="fas fa-calendar-alt fa-2x text-primary opacity-75"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ __('End Date') }}</h6>
                                        <p class="mb-0">{{ \Carbon\Carbon::parse($tender->end_date)->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-section">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box me-3">
                                        <i class="fas fa-edit fa-2x text-success opacity-75"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ __('Edit Deadline') }}</h6>
                                        <p class="mb-0">
                                            @if($tender->edit_end_date)
                                                {{ \Carbon\Carbon::parse($tender->edit_end_date)->format('M d, Y') }}
                                            @else
                                                {{ __('Not specified') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applicants Section -->
            @if($tender->show_applicants)
            <div class="content-card">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center p-4">
                    <h5 class="mb-0">{{ __('Applicants') }}</h5>
                    <span class="badge bg-primary rounded-pill px-3 py-2">
                        {{ $tender->applicants->count() }} {{ __('Total') }}
                    </span>
                </div>
                <div class="card-body p-0">
                    @forelse($tender->applicants as $applicant)
                    <div class="applicant-card p-3 border-bottom">
                        <div class="row align-items-center">
                            <!-- Applicant Info -->
                            <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                                <div class="d-flex align-items-center">
                                    <div class="applicant-avatar me-3 text-center bg-primary text-white rounded-circle" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($applicant->name ?? 'U', 0, 2)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $applicant->name }}</h6>
                                        <p class="text-muted mb-0 small">{{ $applicant->email }}</p>
                                    </div>
                                </div>
                            </div>
        
                            <!-- Application Date -->
                            <div class="col-12 col-md-3 col-lg-2 text-muted small mb-3 mb-md-0">
                                <i class="fas fa-clock me-2"></i>
                                {{ \Carbon\Carbon::parse($applicant->pivot->created_at)->format('M d, Y H:i') }}
                            </div>
        
                            <!-- Files -->
                            <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                            
                                            <a href="{{ asset('storage/'. $applicant->files) }}" 
                                               class="file-badge text-decoration-none me-2 mb-2" 
                                               target="_blank">
                                                <i class="fas fa-file-alt me-1"></i>
                                            </a>
                                    </div>
                                @else
                                    <span class="badge bg-warning">{{ __('No files') }}</span>
                                @endif
                            </div>
        
                            <!-- Actions -->
                            <div class="col-12 col-md-3 col-lg-2 text-end">
                                <button class="btn btn-primary btn-sm px-3 rounded-pill"
                                        onclick="viewApplicant('{{ $applicant->id }}')">
                                    <i class="fas fa-eye me-2"></i>
                                    {{ __('View') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-users fa-3x text-muted"></i>
                        </div>
                        <h5>{{ __('No Applicants Yet') }}</h5>
                        <p class="text-muted">{{ __('There are no applications for this tender.') }}</p>
                    </div>
                    @endforelse
                </div>
            </div>
        @endif
        
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- QR Code -->
            @if($tender->qr_code)
            <div class="content-card">
                <div class="card-body p-4 text-center">
                    <div class="qr-container mb-3">
                        {!! $qrCode !!}
                    </div>
                    <button class="btn btn-light" onclick="downloadQR()">
                        <i class="fas fa-download me-2"></i>
                        {{ __('Download QR Code') }}
                    </button>
                </div>
            </div>
            @endif

            <!-- Timeline -->
            <div class="content-card">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="mb-0">{{ __('Timeline') }}</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <!-- Timeline Item -->
                        <div class="timeline-item mb-3">
                            <h6 class="mb-1">{{ __('Created') }}</h6>
                            <p class="text-muted mb-0 small">
                                {{ \Carbon\Carbon::parse($tender->created_at)->format('M d, Y H:i') }}
                            </p>
                        </div>
                        
                        <!-- Conditional Timeline Items -->
                        @if($tender->edit_end_date)
                        <div class="timeline-item mb-3">
                            <h6 class="mb-1">{{ __('Edit Deadline') }}</h6>
                            <p class="text-muted mb-0 small">
                                {{ \Carbon\Carbon::parse($tender->edit_end_date)->format('M d, Y H:i') }}
                            </p>
                        </div>
                        @endif
            
                        @if($tender->change_uploads)
                        <div class="timeline-item mb-3">
                            <h6 class="mb-1">{{ __('Upload Changes') }}</h6>
                            <p class="text-muted mb-0 small">
                                {{ \Carbon\Carbon::parse($tender->change_uploads)->format('M d, Y H:i') }}
                            </p>
                        </div>
                        @endif
            
                        <div class="timeline-item">
                            <h6 class="mb-1">{{ __('End Date') }}</h6>
                            <p class="text-muted mb-0 small">
                                {{ \Carbon\Carbon::parse($tender->end_date)->format('M d, Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div></div>

@push('scripts')
<script>
    
function updateCountdown() {
    const countdownElement = document.getElementById('detailed-countdown');
    const endDate = new Date(countdownElement.dataset.end).getTime();
    
    function updateSimpleCountdown(distance) {
        const simpleText = document.getElementById('simple-countdown-text');
        
        if (distance < 0) {
            simpleText.textContent = '{{ __("Tender Expired") }}';
            simpleText.style.color = '#ef4444';
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        
        if (days > 0) {
            simpleText.textContent = `${days} ${days === 1 ? 'day' : 'days'} ${hours} ${hours === 1 ? 'hour' : 'hours'} remaining`;
        } else if (hours > 0) {
            simpleText.textContent = `${hours} ${hours === 1 ? 'hour' : 'hours'} remaining`;
        } else {
            simpleText.textContent = 'Less than an hour remaining';
        }

        // Add warning color if less than 24 hours
        if (distance < 24 * 60 * 60 * 1000) {
            simpleText.style.color = '#f59e0b';
        }
    }

    function update() {
        const now = new Date().getTime();
        const distance = endDate - now;

        // Update both countdown displays
        updateSimpleCountdown(distance);

        const countdownItems = countdownElement.querySelectorAll('.countdown-item h3');

        if (distance < 0) {
            document.getElementById('days').textContent = '00';
            document.getElementById('hours').textContent = '00';
            document.getElementById('minutes').textContent = '00';
            document.getElementById('seconds').textContent = '00';
            
            countdownItems.forEach(item => {
                item.classList.add('countdown-expired');
            });
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        function updateDigit(element, value) {
            const currentValue = element.textContent;
            const newValue = value.toString().padStart(2, '0');
            
            if (currentValue !== newValue) {
                element.style.transform = 'translateY(-20px)';
                element.style.opacity = '0';
                
                setTimeout(() => {
                    element.textContent = newValue;
                    element.style.transform = 'translateY(20px)';
                    
                    requestAnimationFrame(() => {
                        element.style.transform = 'translateY(0)';
                        element.style.opacity = '1';
                    });
                }, 200);
            }
        }

        updateDigit(document.getElementById('days'), days);
        updateDigit(document.getElementById('hours'), hours);
        updateDigit(document.getElementById('minutes'), minutes);
        updateDigit(document.getElementById('seconds'), seconds);

        if (distance < 24 * 60 * 60 * 1000) {
            countdownItems.forEach(item => {
                item.classList.add('countdown-warning');
            });
        }
    }

    update();
    const interval = setInterval(update, 1000);
    return () => clearInterval(interval);
}

document.addEventListener('DOMContentLoaded', function() {
    updateCountdown();
});

function downloadQR() {
    const qrSvg = document.querySelector('.qr-container svg');
    if (!qrSvg) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'QR Code not found!'
        });
        return;
    }

    // Create canvas
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    
    // Set canvas size (make it larger for better quality)
    canvas.width = 1024;
    canvas.height = 1024;
    
    // Create image from SVG
    const svgData = new XMLSerializer().serializeToString(qrSvg);
    const img = new Image();
    
    img.onload = function() {
        // Fill white background
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        
        // Draw QR code
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        
        // Convert to blob and download
        canvas.toBlob(function(blob) {
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'tender-qr.png';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }, 'image/png');
    };
    
    img.src = 'data:image/svg+xml;base64,' + btoa(svgData);
}
function stopTender(tenderId) {
    Swal.fire({
        title: '{{ __("Stop Tender") }}',
        text: '{{ __("Are you sure you want to stop this tender? This action cannot be undone.") }}',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '{{ __("Yes, stop tender") }}',
        cancelButtonText: '{{ __("Cancel") }}',
        confirmButtonColor: '#dc3545',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: '{{ __("Processing") }}',
                html: '{{ __("Stopping tender...") }}',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Create and submit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/tenders/${tenderId}/stop`;
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
@endsection
