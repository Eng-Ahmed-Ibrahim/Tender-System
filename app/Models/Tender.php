<?php

namespace App\Models;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tender extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    } 
    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    } 
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    } 

    public function favoritedBy()
{
    return $this->belongsToMany(User::class, 'favorites');
} 

// Tender.php
public function applicants()
{
    return $this->belongsToMany(User::class, 'applicants')
                ->withPivot('application_details', 'files','financial_file','quantity_file')
                ->withTimestamps();
}




}
