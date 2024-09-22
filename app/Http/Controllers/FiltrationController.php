<?php

namespace App\Http\Controllers;

use App\Models\Filter;
use App\Models\Category;
use App\Models\NormalAds;
use App\Services\Exchange;
use Illuminate\Http\Request;
use Modules\Car\Models\CarFeature;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class FiltrationController extends Controller
{

    public function MainCategory(){

        $categories = Category::whereNull('parent_id')->get();

        return view("backend.filter.category",compact('categories'));
    }


    public function showFilters($cat_id)
{
    $filters = Filter::where('cat_id', $cat_id)->get();

    $features = CarFeature::all(); 

    return view('backend.filter.index', compact('filters', 'cat_id', 'features'));
}
public function applyFilters(Request $request, $cat_id)
{
    // Start building the query for NormalAds
    $query = NormalAds::where('cat_id', $cat_id);

    // Fetch all filters for the current category
    $filters = Filter::where('cat_id', $cat_id)->get();

    foreach ($filters as $filter) {
        $filterName = $filter->filter_name;
        $filterType = $filter->filter_type;
        $relation = $filter->relation_name; // Relation to the related model (e.g., Cars, Houses)

        // Check for text, select, number, and checkbox filters
        if ($request->has($filterName)) {
            $value = $request->input($filterName);

            // Apply filter for text, select, or number inputs
            if ($filterType == 'text' || $filterType == 'select' || $filterType == 'number') {
                if ($relation) {
                    // Filter using the relation
                    $query->whereHas($relation, function ($q) use ($filterName, $value) {
                        $q->where($filterName, 'like', '%' . $value . '%');
                    });
                } else {
                    // Direct filter on NormalAds
                    $query->where($filterName, 'like', '%' . $value . '%');
                }
            }
            // Handle checkbox filter, specifically for 'features'
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

    // Return the filtered results to the view
    return view('backend.filter.filtered', compact('normalAds', 'cat_id'));
}


    
}
