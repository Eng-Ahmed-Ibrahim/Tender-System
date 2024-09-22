<?php

namespace App\Http\Controllers\Api\Normalads;

use App\Models\NormalAds;
use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use Modules\Car\Models\Cars;
use Modules\Bike\Models\Bike;
use App\Models\ImageNormalAds;
use Modules\House\Models\House;
use App\Services\AdLimitServices;
use App\Services\NormalAdsService;
use Modules\Career\Models\Careers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Electronics\Models\Mobiles;
use App\Http\Resources\NormalAdResource;
use App\Http\Resources\ShowNormalResource;

class NormaladsController extends Controller
{
    protected $normalAdsService;

    public function __construct(NormalAdsService $normalAdsService)
    {
        $this->normalAdsService = $normalAdsService;
    }

public function index(Request $request)
{
    // Create a query for retrieving active NormalAds
    $query = NormalAds::Active();

    // Get the sorting parameter from the request
    $sortType = $request->input('sort'); // Example values: 'latest', 'oldest', 'high_price', 'low_price'

    // Apply sorting based on the provided sort type
    switch ($sortType) {
        case 'latest':
            $query->orderBy('created_at', 'desc'); // Sort by latest
            break;
        case 'oldest':
            $query->orderBy('created_at', 'asc'); // Sort by oldest
            break;
        case 'high_price':
            $query->orderBy('price', 'desc'); // Sort by highest price
            break;
        case 'low_price':
            $query->orderBy('price', 'asc'); // Sort by lowest price
            break;
        default:
            // Default sorting (if no sort type is provided)
            $query->orderBy('created_at', 'desc'); // Default to latest
            break;
    }

    // Retrieve the sorted results
    $normalAds = $query->get();

    // Return the collection of NormalAds using the NormalAdResource
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
    
        if ($user->role_id === 2) {
            $this->processAd($request);
            return response()->json(['message' => 'Record created successfully.']);
        } else {
            $adLimitService = new AdLimitServices();
    
            if (!$adLimitService->canPostAd('normal')) {
                return response()->json(['error' => 'You have reached your ad posting limit.'], 403);
            }
    
            $this->processAd($request);
    
            // Update ad limits for non-admin users
            $adLimitService->updateAdLimits('normal');
    
            return response()->json(['message' => 'Record created successfully.']);
        }
    }
    
    protected function processAd(Request $request)
    {
       
        $normalAd = $this->normalAdsService->storeNormalAd($request);

    }
    

   
    public function show($id)
    {
        $normalAd = NormalAds::Active()->with('category', 'images', 'cars', 'bikes', 'houses', 'mobiles')->findOrFail($id);
    
        return  new ShowNormalResource($normalAd);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
     
        // Find the ad by ID and ensure it belongs to the authenticated customer
        $ad = NormalAds::where('id', $id)
            ->where('customer_id', Auth::guard('customer')->id())
            ->first();
    
        if (!$ad) {
            return response()->json(['error' => 'Ad not found or you do not have permission to update it.'], 404);
        }
    
        // Validate the input fields
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'cat_id' => 'sometimes|required|integer',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'photo' => 'nullable|image|max:2048',
        ]);
    
        // Handle the photo update
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($ad->photo) {
                Storage::disk('public')->delete($ad->photo);
            }
    
            // Store the new photo
            $ad->photo = $request->file('photo')->store('photos', 'public');
        }
    
        // Update fields conditionally
        if ($request->filled('title')) {
            $ad->title = $validatedData['title'];
        }
        if ($request->filled('cat_id')) {
            $ad->cat_id = $validatedData['cat_id'];
        }
        if ($request->filled('description')) {
            $ad->description = $validatedData['description'];
        }
        if ($request->filled('price')) {
            $ad->price = $validatedData['price'];
        }
    
        // Save the updated ad
        $ad->save();
    
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $imagePath = $image->store('normal_ads_images', 'public');
    
                ImageNormalAds::create([
                    'normal_ads_id' => $ad->id,
                    'image_path' => $imagePath,
                ]);
            }
        }
    
        // Translate and save the updated data
        $this->translateAndSave($request->all(), 'update');
    
        return response()->json(['message' => 'Ad updated successfully.']);
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
            // Dispatch the job for each input value
            dispatch(new TranslateText($key, $value, $languages));
        }
    }
}
}
