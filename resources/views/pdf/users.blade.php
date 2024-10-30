<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle" style="width: 100%; border-collapse: collapse;">
                <thead class="bg-light">
                    <tr>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">{{ __('User') }}</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">{{ __('Contact') }}</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">{{ __('Role') }}</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">{{ __('Status') }}</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">{{ __('Joined Date') }}</th>
                        <th style="padding: 12px; border: 1px solid #dee2e6;">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td style="padding: 12px; border: 1px solid #dee2e6;">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3" style="width: 40px; height: 40px;">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle w-100 h-100">
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center w-100 h-100 text-secondary fw-bold">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 12px; border: 1px solid #dee2e6;">
                            <div>
                                <div class="mb-1">
                                    <i class="fas fa-phone-alt text-muted me-2"></i>
                                    <span>{{ $user->phone ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                    <span>{{ $user->address ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 12px; border: 1px solid #dee2e6;">
                            {{ $user->role ?? 'N/A' }}
                        </td>
                        <td style="padding: 12px; border: 1px solid #dee2e6;">
                            @php
                                $statusClass = [
                                    'active' => 'success',
                                    'inactive' => 'warning',
                                    'suspended' => 'danger'
                                ][$user->status ?? 'inactive'];
                            @endphp
                            <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }}">
                                {{ __(ucfirst($user->status ?? 'Inactive')) }}
                            </span>
                        </td>
                        <td style="padding: 12px; border: 1px solid #dee2e6;">
                            <div>
                                {{ $user->created_at->format('M d, Y') }}
                                <div class="text-muted small">
                                    {{ $user->created_at->format('h:i A') }}
                                </div>
                            </div>
                        </td>
                        <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">
                            <!-- Actions are not necessary in PDF, consider leaving it out -->
                            N/A
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4" style="border: 1px solid #dee2e6;">
                            <div class="text-muted">
                                <i class="fas fa-users fa-2x mb-3"></i>
                                <p>{{ __('No users found') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .card {
            border: none;
            margin: 0;
            padding: 0;
        }
        .table {
            border: 1px solid #dee2e6;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            color: #000;
        }
        /* Hides elements that are not necessary in PDF */
        .dropdown, .btn {
            display: none !important;
        }
    }
</style>
