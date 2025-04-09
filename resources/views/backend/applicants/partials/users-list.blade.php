{{-- resources/views/backend/applicants/partials/applicant-list.blade.php --}}
<table class="table table-hover align-middle mb-0">
    <thead class="bg-light">
        <tr>
            <th class="ps-4">{{ __('Users') }}</th>
            <th>{{ __('Applications') }}</th>
            <th>{{ __('Latest Tender') }}</th>
            <th>{{ __('Company') }}</th>
            <th>{{ __('Files') }}</th>
            <th class="text-end pe-4">{{ __('Actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($applicants as $applicant)
            {{-- Same TR content as in the main view --}}
        @empty
            <tr>
                <td colspan="6" class="text-center py-5">
                    <img src="/images/no-data.svg" alt="No Data" style="width: 120px; margin-bottom: 1rem;">
                    <h4>{{ __('No Applicants Found') }}</h4>
                    <p class="text-muted">
                        {{ __('There are no applicants matching your search criteria.') }}
                    </p>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@if($applicants->hasPages())
<div class="d-flex justify-content-between align-items-center mt-4">
    <div class="text-muted">
        {{ __('Showing') }} {{ $applicants->firstItem() }} {{ __('to') }} {{ $applicants->lastItem() }}
        {{ __('of') }} {{ $applicants->total() }} {{ __('entries') }}
    </div>
    {{ $applicants->links('pagination::bootstrap-5') }}
</div>
@endif