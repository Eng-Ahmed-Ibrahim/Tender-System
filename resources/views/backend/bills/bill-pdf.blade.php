<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Invoice') }}</title>

</head>
<body>
    @php
    $configuration = \App\Models\Configuration::first();
    
    @endphp        
    
    
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card">
                <div class="card-body p-lg-20">
                    <div class="d-flex flex-column flex-xl-row">
                        <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                            <div class="mt-n1">
                                <div class="d-flex flex-stack pb-10">
                                    <a href="#">
                                        <img alt="Logo" src="{{ asset('storage/' . $configuration->logo) }}" />
                                    </a>
                                    <a href="{{ route('invoice.print', $bill->id) }}" class="btn btn-success my-1">{{ __('Download') }}</a>
    
                                </div>
    
                                <div class="m-0">
                                    <div class="fw-bold fs-3 text-gray-800 mb-8">Invoice #{{ $bill->id }}</div>
                                    <div class="row g-5 mb-11">
                                        <div class="col-sm-6">
                                            <div class="fw-semibold fs-7 text-gray-600 mb-1">Start Date:</div>
                                            <div class="fw-bold fs-6 text-gray-800">{{ $bill->subscription_start_date }}</div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="fw-semibold fs-7 text-gray-600 mb-1">End Date:</div>
                                            <div class="fw-bold fs-6 text-gray-800 d-flex align-items-center flex-wrap">
                                                <span class="pe-2">{{ $bill->subscription_end_date }}</span>
                                                <span class="fs-7 text-danger d-flex align-items-center">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="row g-5 mb-12">
                                        <div class="col-sm-6">
                                            <div class="fw-semibold fs-7 text-gray-600 mb-1">Issue For:</div>
                                            <div class="fw-bold fs-6 text-gray-800">{{ $bill->customer->name }}</div>
                                            <div class="fw-semibold fs-7 text-gray-600">{{ $bill->customer->address }}</div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="fw-semibold fs-7 text-gray-600 mb-1">Issued By:</div>
                                            <div class="fw-bold fs-6 text-gray-800">CodeLab Inc.</div>
                                            <div class="fw-semibold fs-7 text-gray-600">9858 South 53rd Ave. <br />Matthews, NC 28104</div>
                                        </div>
                                    </div>
    
                                    <div class="flex-grow-1">
                                        <div class="table-responsive border-bottom mb-9">
                                            <table class="table mb-3">
                                                <thead>
                                                    <tr class="border-bottom fs-6 fw-bold text-muted">
                                                        <th class="min-w-175px pb-2">normal</th>
                                                        <th class="min-w-70px text-end pb-2">banner</th>
                                                        <th class="min-w-80px text-end pb-2">commercial</th>
                                                        <th class="min-w-100px text-end pb-2">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        <tr class="fw-bold text-gray-700 fs-5 text-end">
                                                            <td class="d-flex align-items-center pt-6">
                                                                <i class="fa fa-genderless  fs-2 me-2"></i>{{$bill->remaining_ads_normal}}
                                                            </td>
                                                            <td class="pt-6">{{ $bill->remaining_ads_banner }}</td>
                                                            <td class="pt-6">{{$bill->remaining_ads_commercial}}</td>
                                                            <td class="pt-6 text-dark fw-bolder">${{ number_format($bill->amount, 2) }}</td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
    
                                        <div class="d-flex justify-content-end">
                                            <div class="mw-300px">
                                                <div class="d-flex flex-stack mb-3">
                                                    <div class="fw-semibold pe-10 text-gray-600 fs-7">Subtotal:</div>
                                                    <div class="text-end fw-bold fs-6 text-gray-800">${{ number_format($bill->amount, 2) }}</div>
                                                </div>
                                                <div class="d-flex flex-stack mb-3">
                                                    <div class="fw-semibold pe-10 text-gray-600 fs-7">VAT 0%</div>
                                                    <div class="text-end fw-bold fs-6 text-gray-800">0.00</div>
                                                </div>
                                                <div class="d-flex flex-stack mb-3">
                                                    <div class="fw-semibold pe-10 text-gray-600 fs-7">Subtotal + VAT</div>
                                                    <div class="text-end fw-bold fs-6 text-gray-800">${{ number_format($bill->amount, 2) }}</div>
                                                </div>
                                                <div class="d-flex flex-stack">
                                                    <div class="fw-semibold pe-10 text-gray-600 fs-7">Total</div>
                                                    <div class="text-end fw-bold fs-6 text-gray-800">${{ number_format($bill->amount, 2) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="m-0">
                            <div class="d-print-none border border-dashed border-gray-300 card-rounded h-lg-100 min-w-md-350px p-9 bg-lighten">
                                <div class="mb-8">
                                    <span class="badge badge-light-success me-2">Approved</span>
                                </div>
    
                                <h6 class="mb-8 fw-bolder text-gray-600 text-hover-primary"> DETAILS</h6>
                                <div class="mb-6">
                                    <div class="fw-semibold text-gray-600 fs-7">email:</div>
                                    <div class="fw-bold text-gray-800 fs-6">{{$bill->customer->email}}</div>
                                </div>
                            
                                <div class="mb-15">
                                    <div class="fw-semibold text-gray-600 fs-7">bills Date:</div>
                                    <div class="fw-bold fs-6 text-gray-800 d-flex align-items-center">
                                        <span class="fs-7 text-danger d-flex align-items-center">
                                            <span class="bullet bullet-dot bg-danger mx-2"></span> {{ $bill->due_date }} 
                                        </span>
                                    </div>
                                </div>
    
                                <h6 class="mb-8 fw-bolder text-gray-600 text-hover-primary">PROJECT OVERVIEW</h6>
                                <div class="mb-6">
                                    <div class="fw-semibold text-gray-600 fs-7">Plan Name</div>
                                    <div class="fw-bold fs-6 text-gray-800">{{ $bill->customerSubscription->subscriptionPlan->name }}
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <div class="fw-semibold text-gray-600 fs-7">Completed By:</div>
                                    <div class="fw-bold text-gray-800 fs-6">HyperSale</div>
                                </div>
                                <div class="m-0">
                                    <div class="fw-semibold text-gray-600 fs-7">Signtures:</div>
                                    <div class="fw-bold fs-6 text-gray-800 d-flex align-items-center">HyperSale
                                        <span class="fs-7 text-success d-flex align-items-center">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
