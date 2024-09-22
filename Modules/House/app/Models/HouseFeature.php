<?php

namespace Modules\House\Models;

use Modules\House\Models\House;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\House\Database\Factories\HouseFeatureFactory;

class HouseFeature extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded =[];
    protected $table='house_feature';


    public function hosue(){

        return $this->belongsTo(House::class);
    }
    protected static function newFactory(): HouseFeatureFactory
    {
        //return HouseFeatureFactory::new();
    }
}
