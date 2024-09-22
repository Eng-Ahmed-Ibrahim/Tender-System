<?php

namespace App\Models;

use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Representative extends Model
{
    use HasFactory;

    protected $guarded=[];


    protected $table='representatives';
    

    public function country() {

        return  $this->belongsTo(Country::class);
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

}
