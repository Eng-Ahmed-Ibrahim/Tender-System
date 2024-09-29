<?php

namespace App\Models;

use App\Models\Country;
use App\Models\Category;
use App\Models\Customers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommercialAd extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'photo_path'];

    public function category()
    {
        return $this->belongsTo(Category::class,'cat_id');
    }
    

    public function customer() {

        return $this->belongsTo(Customers::class);
    }

    
 
    public function country() {

        return  $this->belongsTo(Country::class,'country_id');
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

}
