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

    $cars = Cars::with('category')->where('customer_id', $customerId)->get();
    $carAdResources = CarAdResource::collection($cars);
    $carsCount = $cars->count();

    $bikes = Bike::with('category')->where('customer_id', $customerId)->get();
    $bikeAdResources = BikeAdResource::collection($bikes);
    $bikesCount = $bikes->count();

    $houses = House::with('category')->where('customer_id', $customerId)->get();
    $houseAdResources = PropertyAdResource::collection($houses);
    $housesCount = $houses->count();

    $mobiles = Mobiles::with('category')->where('customer_id', $customerId)->get();
    $mobilesAdResources = MobileAdResource::collection($mobiles);
    $mobilesCount = $mobiles->count();

    $careers = Careers::with('category')->where('customer_id', $customerId)->get();
    $careerAdResources = CareerAdResource::collection($careers);
    $careersCount = $careers->count();

    $commercial = CommercialAd::with('category')->where('customer_id', $customerId)->get();
    $commercialAdResources = CommercialResource::collection($commercial);
    $commercialCount = $commercial->count();

    $totalAdsCount = $normalAdsCount + $carsCount + $bikesCount + $housesCount + $mobilesCount + $careersCount + $commercialCount;

    return response()->json([
        'normal_ads' => [
            'count' => $normalAdsCount,
            'data' => $normalAdResources,
        ],
        'car_ads' => [
            'count' => $carsCount,
            'data' => $carAdResources,
        ],
        'bikes' => [
            'count' => $bikesCount,
            'data' => $bikeAdResources,
        ],
        'houses' => [
            'count' => $housesCount,
            'data' => $houseAdResources,
        ],
        'mobiles' => [
            'count' => $mobilesCount,
            'data' => $mobilesAdResources,
        ],
        'careers' => [
            'count' => $careersCount,
            'data' => $careerAdResources,
        ],
        'commercials' => [
            'count' => $commercialCount,
            'data' => $commercialAdResources,
        ],
        'total_count' => $totalAdsCount, // Total count of all ads
    ], 200);
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
