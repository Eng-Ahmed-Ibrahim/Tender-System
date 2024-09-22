<?php

namespace Modules\Bike\Models;

use Modules\Bike\Models\Bike;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Bike\Database\Factories\BikeImagesFactory;

class BikeImages extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    
    public function bikes(){

        return $this->belongsTo(Bike::class);
    }

    protected static function newFactory(): BikeImagesFactory
    {
        //return BikeImagesFactory::new();
    }
}
