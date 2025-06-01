<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    /**
     * The name of the table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedbacks'; // <--- TAMBAHKAN BARIS INI SECARA EKSPLISIT

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'appointment_id',
        'type',
        'rating_overall_experience',
        'rating_doctor_performance',
        'rating_staff_friendliness',
        'rating_facility_cleanliness',
        'comment',
        'submitted_at',
        'status_penanganan',
        'catatan_tindak_lanjut',
        'staff_id_penanggung_jawab',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'submitted_at' => 'datetime',
        'rating_overall_experience' => 'integer',
        'rating_doctor_performance' => 'integer',
        'rating_staff_friendliness' => 'integer',
        'rating_facility_cleanliness' => 'integer',
    ];

    /**
     * Get the patient that submitted the feedback.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * Get the appointment related to this feedback (if any).
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    /**
     * Get the staff member responsible for handling the feedback.
     */
    public function staffPenanggungJawab(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id_penanggung_jawab');
    }
}