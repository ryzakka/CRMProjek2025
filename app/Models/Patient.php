<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Pastikan ini ada

class Patient extends Model
{
    use HasFactory;

    // Di dalam class Patient extends Model
protected $fillable = [
    'user_id',
    'name',
    'phone_number',
    'email',
    'date_of_birth',
    'gender',
    'patient_type', // <-- TAMBAHKAN INI
    'address',
    'registration_date',
    'total_loyalty_points',
    'preferences_notes',
];

    protected $casts = [
        'date_of_birth' => 'date',
        'registration_date' => 'date',
        'total_loyalty_points' => 'integer',
    ];

    /**
     * Get the user account associated with the patient profile.
     */
    public function user(): BelongsTo // Relasi ke User
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}