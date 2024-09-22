<?php

namespace App\Http\Controllers\Api\Search;

use App\Models\Filter;
use App\Models\Category;
use App\Models\NormalAds;
use App\Services\Exchange;
use Illuminate\Http\Request;
use Modules\House\Models\Feature;
use Modules\Car\Models\CarFeature;
use Modules\Car\Models\Brand;
use App\Http\Controllers\Controller;
use Modules\Bike\Models\BikeFeature;
use App\Http\Resources\PopupResource;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\BannerResource;
use Illuminate\Support\Facades\Session;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\NormalAdResource;
use App\Http\Resources\CommercialResource;

class FiltrationController extends Controller
{
    
    
    
    public function isFilter($cat_id) {

        $filter = Filter::where('cat_id', $cat_id)->get();
    
        if ($filter->isNotEmpty()) {
            return response()->json(['result' => true]);
        }
    
        return response()->json(['result' => false]);
    }
    
    
    
public function showFilters($cat_id)
{
    // Fetch filters based on the category ID
    $filters = Filter::where('cat_id', $cat_id)->get();

    // Initialize an array to store features
    $features = [];
    $brands=[];

    // Iterate over each filter and check its relation
    foreach ($filters as $filter) {
        // Check filter relation and fetch the relevant features
        if ($filter->relation_name == 'cars.features') {
            $features = CarFeature::all();
            $brands = Brand::all();
        } elseif ($filter->relation_name == 'houses.features') {
            $features = Feature::all();
        } elseif ($filter->relation_name == 'bikes.features') {
            $features = BikeFeature::all();
        }
    }

    // Return the response with filters and the features based on the cat_id relation
    return response()->json([
        'filters' => $filters,
        'features' => $features,
        'brands'=>$brands
    ]);
}



    public function getRelatedAds($cat_id)
    {
        $subCategories = Category::with('normalAds')
                                ->where('parent_id', $cat_id)
                                ->get();

       $Categories = Category::with(['commercialAds', 'banners', 'popupAds'])
         ->where('id', $cat_id)
        ->get();
    
        $normalAds = $subCategories->flatMap->normalAds;
        $commercialAds = $Categories->flatMap->commercialAds;
        $banners = $Categories->flatMap->banners;
        $popupAds = $Categories->flatMap->popupAds;
    

        return response()->json([
            'MainCategories' => CategoryResource::collection($Categories),
            'subCategories' => CategoryResource::collection($subCategories),
            'normalAds' => NormalAdResource::collection($normalAds),
            'commercialAds' => CommercialResource::collection($commercialAds),
            'banners' =>BannerResource::collection($banners),
            'popupAds' =>PopupResource::collection($popupAds)
        ]);
    }


    public function applyFilters(Request $request, $cat_id)
    {
    $query = NormalAds::where('cat_id', $cat_id);

    // Fetch all filters for the current category
    $filters = Filter::where('cat_id', $cat_id)->get();

    foreach ($filters as $filter) {
        $filterName = $filter->filter_name;
        $filterType = $filter->filter_type;
        $relation = $filter->relation_name; // Relation to the related model (e.g., Cars, Houses)

        if ($request->has($filterName)) {
            $value = $request->input($filterName);

            if ($filterType == 'text' || $filterType == 'select' || $filterType == 'number') {
                if ($relation) {
                    $query->whereHas($relation, function ($q) use ($filterName, $value) {
                        $q->where($filterName, 'like', '%' . $value . '%');
                    });
                } else {
                    $query->where($filterName, 'like', '%' . $value . '%');
                }
            }
            elseif ($filterType == 'checkbox' && $filterName == 'features') {
                $selectedFeatures = $request->input('features', []);
                if (!empty($selectedFeatures)) {
                    $query->whereHas($relation, function ($q) use ($selectedFeatures) {
                        $q->whereIn('feature_id', $selectedFeatures);
                    });
                }
            }
        }

        // Handle min_max filters (with or without relation)
        if ($filterType == 'min_max') {
            $minInput = $request->input('min_' . $filterName);
            $maxInput = $request->input('max_' . $filterName);

            // Apply min filter
            if ($minInput) {
                if ($relation) {
                    // Apply the min filter via relation
                    $query->whereHas($relation, function ($q) use ($filterName, $minInput) {
                        $q->where($filterName, '>=', $minInput);
                    });
                } else {
                    // Apply the min filter directly on NormalAds
                    $query->where($filterName, '>=', $minInput);
                }
            }

            // Apply max filter
            if ($maxInput) {
                if ($relation) {
                    // Apply the max filter via relation
                    $query->whereHas($relation, function ($q) use ($filterName, $maxInput) {
                        $q->where($filterName, '<=', $maxInput);
                    });
                } else {
                    // Apply the max filter directly on NormalAds
                    $query->where($filterName, '<=', $maxInput);
                }
            }
        }
    }

    // Execute the query and get the filtered results
    $normalAds = $query->get();


        return NormalAdResource::collection($normalAds);
    }


}
