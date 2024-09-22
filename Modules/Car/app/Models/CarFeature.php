<?php

namespace Modules\Car\Models;

use Modules\Car\Models\Cars;
use Illuminate\Database\Eloquent\Model;
use Modules\Car\Database\Factories\CarFeatureFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarFeature extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function cars(){
        return $this->belongsToMany(Cars::class, 'car_has_features', 'feature_id', 'car_id');
    }


    protected static function newFactory(): CarFeatureFactory
    {
        //return CarFeatureFactory::new();
    }
}
