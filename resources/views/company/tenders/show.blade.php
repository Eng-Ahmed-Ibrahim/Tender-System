@extends('admin.index')

@section('content')
<div class="container">
    <h1>{{ $tender->title }}</h1>
    <p>{{ $tender->description }}</p>
    <p>End Date: {{ $tender->end_date }}</p>
    <p>Show Applicants: {{ $tender->show_applicants ? 'Yes' : 'No' }}</p>

    <h2>QR Code</h2>
    <div>
        {!! $qrCode !!} <!-- Display the QR code -->
    </div>
</div>
@endsection