<?php

namespace Modules\Device\Models;

use App\Models\NormalAds;
use Illuminate\Database\Eloquent\Model;
use Modules\Device\Database\Factories\DeviceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    protected static function newFactory(): DeviceFactory
    {
        //return DeviceFactory::new();
    }

    public function normal(){

        return $this->belongsTo(NormalAds::Class);
    }
}
