<?php

namespace Modules\House\Models;

use Modules\House\Models\House;
use Illuminate\Database\Eloquent\Model;
use Modules\House\Database\Factories\FeatureFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feature extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title'];

    public function houses()
    {
        return $this->belongsToMany(House::class, 'house_feature');
    }
    protected static function newFactory(): FeatureFactory
    {
        //return FeatureFactory::new();
    }
}
