<?php

namespace App\Http\Controllers\Api\Normalads;

use Exception;
use App\Models\Category;
use App\Models\NormalAds;
use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use Modules\Car\Models\Cars;
use Modules\Car\Models\Brand;
use App\Services\AdLimitServices;
use Modules\Car\Models\CarImages;
use Modules\Car\Models\CarFeature;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CarAdResource;
use Illuminate\Support\Facades\Storage;
use Modules\Car\Models\CarSpecifaction;
use App\Http\Resources\NormalAdResource;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    $mainCategory = Category::where('id', 1)->first();

    if (!$mainCategory) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    $subCategories = Category::where('parent_id', $mainCategory->id)->pluck('id');

    // Combine main category ID with subcategory IDs
    $categoryIds = $subCategories->prepend($mainCategory->id);

    $normalAdsQuery = NormalAds::Active()  // Assuming you have a scope 'Active' for active ads
        ->whereIn('cat_id', $categoryIds);

    // Sorting based on request parameter
    $sortType = $request->input('sort'); // sort can be 'latest', 'oldest', 'high_price', or 'low_price'
    
    if ($sortType === 'latest') {
        $normalAdsQuery->orderBy('created_at', 'desc');
    } elseif ($sortType === 'oldest') {
        $normalAdsQuery->orderBy('created_at', 'asc');
    } elseif ($sortType === 'high_price') {
        $normalAdsQuery->orderBy('price', 'desc');
    } elseif ($sortType === 'low_price') {
        $normalAdsQuery->orderBy('price', 'asc');
    }

    // Fetch the filtered and sorted ads
    $normalAds = $normalAdsQuery->get();

    // Return NormalAds using a resource collection
    return NormalAdResource::collection($normalAds);
}



    public function store(Request $request)
    {
        // Ensure the user is authenticated
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

        return response()->json(['success' => 'Car created successfully.'], 201);
    }


    public function carFeatures()
    {
        try {
            $features = CarFeature::all();
    
            return response()->json([
                'features' => $features
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    public function carBrands()
    {
        try {
            $brands = Brand::all();
    
            return response()->json([
                'brands' => $brands
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    protected function processAd(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features.*' => 'nullable|exists:car_features,id',
        ]);
    
        $customer = Auth::guard('customer')->user();
        $countryId = $customer->country_id;
        $customerId = $customer->id;

        $ad = new NormalAds([
            'title' => $validatedData['title'],
            'country_id' => $countryId,
            'customer_id' => $customerId,
            'cat_id' => $validatedData['cat_id'],
            'address' => $validatedData['address'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'is_active' => false, 
        ]);
        $ad->save();
    
        // Handle the main photo if uploaded
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
    
        $car = new Cars([
            'color' => $request->input('color'),
            'year' => $request->input('year'),
            'kilo_meters' => $request->input('kilo_meters'),
            'fuel_type' => $request->input('fuel_type'),
            'brand_id' => $validatedData['brand_id'],
            'normal_id' => $ad->id,
        ]);
        $car->save();
    
        // Attach features to the car
        if ($request->has('features')) {
            $car->features()->sync($request->input('features'));
        }

        $this->translateAndSave($request->all(), 'store');
    }
  
    public function show($id)
    {
        $car = Cars::with('category')->findOrFail($id);
    
        return new CarAdResource($car);
    }


    /**
     * Update the specified resource in storage.
     */
  
        public function update(Request $request, $id)
        {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric',
                'cat_id' => 'required|exists:categories,id',
                'brand_id' => 'required|exists:brands,id',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'features.*' => 'nullable|exists:car_features,id',
            ]);
        
            // Find the ad by its ID
            $ad = NormalAds::findOrFail($id);
        
            // Update the ad fields
            $ad->update([
                'title' => $validatedData['title'],
                'country_id' => Auth::guard('customer')->user()->country_id,
                'customer_id' => Auth::guard('customer')->user()->id,
                'cat_id' => $validatedData['cat_id'],
                'address' => $validatedData['address'],
                'description' => $validatedData['description'],
                'price' => $validatedData['price'],
                'is_active' => false, // Keep the current active status
            ]);
        
            // Update the main photo if a new one is uploaded
            if ($request->hasFile('photo')) {
                // Delete the old photo if exists
                if ($ad->photo) {
                    Storage::disk('public')->delete($ad->photo);
                }
        
                // Store the new photo
                $photoPath = $request->file('photo')->store('photos', 'public');
                $ad->update(['photo' => $photoPath]);
            }
        
            // Handle additional images if uploaded
            if ($request->hasFile('images')) {
                // Optionally, delete old images if you want to replace them entirely
                // $ad->images()->delete();
        
                // Save new images
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images', 'public');
                    $ad->images()->create([
                        'image_path' => $imagePath,
                    ]);
                }
            }
        
            // Find the associated car record and update it
            $car = $ad->cars; // Assuming there is a `car` relationship defined in `NormalAds` model
        
            if ($car) {
                $car->update([
                    'color' => $request->input('color'),
                    'year' => $request->input('year'),
                    'kilo_meters' => $request->input('kilo_meters'),
                    'fuel_type' => $request->input('fuel_type'),
                    'brand_id' => $validatedData['brand_id'],
                ]);
        
                // Sync the features
                if ($request->has('features')) {
                    $car->features()->sync($request->input('features'));
                }
            } else {
                // Handle the case if there's no car associated yet
                $car = new Cars([
                    'color' => $request->input('color'),
                    'year' => $request->input('year'),
                    'kilo_meters' => $request->input('kilo_meters'),
                    'fuel_type' => $request->input('fuel_type'),
                    'brand_id' => $validatedData['brand_id'],
                    'normal_id' => $ad->id,
                ]);
                $car->save();
        
                if ($request->has('features')) {
                    $car->features()->sync($request->input('features'));
                }
            }
        
            // Optionally, handle translation updates
            $this->translateAndSave($request->all(), 'update');

            return response()->json(['success' => 'Car updated successfully.'], 200);

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
