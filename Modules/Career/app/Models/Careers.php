<?php

namespace Modules\Career\Models;

use App\Models\Country;
use App\Models\Customers;
use App\Models\NormalAds;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\Career\Database\Factories\CareersFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Careers extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    protected $table="careers";
    
   
    
    public function normalAds(){


        return $this->belongsTo(NormalAds::class,'normal_id');

    }


   

    


}
