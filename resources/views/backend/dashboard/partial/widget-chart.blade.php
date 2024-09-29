

@php
// Fetch countries along with counts of NormalAds and CommercialAds
$countries = \App\Models\Country::withCount([
    'NormalAds' => function ($query) {
        $query->withoutGlobalScopes();
    },
    'CommercialAds' => function ($query) {
        $query->withoutGlobalScopes();
    }
])
->where(function($query) {
    $query->whereHas('NormalAds', function ($q) {
        $q->withoutGlobalScopes();
    })
    ->orWhereHas('CommercialAds', function ($q) {
        $q->withoutGlobalScopes();
    });
})
->get();
$totalAdsData = [];

foreach ($countries as $country) {
    if ($country->normal_ads_count > 0 || $country->commercial_ads_count > 0) {
        $totalAdsData[] = [
            'country' => $country->name,
            'normal_ads' => $country->normal_ads_count,
            'commercial_ads' => $country->commercial_ads_count,
            'total_ads' => $country->normal_ads_count + $country->commercial_ads_count,
        ];
    }
}

$previousTotalAds = array_sum(array_column($totalAdsData, 'total_ads')) - 20; // Example previous total
$currentTotalAds = array_sum(array_column($totalAdsData, 'total_ads'));
$growthPercentage = (($currentTotalAds - $previousTotalAds) / $previousTotalAds) * 100;
@endphp


<div class="container mt-5">
    @if (count($totalAdsData) > 0)
        
        
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Category-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <h5 class="m-0">Detailed Ads by Country</h5>
                    </div>
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                                <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Country</th>
                                    <th>Normal Ads</th>
                                    <th>Commercial Ads</th>
                                    <th>Total Ads</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($totalAdsData as $data)
                                    <tr>
                                        <td>{{ $data['country'] }}</td>
                                        <td>{{ $data['normal_ads'] }}</td>
                                        <td>{{ $data['commercial_ads'] }}</td>
                                        <td>{{ $data['total_ads'] }}</td>
                                        <td>{{ number_format(($data['total_ads'] / array_sum(array_column($totalAdsData, 'total_ads'))) * 100, 2) }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Category-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <h5 class="m-0">Ads Overview by Type</h5>
                    </div>
                    <div class="card-body">

                        <canvas id="adsTypeChart" class="min-h-auto"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <canvas id="adsOverviewChart"></canvas>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Get the canvas context for the ads overview chart
            var adsOverviewCtx = document.getElementById('adsOverviewChart').getContext('2d');
            
            // Prepare data for ads overview chart
            var adsOverviewChartData = {
                labels: [
                    @foreach($totalAdsData as $data)
                        "{{ $data['country'] }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Total Ads',
                    data: [
                        @foreach($totalAdsData as $data)
                            {{ $data['total_ads'] }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderWidth: 1
                }]
            };

   

            var adsTypeCtx = document.getElementById('adsTypeChart').getContext('2d');

            var adsTypeChartData = {
                labels: [
                    @foreach($totalAdsData as $data)
                        "{{ $data['country'] }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Normal Ads',
                    data: [
                        @foreach($totalAdsData as $data)
                            {{ $data['normal_ads'] }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Commercial Ads',
                    data: [
                        @foreach($totalAdsData as $data)
                            {{ $data['commercial_ads'] }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(255, 206, 86, 0.5)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }]
            };

            var adsTypeChart = new Chart(adsTypeCtx, {
                type: 'bar',
                data: adsTypeChartData,
                options: {
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Ads'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Countries'
                            }
                        }
                    },
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @else
        <div class="alert alert-warning">
            <strong>No ads available for the selected countries.</strong>
        </div>
    @endif
</div>

