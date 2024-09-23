<?php

namespace App\Http\Controllers\Api\Normalads;

use App\Models\Category;
use App\Models\NormalAds;
use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use App\Services\AdLimitServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Electronics\Models\Mobiles;
use App\Http\Resources\NormalAdResource;

class MobileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Find the main category with id 13
    $mainCategory = Category::find(13);

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

        return response()->json(['success' => 'Mobile created successfully.'], 201);
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
            'storage' => 'required|string',
            'ram' => 'required|string',
            'disply_size' => 'required|string',
            'sim_no' => 'required|integer',
            'status' => 'required',
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
            'is_active' => true, 
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
    
        
        $mobile = Mobiles::create([
             'storage' => $request->storage,
             'ram' => $request->ram,
             'disply_size' => $request->disply_size,
             'sim_no' => $request->sim_no,
             'status' => $request->status,
             'normal_id' => $ad->id,
         
        ]);

        
        $this->translateAndSave($request->all(), 'store');

       

    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mobile= Mobiles::with('category')->findOrFail($id);
    
        return new MobileAdResource($mobile);
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'storage' => 'required|string',
            'ram' => 'required|string',
            'disply_size' => 'required|string',
            'sim_no' => 'required|integer',
            'status' => 'required',
        ]);
    
        // Find the existing ad by its ID
        $ad = NormalAds::findOrFail($id);
    
        // Update the ad fields
        $ad->update([
            'title' => $validatedData['title'],
            'country_id' => Auth::guard('customer')->user()->country,
            'cat_id' => $validatedData['cat_id'],
            'address' => $validatedData['address'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'is_active' => $ad->is_active, // Keep the current active status
        ]);
    
        // Update the photo if a new one is uploaded
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($ad->photo) {
                Storage::disk('public')->delete($ad->photo);
            }
    
            // Store the new photo
            $photoPath = $request->file('photo')->store('photos', 'public');
            $ad->update(['photo' => $photoPath]);
        }
    
        // Update additional images if new ones are uploaded
        if ($request->hasFile('images')) {
            // Delete the old images if they exist
            foreach ($ad->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
    
            // Store the new images
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images', 'public');
                $ad->images()->create([
                    'image_path' => $imagePath,
                ]);
            }
        }
    
        // Find the related mobile record and update it
        $mobile = Mobiles::where('normal_id', $ad->id)->firstOrFail();
    
        // Update the mobile fields
        $mobile->update([
            'storage' => $request->storage,
            'ram' => $request->ram,
            'disply_size' => $request->disply_size,
            'sim_no' => $request->sim_no,
            'status' => $request->status,
        ]);
    
        // Optionally, handle translation updates
        $this->translateAndSave($request->all(), 'update');
        
        return response()->json(['success' => 'Mobile ad updated successfully.'], 200);

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
