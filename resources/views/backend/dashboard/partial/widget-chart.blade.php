

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
// Prepare the total ads data
$totalAdsData = [];

foreach ($countries as $country) {
    // Only include countries with ads
    if ($country->normal_ads_count > 0 || $country->commercial_ads_count > 0) {
        $totalAdsData[] = [
            'country' => $country->name,
            'normal_ads' => $country->normal_ads_count,
            'commercial_ads' => $country->commercial_ads_count,
            'total_ads' => $country->normal_ads_count + $country->commercial_ads_count,
        ];
    }
}

// Calculate the growth percentage if applicable
$previousTotalAds = array_sum(array_column($totalAdsData, 'total_ads')) - 20; // Example previous total
$currentTotalAds = array_sum(array_column($totalAdsData, 'total_ads'));
$growthPercentage = (($currentTotalAds - $previousTotalAds) / $previousTotalAds) * 100;
@endphp


<div class="container mt-5">
    @if (count($totalAdsData) > 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="m-0">Total Ads Overview</h5>
                        <span class="badge bg-success">
                            <i class="ki-duotone ki-arrow-up fs-5 text-white ms-n1"></i>
                            +{{ number_format($growthPercentage, 2) }}%
                        </span>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">Total Ads: <strong>{{ array_sum(array_column($totalAdsData, 'total_ads')) }}</strong></h6>
                        <canvas id="adsOverviewChart" class="min-h-auto"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="m-0">Detailed Ads by Country</h5>
                    </div>
                    <div class="card-body">
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

        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="m-0">Ads Overview by Type</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="adsTypeChart" class="min-h-auto"></canvas>
                    </div>
                </div>
            </div>
        </div>

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

            // Create the ads overview chart
            var adsOverviewChart = new Chart(adsOverviewCtx, {
                type: 'bar',
                data: adsOverviewChartData,
                options: {
                    indexAxis: 'y',
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

            // Get the canvas context for the ads type chart
            var adsTypeCtx = document.getElementById('adsTypeChart').getContext('2d');

            // Prepare data for ads type chart
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

            // Create the ads type chart
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

