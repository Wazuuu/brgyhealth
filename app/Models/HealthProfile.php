<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blood_type',
        'allergies',
        'critical_allergies',
        'status',
        'clearance',
        'last_verified',
        'philhealth_number',
        'emergency_contact_name',
        'emergency_contact_phone',
        // NEW FIELDS
        'age',
        'height',
        'weight',
        'bmi',
    ];

    protected $casts = [
        'allergies' => 'array',
        'critical_allergies' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}