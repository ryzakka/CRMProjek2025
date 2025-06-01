<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoyaltyPointTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'appointment_id',
        'promotion_id', // <-- TAMBAHKAN INI
        'points',
        'description',
        'transaction_date',
        'staff_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'transaction_date' => 'datetime',
        'points' => 'integer',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function appointment(): BelongsTo
    {
        // Pastikan appointment_id adalah nullable di database jika tidak selalu ada
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function staff(): BelongsTo
    {
        // Pastikan staff_id adalah nullable di database jika tidak selalu ada
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Get the promotion associated with the loyalty point transaction.
     */
    public function promotion(): BelongsTo // <-- TAMBAHKAN METHOD RELASI INI
    {
        // Pastikan promotion_id adalah nullable di database
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }
}