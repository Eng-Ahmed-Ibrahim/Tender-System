<?php

namespace Modules\Electronics\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Electronics\Models\Mobiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Electronics\Database\Factories\PhoneImageFactory;

class phoneImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

     public function mobile()
     {
         return $this->belongsTo(Mobiles::class, 'mobile_id');
     }
    protected $guarded = [];

    protected static function newFactory(): PhoneImageFactory
    {
        //return PhoneImageFactory::new();
    }
}
