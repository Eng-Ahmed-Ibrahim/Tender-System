<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model 
{


    protected $guarded=[];


  
    public function users() {


        return $this->hasMany(User::class,'company_id');
    }

}
