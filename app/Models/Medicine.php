<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'stock',
        'expiration_date',
    ];

    // Helper to determine status based on stock
    public function getStatusAttribute()
    {
        if ($this->stock <= 0) return 'Out of Stock';
        if ($this->stock < 20) return 'Low Stock';
        return 'Available';
    }
}