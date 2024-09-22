<?php

namespace Modules\Bike\Models;

use App\Models\Country;
use App\Models\Customers;
use App\Models\NormalAds;
use Modules\Bike\Models\BikeImages;
use Illuminate\Support\Facades\Auth;
use Modules\Bike\Models\BikeFeature;
use Modules\Bike\Models\BikeCategory;
use Illuminate\Database\Eloquent\Model;
use Modules\Bike\Models\BikeSpecification;
use Modules\Bike\Database\Factories\BikeFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bike extends Model
{
    use HasFactory;

    protected $guarded = [];




    public function normalAds(){


        return $this->belongsTo(NormalAds::class,'normal_id');

    }

    public function images()
    {
        return $this->hasMany(BikeImages::class, 'bike_id');
    }

  
    public function features(){
        return $this->belongsToMany(BikeFeature::class,'bike_has_features', 'bike_id', 'feature_id');
    }
    


}
