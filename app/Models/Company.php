<?php

namespace App\Models;

use App\Models\User;
use App\Models\Tender;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model 
{


    protected $guarded=[];


  
    public function users() {


        return $this->hasMany(User::class,'company_id');
    }

    public function tenders() {

        return $this->hasMany(Tender::class);
    }

}
