<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'points_required',
        'type', // 'DISCOUNT_PERCENTAGE', 'DISCOUNT_FIXED_AMOUNT', 'FREE_SERVICE', 'MERCHANDISE'
        'value',
        'quantity_available',
        'is_active',
        'valid_from',
        'valid_until',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'points_required' => 'integer',
        'value' => 'decimal:2', // Sesuaikan jika perlu
        'quantity_available' => 'integer',
        'is_active' => 'boolean',
        'valid_from' => 'date',
        'valid_until' => 'date',
    ];
}