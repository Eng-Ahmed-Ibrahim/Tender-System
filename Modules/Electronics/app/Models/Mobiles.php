<?php

namespace Modules\Electronics\Models;

use App\Models\Country;
use App\Models\Customers;
use App\Models\NormalAds;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Modules\Electronics\Models\PhoneImage;
use Modules\Electronics\Models\PhoneFeatures;
use Modules\Electronics\Models\ElectronicCategory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Electronics\Database\Factories\MobilesFactory;

class Mobiles extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function normalAds(){


        return $this->belongsTo(NormalAds::class,'normal_id');

    }

 
    public function images(){

        return $this->hasMany(PhoneImage::class,'mobile_id');
    }
  


   
}
