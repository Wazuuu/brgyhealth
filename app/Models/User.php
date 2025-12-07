<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Add this
        'google_id',
        'otp_code',
        'otp_expires_at',
    ];

    // Helper to check if admin
    public function isAdmin() {
        return $this->role === 'admin';
    }

    // Relationship to Resident
    public function resident() {
        return $this->hasOne(Resident::class);
    }
    
    // Relationship to HealthProfile
    public function healthProfile() {
        return $this->hasOne(HealthProfile::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
    protected $casts = [
    'email_verified_at' => 'datetime',
    'otp_expires_at' => 'datetime', // New
    'password' => 'hashed',
];
}
