<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\BannerService;
use App\Http\Requests\BannerRequest;

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
        $banners = $this->bannerService->getAllBannersGroupedByCategory();
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
    public function edit($categoryId)
    {
        $banners = $this->bannerService->getBannersByCategory($categoryId);
        return view('backend.banners.edit', compact('banners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request, string $id)
    {
        $this->bannerService->updateBanners($request, $id);
        return redirect()->route('banners.index')->with('success', 'Banners updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deletePhoto($id)
    {
        $this->bannerService->deletePhoto($id);
        return response()->json(['success' => 'Photo removed successfully!']);
    }

    public function destroy($categoryId)
    {
        $this->bannerService->deleteBannersByCategory($categoryId);
        return redirect()->back();
    }
}
