<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\User; // <-- Pastikan ini ada
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini untuk query group by yang lebih fleksibel
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Statistik yang sudah ada
        $totalPatients = Patient::count();
        $totalAppointments = Appointment::count();
        $completedAppointments = Appointment::where('status', 'Selesai')->count();
        $scheduledAppointments = Appointment::whereIn('status', ['Dijadwalkan', 'Dikonfirmasi'])
                                            // ->where('appointment_date', '>=', Carbon::today()) // Opsional
                                            ->count();
        $totalLoyaltyPointsInCirculation = Patient::sum('total_loyalty_points');

        // --- AWAL STATISTIK BARU ---

        // 1. Dokter yang paling sering praktek (Top 5)
        $topDoctors = Appointment::join('users', 'appointments.doctor_id', '=', 'users.id')
            ->select('users.name as doctor_name', DB::raw('count(appointments.id) as appointment_count'))
            ->whereNotNull('appointments.doctor_id') // Hanya janji temu yang ada dokternya
            ->groupBy('appointments.doctor_id', 'users.name')
            ->orderBy('appointment_count', 'desc')
            ->take(5) // Ambil 5 teratas
            ->get();

        // 2. Layanan yang paling sering digunakan (Top 5)
        $topServices = Appointment::select('service_description', DB::raw('count(*) as service_count'))
            ->whereNotNull('service_description') // Hanya yang service_description nya tidak null
            ->where('service_description', '!=', '') // Dan tidak string kosong
            ->groupBy('service_description')
            ->orderBy('service_count', 'desc')
            ->take(5) // Ambil 5 teratas
            ->get();

        // 3. Distribusi Tipe Pasien
        $patientTypeDistribution = Patient::select('patient_type', DB::raw('count(*) as patient_count'))
            ->whereNotNull('patient_type') // Hanya yang patient_type nya tidak null
            ->where('patient_type', '!=', '') // Dan tidak string kosong
            ->groupBy('patient_type')
            ->orderBy('patient_count', 'desc')
            ->get();

        // --- AKHIR STATISTIK BARU ---

        return view('reports.index', compact(
            'totalPatients',
            'totalAppointments',
            'completedAppointments',
            'scheduledAppointments',
            'totalLoyaltyPointsInCirculation',
            'topDoctors', // Kirim data baru ke view
            'topServices', // Kirim data baru ke view
            'patientTypeDistribution' // Kirim data baru ke view
        ));
    }
}