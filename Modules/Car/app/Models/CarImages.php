<?php

namespace Modules\Car\Models;

use Modules\Car\Models\Cars;
use Illuminate\Database\Eloquent\Model;
use Modules\Car\Database\Factories\CarImagesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarImages extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];


    public function cars(){

        return $this->belongsTo(Cars::class);
    }

    protected static function newFactory(): CarImagesFactory
    {
        //return CarImagesFactory::new();
    }
}
