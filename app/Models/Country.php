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


}
