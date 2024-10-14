
@extends('admin.index')
@section('content')

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!-- Displaying stats with graph -->
        welcome company {{auth()->user()->name}}



            </div>
        </div>
    </div>
</div>

@endsection

<!-- Including chart scripts -->
@section('js')


@endsection
