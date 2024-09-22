<?php

namespace App\Http\Controllers\Api\Search;

use App\Models\Banner;
use App\Models\Category;
use App\Models\PopUpAds;
use App\Models\NormalAds;
use App\Models\CommercialAd;
use Illuminate\Http\Request;
use Modules\Car\Models\Cars;
use Modules\Bike\Models\Bike;
use Modules\House\Models\House;
use Modules\Career\Models\Careers;
use Modules\Car\Models\CarCategory;
use App\Http\Controllers\Controller;
use Modules\Bike\Models\BikeCategory;
use Modules\Electronics\Models\Mobiles;
use Modules\House\Models\HouseCategory;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\NormalAdResource;
use Modules\Career\Models\CareerCategory;
use App\Http\Resources\CommercialResource;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
    }
   
    
    
public function searchAds(Request $request)
{
    $searchTerm = $request->input('title');

    // Query for active ads
    $adsQuery = NormalAds::where('is_active', 1);
    $commercialQuery = CommercialAd::where('is_active', 1);
    
    // Query for categories with a parent_id
    $SubcategoriesQuery = Category::whereNotNull('parent_id');
    $MaincategoriesQuery = Category::whereNull('parent_id');
    
    // Apply search term filter if provided
    if ($searchTerm !== null) {
        $adsQuery->where('title', 'like', "%{$searchTerm}%");
        $commercialQuery->where('title', 'like', "%{$searchTerm}%");
        $SubcategoriesQuery->where('title', 'like', "%{$searchTerm}%");
        $MaincategoriesQuery->where('title', 'like', "%{$searchTerm}%");
    }

    // Fetch the results
    $ads = $adsQuery->get();
    $commercial = $commercialQuery->get();
    $subcategories = $SubcategoriesQuery->get();
    $maincategories = $MaincategoriesQuery->get();

    // Return response with resources
    return response()->json([
    'Maincategories' => CategoryResource::collection($maincategories),
    'Subcategories' => CategoryResource::collection($subcategories),
    'Normal' => NormalAdResource::collection($ads),
    'commercial' => CommercialResource::collection($commercial)
    ]);
}

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
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
