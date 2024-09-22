<?php

namespace App\Models;

use App\Models\Banner;
use App\Models\Filter;
use App\Models\PopUpAds;
use App\Models\NormalAds;
use App\Models\CommercialAd;
use Modules\Car\Models\CarType;
use Modules\House\Models\House;
use Illuminate\Database\Eloquent\Model;
use Modules\NormalModule\Models\Module;
use Modules\Electronics\Models\Electronics;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded=[];
    
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }





    public function banners()
    {
        return $this->hasMany(Banner::class, 'cat_id');
    }

    public function commercialAds()
    {
        return $this->hasMany(CommercialAd::class, 'cat_id');
    } 
  

 

    public function popupAds()
    {
        return $this->hasMany(PopUpAds::class, 'cat_id');
    }

    public function normalAds()
    {
        return $this->hasMany(NormalAds::class, 'cat_id');
    } 

    public static function searchByCategory($categoryId)
    {
        return self::with(['banners', 'commercialAds', 'popupAds', 'normalAds'])
            ->where('id', $categoryId)
            ->first();
    }
    public function filters()
    {
        return $this->hasMany(Filter::class, 'cat_id');
    }
    
}


