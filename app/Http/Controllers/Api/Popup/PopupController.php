<?php

namespace App\Http\Controllers\Api\Popup;

use App\Models\Category;
use App\Models\PopUpAds;
use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use App\Services\AdLimitServices;
use Modules\Car\Models\CarCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PopupResource;
use Modules\Bike\Models\BikeCategory;
use Modules\House\Models\HouseCategory;
use Modules\Electronics\Models\ElectronicCategory;

class PopupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $popup = PopUpAds::Active()->with('category')->get();

        return PopupResource::collection($popup);
        
    }

    public function store(Request $request)
    {
        $adLimitService = new AdLimitServices();
 
        if (!$adLimitService->canPostAd('popup')) {
            return response()->json(['error' => 'You have reached your ad posting limit.'], 403);
        }
        
        $request->validate([
            'name' => 'required|string',
            'price' => 'required',
            'description' => 'nullable|string',
            'cat_id' => 'required|integer',
        ]);
    
    
        // Handle file upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('popup', 'public');
        }
    
      
    
        $ad = new PopUpAds();
        $ad->name = $request->name;
        $ad->price = $request->price;
        $ad->description = $request->description;
        $ad->photo = $photoPath;
        $customer = Auth::guard('customer')->user();
        $countryId = $customer->country_id;
        $ad->country_id =  $countryId; 
        $ad->cat_id = $request->input('cat_id');

     
        $ad->save();
    
        $adLimitService->updateAdLimits('popup');
        $this->translateAndSave($request->all(), 'store');
    
        // Return success response
        return response()->json(['success' => 'Popup Ad created successfully!', 'data' => $ad], 201);
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
     $popup = PopUpAds::Active()->findOrFail($id);

      return new PopupResource($popup);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
