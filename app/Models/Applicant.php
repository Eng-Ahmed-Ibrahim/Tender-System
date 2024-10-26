<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Applicant extends Model
{
    use HasFactory;

    protected $guarded=[];



    public function user(){

        return belongsTo(User::class,'user_id');
    }



  

    
}
