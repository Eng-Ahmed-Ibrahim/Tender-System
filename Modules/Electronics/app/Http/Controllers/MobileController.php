<?php

namespace Modules\Electronics\Http\Controllers;

use App\Models\Category;
use App\Models\NormalAds;
use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\AdLimitServices;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Modules\Electronics\Models\Mobiles;
use Modules\Electronics\Models\ElectronicCategory;
use Modules\Electronics\Http\Controllers\ElectronicCategoryController;

class MobileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mobiles = Mobiles::with(['phoneFeatures', 'images'])->paginate(10);
        return view('electronics::mobiles.index',compact('mobiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $cat_id = $request->cat_id;

  
        $categories =Category::where('parent_id',$cat_id)->get();

        return view('electronics::mobiles.create',compact('categories'));
    }


    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'You must be logged in to post an ad.');
        }
    
        $user = Auth::user();
    
        if ($user->role_id === 2) {

            $this->processAd($request);
            
            $redirectTo = $request->input('redirect_to', 'mobile-normalAds.index'); 
    
            return redirect()->route($redirectTo)->with('success', 'Mobile created successfully.');
        } else {
            $adLimitService = new AdLimitServices();
    
         //   if (!$adLimitService->canPostAd('normal')) {
             //   return redirect()->back()->with('error', 'You have reached your ad posting limit.');
            //}
    
            $this->processAd($request);
    
            $redirectTo = $request->input('redirect_to', 'mobile-normalAds.index'); 
    
            return redirect()->route($redirectTo)->with('success', 'Mobile created successfully.');
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
        
    
        return redirect()->route('mobiles.index')->with('success', __('Car ad created successfully.'));
    }
    
    
    
   

 

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $mobile = Mobiles::with('phoneFeatures', 'images')->findOrFail($id);
        $categories = ElectronicCategory::all();
        return view('electronics::mobiles.show',compact('mobile','categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $mobile = Mobiles::with('phoneFeatures', 'images')->findOrFail($id);
    $categories = ElectronicCategory::all();
    return view('electronics::mobiles.edit', compact('mobile', 'categories'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string',
            'cat_id' => 'required|exists:electronic_categories,id',
            'storage' => 'required|string',
            'ram' => 'required|string',
            'disply_size' => 'required|string',
            'sim_no' => 'required|integer',
            'description' => 'required',
            'status' => 'required',
            'mobile_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric',
            'is_active' => 'nullable|boolean',
        ]);
    
        $mobile = Mobiles::findOrFail($id);
    
        $mobile->update([
            'title' => $request->title,
            'cat_id' => $request->cat_id,
            'price' => $request->price,
            'is_active' => $request->is_active,
        ]);
    
        $mobile->phoneFeatures()->update([
            'storage' => $request->storage,
            'ram' => $request->ram,
            'disply_size' => $request->disply_size,
            'sim_no' => $request->sim_no,
            'status' => $request->status,
            'description' => $request->description,
        ]);
    
        if ($request->hasFile('mobile_images')) {
            // Delete old images if you want to replace them
            foreach ($mobile->images as $image) {
                Storage::disk('public')->delete($image->photo_path);
                $image->delete();
            }
    
            // Store new images
            foreach ($request->file('mobile_images') as $file) {
                $path = $file->store('public/mobiles');
                $mobile->images()->create([
                    'photo_path' => Storage::url($path),
                ]);
            }
        }
    
        // Translate and save the updated data
        $this->translateAndSave($request->all(), 'update');
    
        return redirect()->route('mobile-normalAds.index')->with('success', 'Mobile updated successfully.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
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

    public function toggleStatusMobile(Mobiles $ad)
{
    $ad->is_active = !$ad->is_active; // Toggle the status
    $ad->save();

    return redirect()->back()->with('status', 'Ad status updated successfully!');
}

}
