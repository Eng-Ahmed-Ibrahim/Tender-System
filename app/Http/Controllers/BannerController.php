<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\BannerService;
use App\Http\Requests\BannerRequest;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = $this->bannerService->getAllBanners();
        return view('backend.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = Category::WhereNull('parent_id')->get();
    
    
        return view('backend.banners.create', compact('categories'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->bannerService->createBanners($request);
        return redirect()->route('banners.index')->with('success', 'Banners uploaded successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $banner = Banner::find($id);
        $categories = Category::whereNull('parent_id')->get();
        return view('backend.banners.edit', compact('banner','categories'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        // Find the banner by ID
        $banner = Banner::findOrFail($id);
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'cat_id' => 'required|integer|exists:categories,id',
            'new_photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate each file
        ]);
    

        $countryId = $request->session()->get('country_id');

        // Update the banner's category
        $banner->cat_id = $request->cat_id;
        $banner->country_id = $request->cat_id;
    
        // Handle new photo uploads, if any
        if ($request->hasFile('new_photos')) {
            if ($banner->photo_path) {
                Storage::delete('public/' . $banner->photo_path);
            }
    
            // Save the new photos
            $photos = [];
            foreach ($request->file('new_photos') as $photo) {
                $path = $photo->store('banners', 'public');
                $photos[] = $path; // Save the new path(s)
            }
    
            // Assuming you're storing only one photo path
            // If you want to store multiple, adjust your database to store an array or multiple paths
            $banner->photo_path = $photos[0]; // You may want to store all paths, e.g., json_encode($photos)
        }
    
        // Save the updated banner to the database
        $banner->save();
    
        // Redirect back with a success message
        return redirect()->route('banners.index')->with('success', 'Banner updated successfully!');
    }
    
    /**
     * Remove the specified resource from storage.
     */

    public function destroy($Id)
    {
        $this->bannerService->deletePhoto($Id);
        return redirect()->back();
    }
}
