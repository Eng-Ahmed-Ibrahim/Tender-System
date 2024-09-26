<?php

namespace Modules\Car\Http\Controllers;

use App\Models\Category;
use App\Models\NormalAds;
use App\Jobs\TranslateText;
use App\Models\CommercialAd;
use Illuminate\Http\Request;
use Modules\Car\Models\Cars;
use Illuminate\Http\Response;
use Modules\Car\Models\Brand;
use Modules\Car\Models\CarType;
use Modules\Car\Models\CarModel;
use App\Services\AdLimitServices;
use Modules\Car\Models\CarFeature;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;


class CarController extends Controller
{
    
    public function index()
    {
        $ads = NormalAds::whereHas('cars')->get();
        $categories = Category::where('parent_id',1)->get();
        return view('car::index',compact('ads','categories'));
    }
    
    public function commercial(){

        $commercialAds  = CommercialAd::Where('cat_id',1)->paginate(10);
        $categories = Category::where('id',1)->first();

        return view('car::commercial',compact('commercialAds','categories'));


    }
 
    public function create(Request $request)
    
    {

        $cat_id = $request->cat_id;

        $features = CarFeature::all();

        $brands = Brand::all();
        
        $cat_id =Category::where('parent_id',1)->get();
    
        return view('car::cars.create', compact('features', 'brands', 'cat_id'));
    }
    
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'You must be logged in to post an ad.');
        }
    
        $user = Auth::user();
    
        if ($user->role_id === 2) {

            $this->processAd($request);
    

            $redirectTo = $request->input('redirect_to', 'car.index'); 
    
            return redirect()->route($redirectTo)->with('success', 'Car created successfully.');
        
        } else {
      
    
            $this->processAd($request);
    
    

            $redirectTo = $request->input('redirect_to', 'car.index'); 
    
            return redirect()->route($redirectTo)->with('success', 'Car created successfully.');        }
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
    
        // Get country ID from session or other source
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
    
        // Create and save a new Car instance
        $car = new Cars([
            'color' => $request->input('model'),
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
    
        return redirect()->route('car.index')->with('success', __('Car ad created successfully.'));
    }
    


    
    /**
     * Show the specified resource.
     */
  /**
 * Show the specified resource.
 */
public function show($id)
{
    // Fetch car with related images, features, and specifications
    $car = Cars::with('images', 'features', 'specifications')->findOrFail($id);

    return view('car::show', compact('car'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $car = Cars::findOrFail($id);
        $categories = CarCategory::all(); // Assuming you have a Category model for the dropdown
        $features = CarFeature::all(); // Assuming you have a Feature model for the checkbox list
        $specifications =CarSpecifaction::where('car_id',$id)->first();

        return view('car::edit', compact('car', 'categories', 'features','specifications'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'cat_id' => 'required|exists:car_categories,id',
            'images.*' => 'nullable|max:2048',
            'features' => 'nullable|array',
            'features.*' => 'exists:car_features,id',
            'specifications.*.key' => 'nullable|string|in:engine,color,transmission',
            'specifications.*.value' => 'nullable|string',
            'price' => 'required|numeric',
            'is_active' => 'nullable|boolean',
        ]);
    
        $car = Cars::findOrFail($id);
        $car->title = $request->input('title');
        $car->cat_id = $request->input('cat_id');
        $car->price = $request->input('price');
        $car->is_active = $request->input('is_active', false);
        $car->save();
    
        // Update images
        if ($request->hasFile('images')) {
            // Delete old images if necessary
            CarImages::where('car_id', $car->id)->delete();
            foreach ($request->file('images') as $image) {
                $path = $image->store('car_images', 'public');
                CarImages::create([
                    'photo' => $path,
                    'car_id' => $car->id,
                ]);
            }
        }
    
        // Update features
        if ($request->has('features')) {
            $car->features()->sync($request->input('features'));
        }
    
        // Update specifications
        $specificationsData = $request->input('specifications', []);
        foreach ($specificationsData as $specification) {
            if (isset($specification['id'])) {
                // Update existing specification
                $spec = CarSpecifaction::find($specification['id']);
                if ($spec) {
                    $spec->update([
                        'model' => $specification['model'] ?? $spec->model,
                        'year' => $specification['year'] ?? $spec->year,
                        'kilo_meters' => $specification['kilo_meters'] ?? $spec->kilo_meters,
                        'fuel_type' => $specification['fuel_type'] ?? $spec->fuel_type,
                        'location' => $specification['location'] ?? $spec->location,
                    ]);
                }
            } else {
                // Create new specification
                CarSpecifaction::create(array_merge($specification, ['car_id' => $car->id]));
            }
        }
    
        $this->translateAndSave($request->all(), 'update');
    
        $redirectTo = $request->input('redirect_to', 'car.index');
        return redirect()->route($redirectTo)->with('success', 'Car updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $car = Cars::findOrFail($id);
    
       

        $car->features()->detach();
    
    
        $car->delete();
    
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


public function toggleStatusCars(Cars $ad)
{
    $ad->is_active = !$ad->is_active; // Toggle the status
    $ad->save();

    return redirect()->back()->with('status', 'Ad status updated successfully!');
}

}
