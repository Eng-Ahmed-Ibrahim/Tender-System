@extends('admin.index')
@section('content')


<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
    <thead>
        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
            <th>{{ __('Bill ID') }}</th>
            <th>{{ __('Amount') }}</th>
            <th>{{ __('Due Date') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
    </thead>
    <tbody class="fw-semibold text-gray-600">
        @foreach ($customer->bills as $bill)
        <tr>
            <td>{{ $bill->id }}</td>
            <td>{{ $bill->amount }}</td>
            <td>{{ $bill->due_date }}</td>
            <td>
                <a href="{{ route('bills.show', $bill->id) }}" class="btn btn-secondary">{{ __('View') }}</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


@endsection