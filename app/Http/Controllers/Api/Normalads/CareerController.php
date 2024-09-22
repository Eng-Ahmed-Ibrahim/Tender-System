<?php

namespace App\Http\Controllers\Api\Normalads;

use App\Models\Category;
use App\Models\NormalAds;
use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use App\Services\AdLimitServices;
use Modules\Career\Models\Careers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NormalAdResource;

class CareerController extends Controller
{
  
public function index(Request $request)
{
    // Find the main category with id 11
    $mainCategory = Category::find(11);

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

        return response()->json(['success' => 'Career created successfully.'], 201);
    }

    protected function processAd(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cat_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'experience_year' => 'required|string',
            'experience_level' => 'required|string',
            'cv_file' => 'required|file|mimes:pdf,doc,docx',
        ]);
    
        $countryId = $request->session()->get('country_id');
    
        $ad = new NormalAds([
            'title' => $validatedData['title'],
            'country_id' => $countryId,
            'cat_id' => $validatedData['cat_id'],
            'address' => $validatedData['address'],
            'description' => $validatedData['description'],
            'price' => 0,
            'is_active' => true, 
        ]);
        $ad->save();
    
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $ad->photo = $photoPath;
            $ad->save(); 
        }
    
       
        $path = $request->file('cv_file')->store('cv_files','public');

        Careers::create([
            'experience_year' => $request->experience_year,
            'experience_level' => $request->experience_level,
            'cv_file' => $path,
            'normal_id' =>$ad->id
        ]);
      
        $this->translateAndSave($request->all(), 'store');


    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Careers = Careers::with('category')->findOrFail($id);
    
        return new CareerAdResource($Careers);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in to update an ad.'], 401);
        }
    
        $user = Auth::user();
    
        // Check if the user has permission to update the ad
        if ($user->role_id !== 2) {
            return response()->json(['error' => 'You do not have permission to update this career.'], 403);
        }
    
        // Find the career ad by ID
        $career = Careers::find($id);
    
        if (!$career) {
            return response()->json(['error' => 'Career not found.'], 404);
        }
    
        // Validate the input fields
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'cat_id' => 'sometimes|required|exists:career_categories,id',
            'experience_year' => 'sometimes|required|string',
            'experience_level' => 'sometimes|required|string',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx',
        ]);
    
        // Handle the CV file update
        if ($request->hasFile('cv_file')) {
            // Delete the old CV file if it exists
            if ($career->cv_file) {
                Storage::disk('public')->delete($career->cv_file);
            }
    
            // Store the new CV file
            $career->cv_file = $request->file('cv_file')->store('cv_files', 'public');
        }
    
        // Update fields conditionally
        if ($request->filled('title')) {
            $career->title = $validatedData['title'];
        }
        if ($request->filled('description')) {
            $career->description = $validatedData['description'];
        }
        if ($request->filled('cat_id')) {
            $career->cat_id = $validatedData['cat_id'];
        }
        if ($request->filled('experience_year')) {
            $career->experience_year = $validatedData['experience_year'];
        }
        if ($request->filled('experience_level')) {
            $career->experience_level = $validatedData['experience_level'];
        }
    
        // Save the updated career ad
        $career->save();
    
        // Translate and save the updated data
        $this->translateAndSave($request->all(), 'update');
    
        return response()->json(['success' => 'Career updated successfully.'], 200);
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
