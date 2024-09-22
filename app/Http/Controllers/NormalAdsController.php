<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customers;
use App\Models\NormalAds;
use Illuminate\Http\Request;
use App\Models\ImageNormalAds;
use App\Services\AdLimitServices;
use App\Services\NormalAdsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BaseController;

class NormalAdsController extends Controller
{

    protected $normalAdsService;

    public function __construct(NormalAdsService $normalAdsService)
    {
        $this->normalAdsService = $normalAdsService;
    }

    public function index(Request $request)
    {
        $query = NormalAds::query();
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%');
        }

        if ($request->filled('is_active')) {
            $isActive = $request->input('is_active');
            $query->where('is_active', $isActive);
        }
        
        if ($request->filled('category_id')) { 
            $categoryId = $request->input('category_id');
            $query->where('cat_id', $categoryId);
        }
        
        if ($request->filled('customer_id')) {
            $customerId = $request->input('customer_id');
            $query->where('customer_id', $customerId);
        }
    
        $ads = $query->with('category', 'customer', 'images')->get();
        
        $categories = Category::all();
        $customers = Customers::all();
    
        return view('backend.normalads.index', compact('ads', 'categories', 'customers'));
    }
    
    public function selectCategory()
    {
        $categories = Category::whereNull('parent_id')->get();

        return view('backend.normalads.category', compact('categories'));
    }

    public function create(Request $request)
    {
        $category = Category::find($request->cat_id);

        if (!$category) {
            return redirect()->back()->with('error', 'Invalid category selected.');
        }

        $cat_id = $category->id;


        if ($category->id === 1) {

            return redirect()->route('car.create', ['cat_id' => $cat_id]);

        } elseif ($category->id === 2) {

            return redirect()->route('house.create', ['cat_id' => $cat_id]);
        } 
         elseif ($category->id === 9) {

            return redirect()->route('bike.create', ['cat_id' => $cat_id]);

        }    elseif ($category->title === 'Careers') {

            return redirect()->route('career.create', ['cat_id' => $cat_id]);

        }
        elseif ($category->title === 'Mobiles') {

            return redirect()->route('mobile-normalAds.create', ['cat_id' => $cat_id]);

        }
        
        else{

            return view('backend.normalads.create',['cat_id' => $cat_id]);
        }

        return redirect()->back()->with('error', 'Form not available for this category.');




    }
    
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'You must be logged in to post an ad.');
        }
    
        $user = Auth::user();
    
        if ($user->role_id === 2) {

            $this->processAd($request);
    
            return redirect()->route('normalads.index')->with('success', 'Record created successfully.');
        } else {
    
    
            $this->processAd($request);
    
        
    
            return redirect()->route('normalads.index')->with('success', 'Record created successfully.');
        }
    }



    protected function processAd(Request $request)
    {
       
        $normalAd = $this->normalAdsService->storeNormalAd($request);

    }

    public function update(Request $request, $id)
    {
        $model = NormalAds::findOrFail($id);
    
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'cat_id' => 'required|integer',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'is_active' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Handle file uploads for the main photo field
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($model->photo) {
                Storage::disk('public')->delete($model->photo);
            }
            // Store the new photo
            $validatedData['photo'] = $request->file('photo')->store('photos', 'public');
        }
    
        // Update the model instance with the validated data
        $model->update($validatedData);
    
        // Handle image uploads for additional images
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $imagePath = $image->store('normal_ads_images', 'public');
    
                // Save each image record to the database
                ImageNormalAds::create([
                    'normal_ads_id' => $model->id,
                    'image_path' => $imagePath, 
                ]);
            }
        }
    
        // Handle any additional operations like translations
        $this->translateAndSave($request->all(), 'update');
    
        return redirect()->route('normalads.index')->with('success', 'Record updated successfully.');
    }
    public function show($id)
    {
        // Retrieve the NormalAds record by its ID
        $normalAd = NormalAds::with('images')->findOrFail($id);
    
        // Pass the record and its related images to the view
        return view('backend.normalads.show', compact('normalAd'));
    }
    
    

public function toggleStatus(NormalAds $ad)
{
    $ad->is_active = !$ad->is_active; // Toggle the status
    $ad->save();

    return redirect()->back()->with('status', 'Ad status updated successfully!');
}

    
}
