<?php

namespace App\Http\Controllers\Api\Normalads;

use App\Models\Category;
use App\Models\NormalAds;
use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use Modules\Bike\Models\Bike;
use App\Services\AdLimitServices;
use Modules\Bike\Models\BikeImages;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BikeAdResource;
use App\Http\Resources\NormalAdResource;
use Modules\Bike\Models\BikeSpecification;

class BikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     
     
public function index(Request $request)
{
    // Find the main category with id 9
    $mainCategory = Category::find(9);

    // If the main category is not found, return a 404 error response
    if (!$mainCategory) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    // Get the IDs of all subcategories of the main category
    $subCategories = Category::where('parent_id', $mainCategory->id)->pluck('id');

    // Include the main category ID in the list of category IDs
    $categoryIds = $subCategories->prepend($mainCategory->id);

    // Create a query builder for NormalAds that belong to either the main category or its subcategories
    $normalAdsQuery = NormalAds::Active()  // Assuming you have a scope 'Active' for active ads
        ->whereIn('cat_id', $categoryIds);

    // Get the sorting parameter from the request
    $sortType = $request->input('sort'); // Example values: 'latest', 'oldest', 'high_price', 'low_price'

    // Apply sorting based on the provided sort type
    switch ($sortType) {
        case 'latest':
            $normalAdsQuery->orderBy('created_at', 'desc');
            break;
        case 'oldest':
            $normalAdsQuery->orderBy('created_at', 'asc');
            break;
        case 'high_price':
            $normalAdsQuery->orderBy('price', 'desc');
            break;
        case 'low_price':
            $normalAdsQuery->orderBy('price', 'asc');
            break;
        default:
            // Default sorting (if no sort type is provided)
            $normalAdsQuery->orderBy('created_at', 'desc');
            break;
    }

    // Execute the query and get the results
    $normalAds = $normalAdsQuery->get();

    // Return the ads using a resource collection
    return NormalAdResource::collection($normalAds);
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to post an ad.'], 401);
        }

        $user = Auth::user();

        if ($user->role_id !== 2) {
            $adLimitService = new AdLimitServices();

            if (!$adLimitService->canPostAd('normal')) {
                return response()->json(['error' => 'You have reached your ad posting limit.'], 403);
            }

            $adLimitService->updateAdLimits('normal');
        }

        $this->processAd($request);

        return response()->json(['success' => 'Bike created successfully.'], 201);
    }

    protected function processAd(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'cat_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features.*' => 'nullable|exists:bike_features,id',
        ]);
    

        $customer = Auth::guard('customer')->user();
        $countryId = $customer->country;

        
        $ad = new NormalAds([
            'title' => $validatedData['title'],
            'country_id' => $countryId,
            'cat_id' => $validatedData['cat_id'],
            'address' => $validatedData['address'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'is_active' => false, 
        ]);

        $ad->save();
    
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $ad->photo = $photoPath;
            $ad->save(); // Save the photo path to the existing ad record
        }
    
        // Handle additional images if uploaded
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images', 'public');
                $ad->images()->create([
                    'image_path' => $imagePath,
                ]);
            }
        }
    
        $bike = new Bike([
            'model' => $request->input('model'),
            'year' => $request->input('year'),
            'kilo_meters' => $request->input('kilo_meters'),
            'normal_id' => $ad->id,
        ]);
        $bike->save();
    
        if ($request->has('features')) {
            $bike->features()->sync($request->input('features'));
        }
    
        $this->translateAndSave($request->all(), 'store');
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bike = Bike::with('category')->findOrFail($id);
    
        return new BikeAdResource($bike);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to update an ad.'], 401);
        }

        $user = Auth::user();

        // Validate the request
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'cat_id' => 'sometimes|required|exists:bike_categories,id',
             'images.*' => 'nullable|max:2048',
            'features.*' => 'exists:bike_features,id',
            'model' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'kilo_meters' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'price' => 'sometimes|numeric',
        ]);

        // Find the bike to update
        $bike = Bike::findOrFail($id);

        // Check if the user is authorized to update this bike (e.g., check if they own it)
        if ($bike->customer_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized to update this bike.'], 403);
        }

        // Update bike attributes
        $bike->title = $request->input('title', $bike->title);
        $bike->cat_id = $request->input('cat_id', $bike->cat_id);
        $bike->price = $request->input('price', $bike->price);
        $bike->is_active = false;
        $bike->save();

        // Handle images
        if ($request->hasFile('images')) {
            // Delete existing images if needed
            BikeImages::where('bike_id', $bike->id)->delete();
            
            foreach ($request->file('images') as $image) {
                $path = $image->store('bike_images', 'public');
                BikeImages::create([
                    'photo' => $path,
                    'bike_id' => $bike->id,
                ]);
            }
        }

        // Handle features
        if ($request->has('features')) {
            $bike->features()->sync($request->input('features'));
        }

        // Update bike specifications
        $specification = BikeSpecification::where('bike_id', $bike->id)->first();
        if ($specification) {
            $specification->update([
                'model' => $request->input('model'),
                'year' => $request->input('year'),
                'kilo_meters' => $request->input('kilo_meters'),
                'status' => $request->input('status'),
                'location' => $request->input('location'),
            ]);
        } else {
            BikeSpecification::create([
                'model' => $request->input('model'),
                'year' => $request->input('year'),
                'kilo_meters' => $request->input('kilo_meters'),
                'status' => $request->input('status'),
                'location' => $request->input('location'),
                'bike_id' => $bike->id,
            ]);
        }

        // Translate and save
        $this->translateAndSave($request->all(), 'update');

        return response()->json(['success' => 'Bike updated successfully.'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    protected function translateAndSave(array $inputs, $operation)
    {
        $languages = ['en', 'fr', 'es', 'ar'];
    
        foreach ($inputs as $key => $value) { 
            if (is_string($value) && !empty($value)) {

                dispatch(new TranslateText($key, $value, $languages));
            }
        }
    }
}

