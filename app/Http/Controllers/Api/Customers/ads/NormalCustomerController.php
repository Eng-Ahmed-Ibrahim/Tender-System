<?php

namespace App\Http\Controllers\Api\customers\ads;

use App\Models\NormalAds;
use App\Models\CommercialAd;
use Illuminate\Http\Request;
use Modules\Car\Models\Cars;
use Modules\Bike\Models\Bike;
use Modules\House\Models\House;
use Modules\Career\Models\Careers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CarAdResource;
use App\Http\Resources\BikeAdResource;
use Modules\Electronics\Models\Mobiles;
use App\Http\Resources\CareerAdResource;
use App\Http\Resources\MobileAdResource;
use App\Http\Resources\NormalAdResource;
use App\Http\Resources\CommercialResource;
use App\Http\Resources\PropertyAdResource;

class NormalCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $customer = Auth::guard('customer')->user();

    if (!$customer) {
        return response()->json([
            'message' => 'Customer not authenticated.'
        ], 401);
    }

    $customerId = $customer->id;

    $normalAds = NormalAds::with('category')->where('customer_id', $customerId)->get();
    $normalAdResources = NormalAdResource::collection($normalAds);
    $normalAdsCount = $normalAds->count();



    $commercial = CommercialAd::where('customer_id', $customerId)->get();
    $commercialAdResources = CommercialResource::collection($commercial);
    $commercialCount = $commercial->count();

    $totalAdsCount = $normalAdsCount + $commercialCount;

    return response()->json([
        'normal_ads' => [
            'count' => $normalAdsCount,
            'data' => $normalAdResources,
     
        'commercials' => [
            'count' => $commercialCount,
            'data' => $commercialAdResources,
        ],
        'total_count' => $totalAdsCount, 
    ], 200]);
}

    
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
