<?php
namespace App\Services;

use App\Models\NormalAds;
use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use App\Models\ImageNormalAds;

class NormalAdsService
{
public function storeNormalAd(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'cat_id' => 'required|integer',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'address' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

     

        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $countryId = $request->session()->get('country_id');

        $normalAd = new NormalAds($validatedData);
        $normalAd->country_id = $countryId;
        $normalAd->is_active = false;
        $normalAd->save();

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $imagePath = $image->store('normal_ads_images', 'public');

                ImageNormalAds::create([
                    'normal_ads_id' => $normalAd->id,
                    'image_path' => $imagePath,
                ]);
            }
        }

        return $normalAd;
    }


    
    protected function translateAndSave(array $inputs, $operation)
{
    $languages = ['en', 'fr', 'es', 'ar', 'de', 'tr', 'it', 'ja', 'zh', 'ur'];

    foreach ($inputs as $key => $value) { 
        if (is_string($value) && !empty($value)) {
            dispatch(new TranslateText($key, $value, $languages));
        }
    }
}

}