<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment; // <-- Tambahkan ini
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini

class AppointmentController extends Controller
{
    /**
     * Show the form for a patient to create a new appointment.
     *
     * @return \Illuminate\View\View
     */
    public function index() // <-- METHOD BARU
    {
        $patientProfile = Auth::user()->patientProfile;
        if (!$patientProfile) {
            // Seharusnya tidak terjadi jika alur registrasi benar
            // Atau bisa juga redirect ke halaman untuk melengkapi profil jika user belum punya profil pasien
            return redirect()->route('dashboard')->with('error', 'Profil pasien tidak ditemukan.');
        }

        $appointments = Appointment::where('patient_id', $patientProfile->id)
                                    ->with('doctor') // Eager load data dokter
                                    ->latest('appointment_date')
                                    ->latest('start_time')
                                    ->paginate(10);

        return view('patient.appointments.index', compact('appointments'));
    }
    public function create()
    {
        $doctors = User::where('role', 'dokter')->orderBy('name')->get();
        $availableServices = [
            'Konsultasi Umum',
            'Pemeriksaan Gigi Rutin',
            'Konsultasi Diet',
            'Lainnya (jelaskan di catatan)',
        ];
        return view('patient.appointments.create', compact('doctors', 'availableServices'));
    }

    /**
     * Store a newly created appointment in storage made by a patient.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'doctor_id' => 'nullable|exists:users,id', // Dokter opsional
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            // Jika service_description_select tidak ada (karena 'Lainnya' dipilih), maka service_description_other yang divalidasi
            'service_description' => 'required_without:service_description_other|nullable|string|max:255', 
            'service_description_other' => 'required_if:service_description,Lainnya (jelaskan di catatan)|nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Ambil patient_id dari user yang sedang login
        $patientProfile = Auth::user()->patientProfile;
        if (!$patientProfile) {
            // Ini seharusnya tidak terjadi jika alur registrasi sudah benar
            return redirect()->back()->with('error', 'Profil pasien tidak ditemukan untuk pengguna ini.');
        }

        // Tentukan service_description final
        $serviceDescriptionFinal = $validatedData['service_description'];
        if ($validatedData['service_description'] === 'Lainnya (jelaskan di catatan)') {
            $serviceDescriptionFinal = $validatedData['service_description_other'] ?? 'Layanan Lainnya';
        }
         
        // Validasi tambahan: misalnya cek jam operasional klinik atau jadwal dokter yang sibuk (kompleks, bisa ditambahkan nanti)

        Appointment::create([
            'patient_id' => $patientProfile->id,
            'doctor_id' => $validatedData['doctor_id'],
            'appointment_date' => $validatedData['appointment_date'],
            'start_time' => $validatedData['start_time'],
            // 'end_time' bisa diisi oleh staf nanti saat konfirmasi, atau hitung durasi standar
            'service_description' => $serviceDescriptionFinal,
            'status' => 'Dijadwalkan', // Status awal saat pasien booking
            'notes' => $validatedData['notes'],
        ]);

        return redirect()->route('dashboard') // Arahkan ke dashboard pasien
                         ->with('success', 'Pengajuan janji temu Anda berhasil dikirim! Mohon tunggu konfirmasi dari pihak klinik.');
    }
}