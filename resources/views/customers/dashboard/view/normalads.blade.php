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
                            <th class="min-w-250px">Title</th>
                            <th class="min-w-150px">Price</th>
                            <th class="min-w-150px">Image</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach($selectedCategory->normalAds as $ad)
                            <tr>
                                <td>{{ $ad->title }}</td>
                                <td>{{ $ad->price }}</td>
                                <td>
                                    <img src="{{ asset('storage/'.$ad->photo) }}" alt="Normal Ad Image" style="width: 100px;">
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('showNormalAd',$ad->id) }}" class="btn btn-sm btn-light btn-active-light-primary btn-flex btn-center">
                                        Show
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>