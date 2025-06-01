<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens; // Dihapus jika tidak pakai Sanctum
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- TAMBAHKAN INI
// use App\Models\Appointment; // Tidak perlu import di sini jika hanya digunakan di method return type atau di dalam method
// use App\Models\Feedback; // Tidak perlu import di sini jika hanya digunakan di method return type atau di dalam method


class User extends Authenticatable
{
    use /* HasApiTokens, */ HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
        'is_active',
        'gender',
        'specialization',
        'room',
        'availability_schedule',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function patientProfile(): HasOne
    {
        return $this->hasOne(Patient::class, 'user_id', 'id');
    }

    /**
     * Get the appointments handled by the doctor.
     */
    public function appointmentsAsDoctor(): HasMany // <-- TAMBAHKAN METHOD INI
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    /**
     * Accessor for average doctor rating.
     * Akan bisa diakses sebagai $user->average_doctor_rating
     */
    public function getAverageDoctorRatingAttribute(): ?float // <-- TAMBAHKAN ACCESSOR INI
    {
        // Mengambil semua ID janji temu yang ditangani oleh dokter ini
        $appointmentIds = $this->appointmentsAsDoctor()->pluck('id');

        if ($appointmentIds->isEmpty()) {
            return null; // Tidak ada janji temu, jadi tidak ada rating
        }

        // Menghitung rata-rata rating_doctor_performance dari feedback yang terkait dengan janji temu dokter ini
        $averageRating = Feedback::whereIn('appointment_id', $appointmentIds)
                                ->whereNotNull('rating_doctor_performance')
                                ->avg('rating_doctor_performance');
        
        return $averageRating ? round($averageRating, 1) : null; // Bulatkan ke 1 desimal
    }

    /**
     * Accessor for doctor rating count.
     * Akan bisa diakses sebagai $user->doctor_rating_count
     */
    public function getDoctorRatingCountAttribute(): int // <-- TAMBAHKAN ACCESSOR INI
    {
        $appointmentIds = $this->appointmentsAsDoctor()->pluck('id');

        if ($appointmentIds->isEmpty()) {
            return 0;
        }

        return Feedback::whereIn('appointment_id', $appointmentIds)
                           ->whereNotNull('rating_doctor_performance')
                           ->count();
    }
}