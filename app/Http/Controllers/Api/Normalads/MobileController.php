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
    
        $countryId = $request->session()->get('country_id');
    
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
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to update a mobile ad.'], 401);
        }
    
        $user = Auth::user();
    
        // Check if the user has permission to update the ad
        if ($user->role_id !== 2) {
            return response()->json(['error' => 'You do not have permission to update this mobile ad.'], 403);
        }
    
        // Find the mobile ad by ID
        $mobile = Mobiles::find($id);
    
        if (!$mobile) {
            return response()->json(['error' => 'Mobile not found.'], 404);
        }
    
        // Validate the input fields
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string',
            'cat_id' => 'sometimes|required|exists:electronic_categories,id',
            'storage' => 'sometimes|required|string',
            'ram' => 'sometimes|required|string',
            'disply_size' => 'sometimes|required|string',
            'sim_no' => 'sometimes|required|integer',
            'description' => 'sometimes|required|string',
            'status' => 'sometimes|required|string',
            'mobile_images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'sometimes|required|numeric',
            'is_active' => 'nullable|boolean',
        ]);
    
        // Update fields for the mobile ad
        if ($request->filled('title')) {
            $mobile->title = $validatedData['title'];
        }
        if ($request->filled('cat_id')) {
            $mobile->cat_id = $validatedData['cat_id'];
        }
        if ($request->filled('price')) {
            $mobile->price = $validatedData['price'];
        }
        if ($request->has('is_active')) {
            $mobile->is_active = $validatedData['is_active'];
        }
        $mobile->save();
    
        // Update phone features
        $phoneFeatures = $mobile->phoneFeatures;
        if ($request->filled('storage')) {
            $phoneFeatures->storage = $validatedData['storage'];
        }
        if ($request->filled('ram')) {
            $phoneFeatures->ram = $validatedData['ram'];
        }
        if ($request->filled('disply_size')) {
            $phoneFeatures->disply_size = $validatedData['disply_size'];
        }
        if ($request->filled('sim_no')) {
            $phoneFeatures->sim_no = $validatedData['sim_no'];
        }
        if ($request->filled('status')) {
            $phoneFeatures->status = $validatedData['status'];
        }
        if ($request->filled('description')) {
            $phoneFeatures->description = $validatedData['description'];
        }
        $phoneFeatures->save();
    
        // Handle image updates
        if ($request->hasFile('mobile_images')) {
            foreach ($request->file('mobile_images') as $file) {
                $path = $file->store('public/mobiles');
                $mobile->images()->create([
                    'photo_path' => Storage::url($path),
                ]);
            }
        }
    
        // Call translation method
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
