@extends('admin.index')

@section('content')
<div class="container">

   
            <p><strong>{{ __('Remaining Ads (Normal):') }}</strong> {{ $bill->remaining_ads_normal }}</p>
            <p><strong>{{ __('Remaining Ads (Commercial):') }}</strong> {{ $bill->remaining_ads_commercial }}</p>
            <p><strong>{{ __('Remaining Ads (Popup):') }}</strong> {{ $bill->remaining_ads_popup }}</p>
            <p><strong>{{ __('Remaining Ads (Banners):') }}</strong> {{ $bill->remaining_ads_banners }}</p>
  


    <div class="card-body">
        <div class="container mb-5 mt-3">
            <div class="row mb-7">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="deposit" class="fw-bold fs-6 mb-2"></label>
                    </div>
                </div>
               
            </div>
 @php
$configuration = \App\Models\Configuration::first();

@endphp


    
            <div class="row d-flex align-items-center">
                <div class="col-xl-9">
                    <p class="mb-0" style="font-size: 20px;"> {{__('Bill Number')}}&gt;&gt; <strong>#{{$bill->id}}</strong></p>
                </div>
    
                <div class="col-xl-3 float-end text-end">
                    <a href="" class="btn btn-primary text-capitalize text-hover-white rounded-pill text-primary bg-white" style="padding:9px 25px; border:1px solid;" data-mdb-ripple-color="dark">{{__('Print')}} <i class="fas fa-print text-primary"></i></a>
                </div>
            </div>
            <hr>
            <div class="container content-to-download invoice" id="print_content" style="padding: 25px; border-radius: 16px; box-shadow: -4px 5px 14px 0px #0000000A;">
                <div class="col-12">

                    <div>
                        <img alt="Logo" src="" style="width: 70px" class="img-fluid app-sidebar-logo-default">
                        <h2 class="pt-4" style="font-size:28px;">{{$configuration->owner_name}}
                        </h2>
                        <p style="font-size:16px;"><strong>#{{$bill->id}}</strong></p>
                        <p style="font-size:16px;"><strong>{{$bill->due_date}}</strong></p>
                    </div>
                </div>
                <div class="row">
                    <div class="a">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td class="w-50">{{ __('Subscription Start Date:') }}<strong class="text-nowrap" >{{ $bill->subscription_start_date }}</strong></td>
                                    
                                </tr>
                                <tr>
                                    <td>{{ __('Subscription End Date:') }}</td>
                                    <td class="w-50"><strong class="text-nowrap">{{ $bill->subscription_end_date }}</strong></td>
                                 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="row">
                    <div class="">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th style=" color: var(--bs-secondary-color) !important">بيانات العميل</th>
                                    <th style=" color: var(--bs-secondary-color) !important">بيانات الاشتراك</th>
                                </tr>
                                <tr>
                                    <td>{{__('Customer Name')}} </td>
                                    <td>{{ $bill->customerSubscription->customer->name }}</td>
                                </tr>
                                <tr>
                                    <td>01122132355</td>
                                    <td>السعر: 1000 جنيه</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="details">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th style=" color: var(--bs-secondary-color) !important">{{ __('Subscription Plan:') }} الاشتراك</th>
                                    <th style=" color: var(--bs-secondary-color) !important">{{ $bill->subscriptionPlan->name }}</th>
                                </tr>
                                <tr>
                                    <td>SUB-1001</td>
                                    <td>ملاحظات إضافية حول الاشتراك.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <ul class="fw-bold list-unstyled total">
                            <li><span style=" color: var(--bs-secondary-color) !important" class="text-black me-4">المجموع:</span><span style="font-size: 18px; var(--bs-secondary-color) !important">1000 جنيه مصري</span></li>
                            <li id="total_after_depositeLi" class="d-none"><span style=" color: var(--bs-secondary-color) !important" class="fw-bold text-black me-4">الإجمالي بعد العربون:</span><span class="total_after_deposite" style="font-size: 18px; var(--bs-secondary-color) !important">800 جنيه مصري</span></li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <h6 style="text-align: center;">35# - 9 سبتمبر 2024</h6>
                    <h6 style="text-align: center; direction: ltr;">واتساب : 01017944214</h6>
                </div>
            </div>
        </div>
    </div>
    
@endsection
