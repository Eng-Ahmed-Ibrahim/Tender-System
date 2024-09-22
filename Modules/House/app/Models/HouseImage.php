<?php

namespace Modules\House\Models;

use Modules\House\Models\House;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\House\Database\Factories\HouseImageFactory;

class HouseImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded =[];

    protected $table='house_images';

    public function house(){

        return $this->belongsTo(House::class);
    }
    protected static function newFactory(): HouseImageFactory
    {
        //return HouseImageFactory::new();
    }
}
