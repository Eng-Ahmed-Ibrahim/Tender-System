<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Customers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImageNormalAds extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps= false;

    public function normalAd()
    {
        return $this->belongsTo(NormalAd::class, 'normal_ads_id');
    }
   
}
