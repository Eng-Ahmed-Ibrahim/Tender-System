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
    public function update(Request $request, string $id)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to update an ad.'], 401);
        }
    
        $user = Auth::user();
    
        // Validate the request
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'cat_id' => 'sometimes|required|exists:house_categories,id', 
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'features.*' => 'exists:features,id',
            'room_no' => 'nullable|integer',
            'area' => 'nullable|string',
            'location' => 'nullable|string',
            'view' => 'nullable|string',
            'building_no' => 'nullable|string',
            'history' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'is_active' => 'nullable|boolean',
        ]);
    
        // Find the house to update
        $house = House::findOrFail($id);
    
        // Check if the user is authorized to update this house ad
        if ($house->customer_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized to update this house.'], 403);
        }
    
        // Update house attributes only if they are present in the request
        $house->title = $request->input('title', $house->title);
        $house->cat_id = $request->input('cat_id', $house->cat_id);
        $house->price = $request->input('price', $house->price);
        $house->is_active = false;
        $house->save();
    
        // Handle image updates
        if ($request->hasFile('images')) {
            // Delete existing images
            HouseImage::where('house_id', $house->id)->delete();
    
            // Store new images
            foreach ($request->file('images') as $image) {
                $path = $image->store('house_images', 'public');
                HouseImage::create([
                    'image' => $path,
                    'house_id' => $house->id,
                ]);
            }
        }
    
        // Update features
        if ($request->has('features')) {
            $house->features()->sync($request->input('features'));
        }
    
        // Update or create house details
        $houseDetails = HouseDetails::where('house_id', $house->id)->first();
        if ($houseDetails) {
            $houseDetails->update([
                'room_no' => $request->input('room_no', $houseDetails->room_no),
                'area' => $request->input('area', $houseDetails->area),
                'location' => $request->input('location', $houseDetails->location),
                'view' => $request->input('view', $houseDetails->view),
                'building_no' => $request->input('building_no', $houseDetails->building_no),
                'history' => $request->input('history', $houseDetails->history),
            ]);
        } else {
            HouseDetails::create([
                'house_id' => $house->id,
                'room_no' => $request->input('room_no'),
                'area' => $request->input('area'),
                'location' => $request->input('location'),
                'view' => $request->input('view'),
                'building_no' => $request->input('building_no'),
                'history' => $request->input('history'),
            ]);
        }
    
        // Translate and save
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
