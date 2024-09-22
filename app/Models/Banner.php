<?php

namespace App\Models;

use App\Models\Country;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;

    protected $guarded=[];

    public $timestamps = false;

    
    public function category()
    {
        return $this->belongsTo(Category::class,'cat_id');
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
    

    public function country() {

        return $this->belongsTo(Country::class);
    }


    
}
