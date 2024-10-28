<?php

namespace App\Models;

use App\Models\User;
use App\Models\Tender;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Applicant extends Model
{
    use HasFactory;

    protected $guarded=[];



    public function user(){

        return belongsTo(User::class,'user_id');
    }

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function isActive()
    {
        return $this->tender->end_date > now();
    }
    public function getStatusAttribute()
    {
        return $this->isActive() ? 'active' : 'closed';
    }

  

    
}
