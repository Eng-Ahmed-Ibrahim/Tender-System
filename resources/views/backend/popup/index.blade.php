@extends('admin.index')
@section('content')

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a href="{{ route('popup.create') }}" class="btn btn-sm fw-bold btn-secondary">{{__('Add Popup')}}</a>
                    </div>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
            
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Products Table-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('PopUp')}}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                           
                            <thead>
                                <tr>
                                    <th>{{__('Title')}}</th>
                                    <th>{{__('Description')}}</th>
                                    <th>{{__('Price')}}</th>
                                    <th>{{__('Photo')}}</th>
                                    <th>{{__('Category')}}</th> 
                                    <th>{{__('Status')}}</th> 
                                    <th>{{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($PopUpAds as $ad)
                                    <tr>
                                        <td>{{ $ad->name }}</td>
                                        <td>{{ $ad->price }}</td>
                                        <td>{{ $ad->description }}</td>
                                        <td>
                                            @if($ad->photo)
                                                <img src="{{ asset('storage/' . $ad->photo) }}" alt="{{ $ad->title }}" style="width: 100px; height: auto;">
                                            @else
                                                No Photo
                                            @endif
                                        </td>
                                        <td>
                                            @if($ad->category)
                                                {{ $ad->category->title }}
                                            @else
                                            {{__('No Category')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($ad->is_active)
                                                <span class="badge bg-success">{{__('Active')}}</span>
                                            @else
                                                <span class="badge bg-danger">{{__('Not Active')}}</span>
                                            @endif
                                        </td>
                                        <td>

                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    {{__('Actions')}}
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('popup.edit',$ad->id)}}">{{__('Edit')}}</a>
                                                    </li>
                                                  
                                                    <li>
                                                        <form action="{{ route('popup.destroy',$ad->id)}}" method="POST" class="d-inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">{{__('Delete')}}</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('popup.toggleStatus', $ad->id) }}" method="POST" class="d-inline-block">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                @if($ad->is_active)
                                                                {{__('Mark as Not Active')}}
                                                                @else
                                                                {{__('Mark as Active')}}
                                                                @endif
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>


                        </table>
                        <!-- Pagination -->
                     
                    </div>
                </div>
                <!--end::Products Table-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>

@endsection
