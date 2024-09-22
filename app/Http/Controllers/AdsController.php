<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class AdsController extends Controller
{

    public function MainCategory(){

        $categories = Category::whereNull('parent_id')->get();

        return view("backend.all.maincategory",compact('categories'));
    }




    public function getRelatedAds($cat_id)
    {
        $subCategories = Category::with('normalAds')
                                ->where('parent_id', $cat_id)
                                ->get();

       $Categories = Category::with(['commercialAds', 'banners', 'popupAds'])
         ->where('id', $cat_id)
        ->get();
    
        $normalAds = $subCategories->flatMap->normalAds;
        $commercialAds = $Categories->flatMap->commercialAds;
        $banners = $Categories->flatMap->banners;
        $popupAds = $Categories->flatMap->popupAds;
    
        return view("backend.all.ads", compact('subCategories', 'normalAds', 'commercialAds', 'banners', 'popupAds'));
    }
    


    



}
