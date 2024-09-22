<?php

namespace App\Http\Controllers\Customer;

use App\Models\Category;
use App\Models\NormalAds;
use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use Modules\Car\Models\Cars;
use Modules\Bike\Models\Bike;
use App\Models\ImageNormalAds;
use Modules\House\Models\House;
use App\Services\AdLimitServices;
use Modules\Car\Models\CarFeature;
use Modules\Car\Models\CarCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Bike\Models\BikeFeature;
use Modules\Bike\Models\BikeCategory;
use Modules\House\Models\HouseFeature;
use Modules\Electronics\Models\Mobiles;
use Modules\House\Models\HouseCategory;
use Modules\Electronics\Models\ElectronicCategory;

class CustomerAdsController extends Controller
{



    public function create() {
        $categories = collect([
            HouseCategory::whereNull('parent_id')->with('children')->get()->map(fn($category) => [
                'id' => $category->id, 
                'title' => $category->title, 
                'type' => 'category1',
                'children' => $category->children
            ]),
            ElectronicCategory::whereNull('parent_id')->with('children')->get()->map(fn($category) => [
                'id' => $category->id, 
                'title' => $category->title, 
                'type' => 'category2',
                'children' => $category->children
            ]),
            CarCategory::whereNull('parent_id')->with('children')->get()->map(fn($category) => [
                'id' => $category->id, 
                'title' => $category->title, 
                'type' => 'category3',
                'children' => $category->children
            ]),
            BikeCategory::whereNull('parent_id')->with('children')->get()->map(fn($category) => [
                'id' => $category->id, 
                'title' => $category->title, 
                'type' => 'category4',
                'children' => $category->children
            ]),
            Category::whereNull('parent_id')->with('children')->get()->map(fn($category) => [
                'id' => $category->id, 
                'title' => $category->title, 
                'type' => 'category5',
                'children' => $category->children
            ])
        ])->flatten(1);
    
        return view("customers.ads.create", compact('categories'));
    }

public function store(Request $request)
{


    $adLimitService = new AdLimitServices();


    if (!$adLimitService->canPostAd('normal')) {
        return redirect()->back()->with('error', 'You have reached your ad posting limit.');
    }

    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'cat_id' => 'required|integer',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Check if the category exists
 
    // Handle the photo upload if present
    if ($request->hasFile('photo')) {
        $validatedData['photo'] = $request->file('photo')->store('photos', 'public');
    }

    // Retrieve country ID from session
    $countryId = $request->session()->get('country_id');
    
    // Create a new advertisement record
    $ads = new NormalAds($validatedData);
    $ads->country_id = $countryId; 
    $ads->customer_id = Auth::guard('customer')->id();
    $ads->is_active = false;
    $ads->save();

    // Handle the images upload if present
    if ($request->hasFile('images')) {
        $images = $request->file('images');
        foreach ($images as $image) {
            $imagePath = $image->store('normal_ads_images', 'public');

            ImageNormalAds::create([
                'normal_ads_id' => $ads->id,
                'image_path' => $imagePath,
            ]);
        }
    }

    $this->translateAndSave($request->all(), 'store');


    $adLimitService->updateAdLimits('normal');

    return redirect()->route('normal.customer.index')->with('success', 'Record created successfully.');
}

public function normal()
{
    $customerId = Auth::guard('customer')->id();
    
    // Fetch both NormalAds and House ads for the authenticated customer

    $normals = NormalAds::where('customer_id', $customerId)->get();
    $houses = House::where('customer_id', $customerId)->get();
    $cars = Cars::where('customer_id', $customerId)->get();
    $bikes = Bike::where('customer_id', $customerId)->get();
    $mobiles = Mobiles::where('customer_id', $customerId)->get();
    
    // Combine both collections
    $ads = $normals->merge($houses)->merge($bikes)->merge($cars)->merge($mobiles);

    return view('customers.ads.normal', compact('ads'));
}

   
public function createView($cat_id)

{

    return view('customers.ads.ads_create', ['cat_id' => $cat_id]);
}


public function createHouseAds($cat_id) {

    $features = HouseFeature::all();
    
    return view('customers.ads.create.house',[

        'features'=>$features,
        
        'cat_id'=>$cat_id
    ]);
}

public function createElectronicAds($cat_id) {


    $category = ElectronicCategory::find($cat_id);

    return view('customers.ads.create.mobile', ['cat_id' => $cat_id]);
}

public function createCarAds($cat_id) {

    $specifications = [
        ['key' => 'engine', 'label' => 'Engine'],
        ['key' => 'color', 'label' => 'Color'],
        ['key' => 'transmission', 'label' => 'Transmission'],
        // Add more predefined keys as needed
    ];
    $features = CarFeature::all();
    $category = CarCategory::find($cat_id);
    return view('customers.ads.create.car', [

        'features'=>$features,
        
        'cat_id'=>$cat_id,

        'specifications' =>$specifications

    
    ]);
}

public function createBikeAds($cat_id) {

    $category = BikeCategory::find($cat_id);

    
    $specifications = [
        ['key' => 'engine', 'label' => 'Engine'],
        ['key' => 'color', 'label' => 'Color'],
        ['key' => 'transmission', 'label' => 'Transmission'],
        // Add more predefined keys as needed
    ];

    $features = BikeFeature::all();

    $categories = BikeCategory::all();
    return view('customers.ads.create.bike', [

        'features'=>$features,
        
        'cat_id'=>$cat_id,

        'specifications' =>$specifications


    ]);
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
