@extends('admin.index')
@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-4">{{ $tender->title }}</h1>
            <div class="prose max-w-none mb-6">
                {!! $tender->description !!}
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-semibold mb-2">Tender Details</h2>
                    <p><strong>End Date:</strong> {{ $tender->end_date }}</p>
                    <p><strong>Show Applicants:</strong> {{ $tender->show_applicants ? 'Yes' : 'No' }}</p>
                </div>
                <div>
                    <h2 class="text-xl font-semibold mb-2">QR Code</h2>
                    <div class="bg-gray-100 p-4 rounded-lg inline-block">
                        {!! $qrCode !!}
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('tenders.edit', $tender->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Edit Tender
                </a>
            </div>
        </div>
    </div>
</div>
@endsection