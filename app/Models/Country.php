<?php

namespace App\Models;

use App\Models\Banner;
use App\Models\PopUpAds;
use App\Models\NormalAds;
use App\Models\CommercialAd;
use Modules\Car\Models\Cars;
use Modules\Bike\Models\Bike;
use Modules\House\Models\House;
use Illuminate\Database\Eloquent\Model;
use Modules\Electronics\Models\Mobiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;
    
    protected $guarded=[];

    public function NormalAds(){

        return $this->hasMany(NormalAds::class,'country_id');
    }
 
    public function CommercialAds() // Correct spelling here
    {
        return $this->hasMany(CommercialAd::class, 'country_id');
    }
    
    public function popUpAds(){

        return $this->hasMany(PopUpAds::class,'country_id');
    }
    
    public function banners(){

        return $this->hasMany(Banner::class,'country_id');
    }

}
