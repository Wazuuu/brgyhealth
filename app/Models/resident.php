<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Linked User
        'name',
        'contact_number',
        'age',
        'gender',
        'blood_type',
        'allergies',
        'is_pregnant',
        'is_sick',
        'status',
    ];

    protected $casts = [
        'is_pregnant' => 'boolean',
        'is_sick' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}