<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card card-flush">
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <div class="card-title">
                    <h4>Commercial Ads</h4>                  
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
                            <th class="min-w-150px">Description</th>
                            <th class="min-w-150px">Image</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach($selectedCategory->house as $ad)
                        <tr>
                            <td>
                                @php
                                    $firstImage = $ad->images->first();
                                @endphp
                                @if($firstImage)
                                    <img src="{{ asset('storage/' . $firstImage->image) }}" alt="House Photo" style="height: 100px; object-fit: contain;">
                                @else
                                    <img src="https://via.placeholder.com/100x100" alt="Placeholder Image" style="height: 100px; object-fit: contain;">
                                @endif
                            </td>
                            <td>{{ $ad->title }}</td>
                            <td>{{ $ad->description }}</td>
                            <td>
                                <a href="{{ route('house.show', $ad->id) }}" class="btn btn-info btn-sm">View</a>
                                @if($ad->phone)
                                    <a href="tel:{{ $ad->phone }}" class="btn btn-primary btn-sm">Call</a>
                                @endif
                                @if($ad->whatsapp)
                                    <a href="https://wa.me/{{ $ad->whatsapp }}" class="btn btn-success btn-sm" target="_blank">WhatsApp</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>