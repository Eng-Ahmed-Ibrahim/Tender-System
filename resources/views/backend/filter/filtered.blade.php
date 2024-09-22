@extends('admin.index')

@section('content')
<div class="container">
    <h2>Filtered Ads for Category ID: {{ $cat_id }}</h2>

    @if($normalAds->isEmpty())
        <p>No ads found based on your filter criteria.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Features</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($normalAds as $ad)
                    <tr>
                        <td>{{ $ad->title }}</td>
                        <td>{{ $ad->price }}</td>
                        <td>{{ $ad->model }}</td>
                        <td>{{ $ad->year }}</td>
                        <td>
                            @if($ad->features && $ad->features->count())
                                <ul>
                                    @foreach($ad->features as $feature)
                                        <li>{{ $feature->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span>No features available</span>
                            @endif
                        </td>
                        <td>{{ $ad->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
