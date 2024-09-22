<?php

namespace Modules\Electronics\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Electronics\Models\Mobiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Electronics\Database\Factories\PhoneFeaturesFactory;

class phoneFeatures extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function mobile()
    {
        return $this->belongsTo(Mobiles::class, 'mobile_id');
    }

    protected static function newFactory(): PhoneFeaturesFactory
    {
        //return PhoneFeaturesFactory::new();
    }
}
