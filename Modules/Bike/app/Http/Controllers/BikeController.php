<?php

namespace Modules\Bike\Http\Controllers;

use App\Models\Category;
use App\Models\NormalAds;
use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Bike\Models\Bike;
use App\Services\AdLimitServices;
use Modules\Bike\Models\BikeImages;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Bike\Models\BikeFeature;
use Illuminate\Http\RedirectResponse;
use Modules\Bike\Models\BikeCategory;
use Modules\Bike\Models\BikeSpecification;

class BikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bikes = Bike::with('features')->paginate(10); 
        return view('bike::bikes.index', compact('bikes'));
    }
   
 

    public function create(Request $request)
    
    {

        $catId = $request->cat_id;

        $features = BikeFeature::all();

        
        $cat_id =Category::where('parent_id',$catId)->get();
    
        return view('bike::bikes.create',compact('features','cat_id'));
    }
    

  
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'You must be logged in to post an ad.');
        }
    
        $user = Auth::user();
    
        if ($user->role_id === 2) {

            $this->processAd($request);
    
            return redirect()->route('bike.index')->with('success', 'Bike created successfully.');
        } else {
            
    
            $this->processAd($request);
    

            return redirect()->route('bike.index')->with('success', 'Bike created successfully.');
        }
    }
    
    /**
     * Process the ad storage logic.
     */
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
    
        $countryId = $request->session()->get('country_id');
    
        // Create and save a new NormalAds instance
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
    
        return redirect()->route('bike.index')->with('success', __('Car ad created successfully.'));
    }
    

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        // Retrieve the bike with related data
        $bike = Bike::with('images', 'features', 'specifications')->findOrFail($id);
    
        // Pass the bike and its related data to the view
        return view('bike::bikes.show', compact('bike'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bike = Bike::with('images', 'features', 'specifications')->findOrFail($id);
        
        // Fetch categories and features for the select and checkbox inputs
        $categories = BikeCategory::all();
        $features = BikeFeature::all();
        $specifications =BikeSpecification::where('bike_id',$id)->first();
    
        return view('bike::bikes.edit', compact('bike', 'categories', 'features','specifications'));
    }
    
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
    
    
        // Validate request
        $request->validate([
            'title' => 'required|string|max:255',
            'cat_id' => 'required|exists:bike_categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'features.*' => 'exists:bike_features,id',
            'model' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'kilo_meters' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'is_active' => 'nullable|boolean',
        ]);
    
        $countryId = $request->session()->get('country_id');
    
        // Find the existing bike record
        $bike = Bike::findOrFail($id);
        $bike->title = $request->input('title');
        $bike->cat_id = $request->input('cat_id');
        $bike->price = $request->input('price');
        $bike->is_active = $request->input('is_active', false);
        $bike->country_id = $countryId;
        $bike->customer_id = $request->input('customer_id');
        $bike->save();
    
        // Handle image uploads
        if ($request->hasFile('images')) {
            // Optionally, delete old images
            BikeImages::where('bike_id', $bike->id)->delete();
    
            foreach ($request->file('images') as $image) {
                $path = $image->store('bike_images', 'public');
                BikeImages::create([
                    'photo' => $path,
                    'bike_id' => $bike->id,
                ]);
            }
        }
    
        // Update features
        if ($request->has('features')) {
            $bike->features()->sync($request->input('features'));
        }
    
        // Update specifications
        $specificationData = [
            'model' => $request->input('model'),
            'year' => $request->input('year'),
            'kilo_meters' => $request->input('kilo_meters'),
            'status' => $request->input('status'),
            'location' => $request->input('location'),
            'bike_id' => $bike->id,
        ];
    
        BikeSpecification::updateOrCreate(
            ['bike_id' => $bike->id],
            $specificationData
        );
    
    
        // Apply translations and save
        $this->translateAndSave($request->all(), 'update');
    
        // Determine the redirect route
        $redirectTo = $request->input('redirect_to', 'bike.index');
        
        return redirect()->route($redirectTo)->with('success', 'Bike updated successfully.');
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the car by ID
        $bike = Bike::findOrFail($id);
    
       
    
        // Detach features associated with the car
        $bike->features()->detach();
    
        // Delete related details
    
        // Delete the car itself
        $bike->delete();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Car deleted successfully.');
    }
 
    protected function translateAndSave(array $inputs, $operation)
{
    $languages = ['en', 'fr', 'es', 'ar', 'de', 'tr', 'it', 'ja', 'zh', 'ur'];

    foreach ($inputs as $key => $value) { 
        if (is_string($value) && !empty($value)) {
            // Dispatch the job for each input value
            dispatch(new TranslateText($key, $value, $languages));
        }
    }
}


public function toggleStatusBikes(Bike $ad)
{
    $ad->is_active = !$ad->is_active; // Toggle the status
    $ad->save();

    return redirect()->back()->with('status', 'Ad status updated successfully!');
}

}
