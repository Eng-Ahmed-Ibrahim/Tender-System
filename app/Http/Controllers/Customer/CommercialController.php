<?php

namespace App\Http\Controllers\Customer;

use App\Models\Category;
use App\Jobs\TranslateText;
use App\Models\CommercialAd;
use Illuminate\Http\Request;
use App\Services\AdLimitServices;
use Modules\Car\Models\CarCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Bike\Models\BikeCategory;
use Modules\House\Models\HouseCategory;
use Modules\Electronics\Models\ElectronicCategory;

class CommercialController extends Controller
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
    
        return view("customers.commercial.create", compact('categories'));
    }
   
    public function index()
    {
        $customerId = Auth::guard('customer')->id();
        
        // Fetch both NormalAds and House ads for the authenticated customer
    
        $ads = CommercialAd::where('customer_id', $customerId)->get();
       
        
        // Combine both collections
    
        return view('customers.commercial.index', compact('ads'));
    }
    public function store(Request $request)
    {
        $adLimitService = new AdLimitServices();


        if (!$adLimitService->canPostAd('commercial')) {
            return redirect()->back()->with('error', 'You have reached your ad posting limit.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|integer',
            'category_type' => 'required|string|in:category1,category2,category3,category4,category5',
            'photo_path' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
    
        // Get the category model based on type
        $categoryModel = $this->getCategoryModel($request->category_type);
    
        if (!$categoryModel) {
            return redirect()->back()->withErrors(['category_type' => 'Invalid category type.']);
        }
    
        // Handle file upload
        $photoPath = null;
        if ($request->hasFile('photo_path')) {
            $photoPath = $request->file('photo_path')->store('commercial', 'public');
        }
    
        // Create the ad
        $ad = new CommercialAd();
        $ad->title = $request->input('title');
        $ad->description = $request->input('description');
        $ad->photo_path = $photoPath;
        $ad->is_active = false;
        $ad->customer_id = Auth::guard('customer')->id();
        $ad->country_id = $request->session()->get('country_id'); // Assuming country_id is stored in session
    
        // Associate the ad with the correct category
        $ad->category()->associate($categoryModel::find($request->input('category_id')));
    
        // Save the ad
        $ad->save();
        $adLimitService->updateAdLimits('commercial');
        $this->translateAndSave($request->all(), 'store');



        return redirect()->route('commercial.customer.index')->with('success', 'Commercial Ad created successfully!');
    }
    
    public function createView($cat_id, $type)

    {
    
        return view('customers.commercial.ads_create', ['cat_id' => $cat_id, 'type' =>$type]);
    }


    private function getCategoryModel($type)
{
    $mapping = [
        'category1' => HouseCategory::class,
        'category2' => ElectronicCategory::class,
        'category3' => CarCategory::class,
        'category4' => BikeCategory::class,
        'category5' => Category::class,
    ];

    return $mapping[$type] ?? null;
}

protected function translateAndSave(array $inputs, $operation)
{
    $languages = ['en', 'fr', 'es', 'ar'];

    foreach ($inputs as $key => $value) { 
        if (is_string($value) && !empty($value)) {
            // Dispatch the job for each input value
            dispatch(new TranslateText($key, $value, $languages));
        }
    }
}
}