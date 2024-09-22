<?php

namespace App\Http\Controllers\Api\Banners;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Services\BannerService;
use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;

class BannerController extends Controller
{
    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }
    
    public function index()
    {
        $banners = Banner::all();

        return BannerResource::collection($banners);
        
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
     * Display the specified resource.
     */
    public function show($id)
    {
     $banner = Banner::findOrFail($id);

      return new BannerResource($banner);

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
}
