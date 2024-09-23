<?php

namespace App\Http\Controllers\Api\Normalads;

use App\Models\Category;
use App\Models\NormalAds;
use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use Modules\House\Models\House;
use App\Services\AdLimitServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NormalAdResource;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $mainCategory = Category::where('id', 2)->first();

    if (!$mainCategory) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    // Retrieve subcategory IDs for the main category
    $subCategories = Category::where('parent_id', 2)->pluck('id');

    // Create a query to get NormalAds related to either the main category or its subcategories
    $query = NormalAds::Active() // Assuming you have a scope 'Active' for active ads
                ->whereIn('cat_id', $subCategories);

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

    // Retrieve the sorted and filtered NormalAds
    $normalAds = $query->get();

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

        return response()->json(['success' => 'Property created successfully.'], 201);
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
            'features.*' => 'nullable|exists:features,id',
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
    
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $ad->photo = $photoPath;
            $ad->save(); 
        }
    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images', 'public');
                $ad->images()->create([
                    'image_path' => $imagePath,
                ]);
            }
        }
    
        $house = new House([
            'normal_id' => $ad->id,
            'room_no' => $request->input('room_no'),
            'area' => $request->input('area'),
            'location' => $request->input('location'),
            'view' => $request->input('view'),
            'building_no' => $request->input('building_no'),
            'history' => $request->input('history'),
        ]);
    
        $house->save();
    
        if ($request->has('features')) {
            $house->features()->sync($request->input('features'));
        }
        $this->translateAndSave($request->all(), 'store');

     
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $property = House::with('category')->findOrFail($id);
    
        return new PropertyAdResource($property);
    }
    /**
     * Update the specified resource in storage.
     */
    protected function updateAd(Request $request, $id)
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
            'features.*' => 'nullable|exists:features,id',
        ]);
    
        // Find the existing ad by its ID
        $ad = NormalAds::findOrFail($id);
    
        // Handle the main photo if a new one is uploaded
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($ad->photo) {
                Storage::disk('public')->delete($ad->photo);
            }
    
            // Store the new photo
            $validatedData['photo'] = $request->file('photo')->store('photos', 'public');
            $ad->photo = $validatedData['photo'];
        }
    
        // Update the ad fields
        $customer = Auth::guard('customer')->user();
        $countryId = $customer->country;
    
        $ad->update([
            'title' => $validatedData['title'],
            'country_id' => $countryId,
            'cat_id' => $validatedData['cat_id'],
            'address' => $validatedData['address'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'photo' => $ad->photo, // Keep the existing photo if not updated
        ]);
    
        // Handle additional images if new ones are uploaded
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
    
        // Find the associated House record and update it
        $house = $ad->house;
    
        $house->update([
            'room_no' => $request->input('room_no'),
            'area' => $request->input('area'),
            'location' => $request->input('location'),
            'view' => $request->input('view'),
            'building_no' => $request->input('building_no'),
            'history' => $request->input('history'),
        ]);
    
        // Update the features associated with the house
        if ($request->has('features')) {
            $house->features()->sync($request->input('features'));
        }
    
        // Translate and save (assuming you have a method for this)
        $this->translateAndSave($request->all(), 'update');
    
        return response()->json(['success' => 'House updated successfully.', 'ad' =>  $house], 200);
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
