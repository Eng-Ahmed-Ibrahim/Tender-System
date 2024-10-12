
@extends('admin.index')
@section('content')

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!-- Displaying stats with graph -->
                <div class="row">
                    @Include('backend.dashboard.partial.payment_partial')

                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title"><i class="fas fa-ad me-2"></i> {{ __('users')}}</h3>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title"><i class="fas fa-business-time me-2"></i> {{ __('companies')}}</h3>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title"><i class="fas fa-list me-2"></i> {{ __('tenders')}}</h3>
                                <p></p>
                            </div>
                        </div>
                    </div>

                </div>



            </div>
        </div>
    </div>
</div>

@endsection

<!-- Including chart scripts -->
@section('js')


@endsection
