<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;

    protected $fillable = ['cat_id', 'filter_name', 'filter_type', 'filter_options'];

    public function category(){

        return $this->belongsTo(Category::class,'cat_id');


    }


}
