<?php

namespace App\Http\Controllers\Api\Commercial;

use App\Models\Category;
use App\Jobs\TranslateText;
use App\Models\CommercialAd;
use Illuminate\Http\Request;
use App\Services\AdLimitServices;
use Modules\Car\Models\CarCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Bike\Models\BikeCategory;
use Illuminate\Support\Facades\Storage;
use Modules\House\Models\HouseCategory;
use Modules\Career\Models\CareerCategory;
use App\Http\Resources\CommercialResource;
use Modules\Electronics\Models\ElectronicCategory;

class CommercialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $title = $request->input('title');
    $catId = $request->input('cat_id');
    
    $query = CommercialAd::Active()->with('category');
    
    if ($title) {
        $query->where('title', 'like', "%{$title}%");
    }

    if ($catId) {
        $query->where('cat_id', $catId);
    }
    
    
             $sortType = $request->input('sort');

    switch ($sortType) {
        case 'latest':
            $query->orderBy('created_at', 'desc');
            break;
        case 'oldest':
            $query->orderBy('created_at', 'asc');
            break;
      
        default:
            // Default sorting (if no sort type is provided)
            $query->orderBy('created_at', 'desc');
            break;
    }
    $commercail = $query->get();

    return CommercialResource::collection($commercail);
}

  
    
    


    
    

    
    /**
     * Store a newly created resource in storage.
     */
 
     public function store(Request $request)
     {
         $adLimitService = new AdLimitServices();
 
         if (!$adLimitService->canPostAd('commercial')) {
             return response()->json(['error' => 'You have reached your ad posting limit.'], 403);
         }
 
         $request->validate([
             'title' => 'required|string|max:255',
             'description' => 'nullable|string',
             'cat_id' => 'required|integer',
             'photo_path' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
             'phone' => 'nullable',
             'whatsapp' => 'nullable',
         ]);
 
 
     
         $photoPath = null;
         if ($request->hasFile('photo_path')) {
             $photoPath = $request->file('photo_path')->store('commercial', 'public');
         }
 
         $ad = new CommercialAd();
         $ad->title = $request->input('title');
         $ad->description = $request->input('description');
         $ad->photo_path = $photoPath;
         $ad->phone = $request->input('phone');
         $ad->whatsapp = $request->input('whatsapp');
         $ad->is_active = false;
         $ad->cat_id = $request->input('cat_id');
         $ad->customer_id = Auth::guard('customer')->id();
         $customer = Auth::guard('customer')->user();
         $countryId = $customer->country_id;
         $ad->country_id =  $countryId; 


         $ad->save();
         $adLimitService->updateAdLimits('commercial');
         $this->translateAndSave($request->all(), 'store');
 
         return response()->json(['success' => 'Commercial Ad created successfully!', 'ad' => $ad], 201);
     }
 

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
     $commercail = CommercialAd::Active()->findOrFail($id);

      return new CommercialResource($commercail);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    

    // Find the existing commercial ad
    $ad = CommercialAd::find($id);
    if (!$ad) {
        return response()->json(['error' => 'Commercial Ad not found.'], 404);
    }

    // Validate input fields
    $validatedData = $request->validate([
        'title' => 'sometimes|required|string|max:255',
        'description' => 'sometimes|nullable|string',
        'category_id' => 'sometimes|required|integer',
        'category_type' => 'sometimes|required|string',
        'photo_path' => 'sometimes|nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
    ]);

    // Update category if category_type is provided
    if ($request->filled('category_type')) {
        $categoryModel = $this->getCategoryModel($request->category_type);
        if (!$categoryModel) {
            return response()->json(['error' => 'Invalid category type.'], 400);
        }

        $ad->category()->associate($categoryModel::find($request->input('category_id')));
    }

    // Update the fields conditionally
    if ($request->filled('title')) {
        $ad->title = $validatedData['title'];
    }
    if ($request->filled('description')) {
        $ad->description = $validatedData['description'];
    }

    // Handle photo updates
    if ($request->hasFile('photo_path')) {
        // Delete the old photo if it exists
        if ($ad->photo_path) {
            Storage::disk('public')->delete($ad->photo_path);
        }

        // Store the new photo
        $photoPath = $request->file('photo_path')->store('commercial', 'public');
        $ad->photo_path = $photoPath;
    }

    // Update the ad's status and save
    $ad->is_active = $request->input('is_active', false); // Set default to false if not provided
    $ad->save();

    // Update ad limits

    // Call the translation method
    $this->translateAndSave($request->all(), 'update');

    return response()->json(['success' => 'Commercial Ad updated successfully!', 'ad' => $ad], 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    } 


    
    private function getCategoryModel($type)
    {
        $mapping = [
            'category1' => HouseCategory::class,
            'category2' => ElectronicCategory::class,
            'category3' => CarCategory::class,
            'category4' => BikeCategory::class,
            'category5' => Category::class,
            'category6' => CareerCategory::class,
        ];

        return $mapping[$type] ?? null;
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
