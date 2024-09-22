<?php

namespace Modules\Car\Models;

use App\Models\Country;
use App\Models\Customers;
use App\Models\NormalAds;
use Modules\Car\Models\Brand;
use Modules\Car\Models\CarImages;
use Modules\Car\Models\CarFeature;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Modules\Car\Database\Factories\CarsFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cars extends Model
{
    use HasFactory;


    
    
    protected $guarded = [];



    public function normalAds(){


        return $this->belongsTo(NormalAds::class,'normal_id');

    }
    
    public function images()
    {
        return $this->hasMany(CarImages::class, 'car_id');
    }

 
    public function brands(){
        
        return $this->belongsTo(Brand::class,'brand_id');

    }

    
    public function features(){
        
        return $this->belongsToMany(CarFeature::class, 'car_has_features', 'car_id', 'feature_id');
    }
 

}
