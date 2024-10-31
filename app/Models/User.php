<?php

namespace App\Models;

use App\Models\Tender;
use App\Models\Company;
use App\Models\Applicant;
use App\Models\Notification;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Import the trait
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function favoriteTenders()
{
    return $this->belongsToMany(Tender::class, 'favorites');
}

public function appliedTenders()
{
    return $this->belongsToMany(Tender::class, 'applicants')
                ->withPivot('application_details', 'files')
                ->withTimestamps();
}

public function notifications()
{
    return $this->hasMany(Notification::class);
}

public function unreadNotifications()
{
    return $this->notifications()->whereNull('read_at');
}


public function company() {

    return $this->belongsTo(Company::class);
}
public function latestApplications($limit = 5)
{
    return $this->applicants()
                ->with(['tender.company'])
                ->latest()
                ->take($limit);
}

// Helper method to check if user has applied to a specific tender
public function hasAppliedTo(Tender $tender)
{
    return $this->applicants()
                ->where('tender_id', $tender->id)
                ->exists();
}

// Helper method to get application for a specific tender
public function getApplicationFor(Tender $tender)
{
    return $this->applicants()
                ->where('tender_id', $tender->id)
                ->first();
}
public function applicants()
{
    return $this->hasMany(Applicant::class);
}

}
