<?php

namespace App\Http\Controllers\Customer;

use App\Models\Category;
use App\Models\NormalAds;
use App\Models\CommercialAd;
use Illuminate\Http\Request;
use Modules\Car\Models\CarCategory;
use App\Http\Controllers\Controller;
use Modules\Bike\Models\BikeCategory;
use Modules\House\Models\HouseCategory;
use Modules\Career\Models\CareerCategory;
use Modules\Electronics\Models\ElectronicCategory;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $houseCategories = collect();
        $carCategories = collect();
        $bikeCategories = collect();
        $electronicCategories = collect();
        $careerCategories = collect();
        $otherCategories = collect(); 
    
        if (class_exists(HouseCategory::class)) {
            $houseCategories = HouseCategory::all(); 
        }
        if (class_exists(CarCategory::class)) {
            $carCategories = CarCategory::all();
        }
        if (class_exists(BikeCategory::class)) {
            $bikeCategories = BikeCategory::all();
        }
        if (class_exists(ElectronicCategory::class)) {
            $electronicCategories = ElectronicCategory::all();
        }
        if (class_exists(CareerCategory::class)) {
            $careerCategories = CareerCategory::all();
        }
        if (class_exists(Category::class)) { 
            $otherCategories = Category::all();
        }
    
        $categories = $otherCategories->merge($carCategories)
                                       ->merge($houseCategories)
                                       ->merge($careerCategories)
                                       ->merge($bikeCategories)
                                       ->merge($electronicCategories);
    
        $selectedCategoryId = $request->get('category_id');
        $selectedCategory = null;
    
        if ($selectedCategoryId) {
            $selectedCategory = $houseCategories->find($selectedCategoryId)
                                ?? $carCategories->find($selectedCategoryId)
                                ?? $bikeCategories->find($selectedCategoryId)
                                ?? $electronicCategories->find($selectedCategoryId)
                                ?? $careerCategories->find($selectedCategoryId)
                                ?? $otherCategories->find($selectedCategoryId);
    
            // Load related data based on the category type
            if ($selectedCategory) {
                if ($selectedCategory instanceof HouseCategory) {
                    $selectedCategory->load([
                        'house', 
                        'commercialAds'
                    ]);
                } elseif ($selectedCategory instanceof CarCategory) {
                    $selectedCategory->load([
                        'banners',
                        'cars', 
                        'commercialAds'
                    ]);
                } elseif ($selectedCategory instanceof BikeCategory) {
                    $selectedCategory->load([
                        'banners',
                        'bikes', 
                        'commercialAds'
                    ]);
                } elseif ($selectedCategory instanceof ElectronicCategory) {
                    $selectedCategory->load([
                        'banners',
                        'mobiles', 
                        'commercialAds'
                    ]);
                } elseif ($selectedCategory instanceof CareerCategory) {
                    $selectedCategory->load([
                        'banners',
                        'careers', 
                        'commercialAds'
                    ]);
                } elseif ($selectedCategory instanceof Category) { 
                    $selectedCategory->load([
                        'banners',
                        'commercialAds',
                        'normalAds' 
                    ]);
                }
            }
        }
    
        return view('customers.dashboard.index', compact('categories', 'selectedCategory'));
    }
    
    
    
    
    
    
    public function showCommercialAd($id)
    {
        $item = CommercialAd::findOrFail($id);
        return view('customers.dashboard.show.commercial', compact('item'));
    }
    
    public function showNormalAd($id)
    {
        $item = NormalAds::findOrFail($id);
        return view('customers.dashboard.show.normal', compact('item'));
    }
    

    
}
