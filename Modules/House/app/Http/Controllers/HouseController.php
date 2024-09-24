<?php

namespace Modules\House\Http\Controllers;

use App\Models\Category;
use App\Models\NormalAds;
use App\Jobs\TranslateText;
use App\Models\CommercialAd;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\House\Models\House;
use App\Services\AdLimitServices;
use Modules\House\Models\Feature;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\House\Models\HouseImage;
use Modules\House\Models\PopUpHouse;
use Illuminate\Http\RedirectResponse;
use Modules\House\Models\HouseDetails;
use Modules\House\Models\HouseFeature;
use Illuminate\Support\Facades\Storage;
use Modules\House\Models\HouseCategory;
use Modules\House\Models\CommercailHouse;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  

    public function index()
    {
        $ads = NormalAds::whereHas('cars')->get();
        $categories = Category::where('parent_id',2)->get();
        return view('house::index',compact('ads','categories'));
    }
    
    public function commercial(){

        $commercialAds  = CommercialAd::Where('cat_id',2)->paginate(10);
        $categories = Category::where('id',2)->first();

        return view('House::commercial',compact('commercialAds','categories'));


    }






    /**
     * Show the form for creating a new resource.
     */
    

    public function create(Request $request)
    
    {

        $catId = $request->cat_id;

        $features = Feature::all();

        
        $cat_id =Category::where('parent_id',$catId)->get();
    
        return view('house::create',compact('features','cat_id'));
    }
    
   

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'You must be logged in to post an ad.');
        }
    
        $user = Auth::user();
    
        if ($user->role_id === 2) {

            $this->processAd($request);
            
            $redirectTo = $request->input('redirect_to', 'house.index'); 
    
            return redirect()->route($redirectTo)->with('success', 'House created successfully.');
        } else {
           // $adLimitService = new AdLimitServices();
    
           // if (!$adLimitService->canPostAd('normal')) {
           //     return redirect()->back()->with('error', 'You have reached your ad posting limit.');
           // }
    
            $this->processAd($request);
    
            $redirectTo = $request->input('redirect_to', 'house.index'); 
    
            return redirect()->route($redirectTo)->with('success', 'House created successfully.');
        }
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
    
        // Handle additional images if uploaded
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
    
        return redirect()->route('house.index')->with('success', __('Car ad created successfully.'));
    }


    

    

    public function show($id)
{
    $house = House::with(['images', 'features', 'details', 'category'])->findOrFail($id);
    
   

    return view('house::show', compact('house'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $house = House::with('features', 'details')->findOrFail($id);
        $categories = HouseCategory::all(); // Adjust as necessary
        $features = Feature::all(); // Adjust as necessary
    
        return view('house::edit', compact('house', 'categories', 'features'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'cat_id' => 'required|exists:house_categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'features.*' => 'exists:features,id',
            'room_no' => 'nullable|integer',
            'price' => 'required|numeric',
            'area' => 'nullable|string',
            'location' => 'nullable|string',
            'view' => 'nullable|string',
            'building_no' => 'nullable|string',
            'history' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);
    
        $house = House::findOrFail($id);
        $house->title = $request->input('title');
        $house->cat_id = $request->input('cat_id');
        $house->price = $request->input('price');
        $house->is_active = $request->input('is_active', false);
        $house->save();
    
        // Update images
        if ($request->hasFile('images')) {
            // Delete old images if necessary
            HouseImage::where('house_id', $house->id)->delete();
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
    
        // Update house details
        $house->details()->update([
            'room_no' => $request->input('room_no'),
            'area' => $request->input('area'),
            'location' => $request->input('location'),
            'view' => $request->input('view'),
            'building_no' => $request->input('building_no'),
            'history' => $request->input('history'),
        ]);
    
        $this->translateAndSave($request->all(), 'update');
    
        return redirect()->route('house.index')->with('success', 'House updated successfully.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the house by ID
        $house = House::findOrFail($id);
    
        // Delete related images
        foreach ($house->images as $image) {
            // Delete the image file from storage if needed
            Storage::disk('public')->delete($image->image);
            // Delete the image record from the database
            $image->delete();
        }
    
        // Detach features associated with the house
        $house->features()->detach();
    
        // Delete related details
        $house->details()->delete();
    
        // Delete the house itself
        $house->delete();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'House deleted successfully.');
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

 public function toggleStatusHouse(House $ad)
{
    $ad->is_active = !$ad->is_active; // Toggle the status
    $ad->save();

    return redirect()->back()->with('status', 'Ad status updated successfully!');
}
}
