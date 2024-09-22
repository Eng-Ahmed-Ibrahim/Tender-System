@extends('customers.index')

@section('content')
<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card card-flush">
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <div class="card-title">
                    <h4>Normal Ads</h4>                  
                </div>
                <div class="card-toolbar">
                    <!-- Additional toolbar items if needed --> 
                </div>
            </div>
            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-150px">Title</th>
                            <th class="min-w-70px">Category</th>
                            <th class="min-w-70px">Price</th>
                            <th class="min-w-70px">Status</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach($ads as $ad)
                        <tr>
                            <td>{{ $ad->title }}</td>
                          
                           
                            <td>
                                @if($ad->category)
                                    {{ $ad->category->title }}
                                @else
                                    Not assigned
                                @endif
                            </td>
                            <td></td>
                            <td>
                                @if($ad->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Not Active</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <!-- Dropdown -->
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('ads.edit', $ad->id) }}">Edit</a>
                                        </li>
                                      
                                        <li>
                                            <form action="{{ route('ads.destroy', $ad->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
