<?php

namespace Modules\House\Models;

use App\Models\Country;
use App\Models\Customers;
use App\Models\NormalAds;
use Modules\House\Models\Feature;
use Illuminate\Support\Facades\Auth;
use Modules\House\Models\HouseImage;
use Modules\House\Models\HouseDetails;
use Modules\House\Models\HouseFeature;
use Illuminate\Database\Eloquent\Model;
use Modules\House\Models\HouseCategory;
use Modules\House\Database\Factories\HouseFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class House extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded= [];

    protected $table='house';

    public function normalAds(){


        return $this->belongsTo(NormalAds::class,'normal_id');

    }

    public function images()
    {
        return $this->hasMany(HouseImage::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class,'house_feature');
    }

  
}
