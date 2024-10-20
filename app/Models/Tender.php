<?php

namespace App\Models;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tender extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'end_date',
        'edit_end_date',
        'qr_code',
        'show_applicants',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    } 

    public function favoritedBy()
{
    return $this->belongsToMany(User::class, 'favorites');
}

// Tender.php
public function applicants()
{
    return $this->belongsToMany(User::class, 'applicants')
                ->withPivot('application_details', 'files')
                ->withTimestamps();
}




}
