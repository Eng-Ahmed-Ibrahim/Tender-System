<?php

namespace App\Models;

use App\Models\Country;
use App\Models\Category;
use App\Models\Customers;
use Modules\Car\Models\Cars;
use Modules\Bike\Models\Bike;
use Modules\House\Models\House;
use Modules\Career\Models\Careers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Modules\Electronics\Models\Mobiles;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NormalAds extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customer(){

        return $this->belongsTo(Customers::class,'customer_id');
    }
  
    
    public function country() {

        return  $this->belongsTo(Country::class);
    }
    public function category(){

        return $this->belongsTo(Category::class,'cat_id');
    }

    public function images() {

        return $this->hasMany(ImageNormalAds::class,'normal_ads_id');
    } 
 
protected static function boot()
{
    parent::boot();

    static::addGlobalScope('country', function (Builder $builder) {
        
        $customer = Auth::guard('customer')->user();

        $countryId = $customer->country_id ?? session('country_id');

        if ($countryId) {
            $builder->where('country_id', $countryId);
        }
    });
}

    public function scopeActive(Builder $query)
{
    return $query->where('is_active', 1);
}


public function cars()
{

    return $this->hasOne(Cars::class,'normal_id');
}

public function bikes()

{

    return $this->hasOne(Bike::class,'normal_id');
}
public function houses()

{

    return $this->hasOne(House::class,'normal_id');
}
public function careers()

{

    return $this->hasOne(Careers::class,'normal_id');
}

public function mobiles()

{

    return $this->hasOne(Mobiles::class,'normal_id');
}


}
