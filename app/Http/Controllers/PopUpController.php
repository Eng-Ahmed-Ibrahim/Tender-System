<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PopUpAds;
use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use Modules\Car\Models\CarCategory;
use Modules\Bike\Models\BikeCategory;
use Modules\House\Models\HouseCategory;
use Modules\Electronics\Models\ElectronicCategory;

class PopUpController extends controller
{


    public function index()
    {
        $PopUpAds = PopUpAds::with('category')->get();
        return view('backend.popup.index', compact('PopUpAds'));
    }


    public function create()
    {
        $categories = Category::WhereNull('parent_id')->get();


        return view('backend.popup.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required',
            'description' => 'nullable|string',
            'cat_id' => 'required|integer',

        ]);

      
       
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('popup', 'public');
        }
        $countryId = $request->session()->get('country_id');

        $ad = new PopUpAds();
        $ad->name = $request->name;
        $ad->price = $request->price;
        $ad->description = $request->description;
        $ad->photo =  $photoPath;
        $ad->country_id =  $countryId; 
        $ad->cat_id= $request->cat_id;



        $ad->save();

        $this->translateAndSave($request->all(), 'store');


        return redirect()->route('popup.index')->with('success', 'Commercial Ad created successfully!');
    }

 
    public function edit($id)
    {
        $ad = PopUpAds::findOrFail($id);

        $categories = Category::all();

       
        return view('backend.popup.edit', compact('ad', 'categories'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required',
            'description' => 'nullable|string',
            'cat_id' => 'required|integer',

        ]);
    

    
        $ad = PopUpAds::findOrFail($id);
    
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('popup', 'public');
            $ad->photo = $photoPath; // Update the photo only if a new one is uploaded
        }
    
        $ad->name = $request->name;
        $ad->price = $request->price;
        $ad->description = $request->description;
    
        $countryId = $request->session()->get('country_id');
        $ad->country_id = $countryId;
        $ad->cat_id= $request->cat_id;

    
        $ad->save();
    
        $this->translateAndSave($request->all(), 'update', $ad);
    
        return redirect()->route('popup.index')->with('success', 'Commercial Ad updated successfully!');
    }
    
    


    public function destroy($id)
    {
        $model = PopUpAds::findOrFail($id);
        $model->delete();

        return redirect()->back();
    }
    
    public function toggleStatus(PopUpAds $ad)
    {
        $ad->is_active = !$ad->is_active; // Toggle the status
        $ad->save();
    
        return redirect()->back()->with('status', 'Ad status updated successfully!');
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

}

