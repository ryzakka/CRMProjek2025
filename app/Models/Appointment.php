<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import BelongsTo

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'start_time',
        'end_time',
        'service_description',
        'status',
        'notes',
        'survey_sent_at', // Kita tambahkan ini jika ingin melacak kapan survei dikirim
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'appointment_date' => 'date',
        'start_time' => 'datetime:H:i', // Format sebagai waktu saja, atau 'datetime' jika ingin tanggal juga
        'end_time' => 'datetime:H:i',   // Sesuaikan format sesuai kebutuhan
        'survey_sent_at' => 'datetime',
    ];

    /**
     * Get the patient that owns the appointment.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * Get the doctor (user) associated with the appointment.
     */
    public function doctor(): BelongsTo
    {
        // Kita asumsikan 'doctor_id' di tabel 'appointments' merujuk ke 'id' di tabel 'users'
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function feedbacks(): HasMany // <-- TAMBAHKAN METHOD INI
    {
        return $this->hasMany(Feedback::class, 'appointment_id');
    }
    
}

