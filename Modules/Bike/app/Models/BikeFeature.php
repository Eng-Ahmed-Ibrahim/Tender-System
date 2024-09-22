<?php

namespace Modules\Bike\Models;

use Modules\Bike\Models\Bike;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Bike\Database\Factories\BikeFeatureFactory;

class BikeFeature extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function bikes(){
        return $this->belongsToMany(Bike::class,'bike_has_features','feature_id', 'bike_id');
    }


    protected static function newFactory(): BikeFeatureFactory
    {
        //return BikeFeatureFactory::new();
    }
}
