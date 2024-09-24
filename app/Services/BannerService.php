<?php

namespace App\Services;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Storage;

class BannerService
{
    public function getAllBanners()
    {
        return Banner::all();
    }

    public function createBanners(Request $request)
    {
        $photos = $request->file('photos');
        $categoryId = $request->cat_id;
     
        $countryId = $request->session()->get('country_id');

        foreach ($photos as $photo) {
            $photoPath = $photo->store('banners', 'public');

            Banner::create([
                'photo_path' => $photoPath,
                'cat_id' => $categoryId,
                'country_id' => $countryId,
            ]);
        }
    }

    public function updateBanners(Request $request, $id)
    {
        $banners = Banner::FindOrFail($id);

        foreach ($banners as $banner) {
            if ($request->hasFile('photos.' . $banner->id)) {
                if ($banner->photo_path && Storage::disk('public')->exists($banner->photo_path)) {
                    Storage::disk('public')->delete($banner->photo_path);
                }
            }
        }

        if ($request->hasFile('new_photos')) {
            foreach ($request->file('new_photos') as $newPhoto) {
                $photoPath = $newPhoto->store('banners', 'public');
                Banner::create([
                    'category_id' => $categoryId,
                    'photo_path' => $photoPath,
                    'category_type' => $request->input('category_type'),
                ]);
            }
        }
    }

    public function deletePhoto($id)
    {
        $banner = Banner::findOrFail($id);
        Storage::delete($banner->photo_path);
        $banner->delete();
    }

}
