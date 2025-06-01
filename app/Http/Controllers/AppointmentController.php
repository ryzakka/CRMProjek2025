<?php

namespace App\Http\Controllers;

use App\Models\Appointment; // Ini akan otomatis ditambahkan
use Illuminate\Http\Request;
use App\Models\Patient; // Tambahkan ini
use App\Models\User;
use App\Models\LoyaltyPointTransaction;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data janji temu, diurutkan terbaru, dengan data pasien dan dokter terkait (eager loading)
        // dan menggunakan pagination.
        $appointments = Appointment::with(['patient', 'doctor'])
                                    ->latest('appointment_date') // Urutkan berdasarkan tanggal janji temu terbaru
                                    ->latest('start_time')     // Kemudian berdasarkan waktu mulai terbaru
                                    ->paginate(10);

        return view('appointments.index', compact('appointments'));
        // Mengirim data $appointments ke view 'appointments.index'
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil semua pasien untuk ditampilkan di dropdown
        $patients = Patient::orderBy('name')->get();

        // Mengambil semua user yang memiliki peran 'dokter' untuk ditampilkan di dropdown
        // Kita asumsikan Anda memiliki kolom 'role' di tabel 'users'
        // dan salah satu nilainya adalah 'dokter'
        $doctors = User::where('role', 'dokter')->orderBy('name')->get();
        // Jika peran dokter disimpan berbeda, sesuaikan query ini
        $availableServices = [
        'Konsultasi Umum',
        'Pemeriksaan Gigi Rutin',
        'Pembersihan Karang Gigi',
        'Tambal Gigi',
        'Cabut Gigi',
        'Perawatan Saluran Akar',
        'Pemasangan Kawat Gigi',
        'Bleaching (Pemutihan Gigi)',
        'Veneer Gigi',
        'Implan Gigi',
        'Kontrol Pasca Perawatan',
        'Lainnya (jelaskan di catatan)' // Opsi untuk custom
    ];
        return view('appointments.create', compact('patients', 'doctors', 'availableServices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Langkah 1: Validasi input dari form
    $validatedData = $request->validate([
        'patient_id' => 'required|exists:patients,id',
        'doctor_id' => 'nullable|exists:users,id', // Pastikan user dengan id ini adalah dokter (bisa ditambahkan validasi role jika perlu)
        'appointment_date' => 'required|date',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'nullable|date_format:H:i|after:start_time',
        'service_description' => 'nullable|string|max:255',
        'status' => 'required|string|in:Dijadwalkan,Dikonfirmasi,Selesai,Dibatalkan Pasien,Dibatalkan Klinik,Tidak Hadir',
        'notes' => 'nullable|string',
    ]);

    // Anda mungkin ingin menambahkan logika tambahan di sini, misalnya:
    // - Mengecek apakah dokter tersedia pada tanggal dan waktu tersebut (ini cukup kompleks untuk sekarang)
    // - Jika 'doctor_id' null, mungkin ada logika default atau status tertentu

    // Langkah 2: Buat record janji temu baru di database
    // Ini bisa dilakukan karena kita sudah mendefinisikan $fillable di Model Appointment
    $appointment = Appointment::create($validatedData);

    // Langkah 3: Redirect ke halaman daftar janji temu dengan pesan sukses
    return redirect()->route('appointments.index')
                     ->with('success', 'Janji temu baru berhasil ditambahkan!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment) // $appointment otomatis di-inject
{
    // Eager load relasi patient dan doctor untuk ditampilkan di view
    $appointment->load(['patient', 'doctor']);

    return view('appointments.show', compact('appointment'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment) // Type-hint Appointment $appointment
    {
        $patients = Patient::orderBy('name')->get();
    $doctors = User::where('role', 'dokter')->orderBy('name')->get(); // Sesuaikan jika nama peran berbeda
 $availableServices = [
        'Konsultasi Umum',
        'Pemeriksaan Gigi Rutin',
        'Pembersihan Karang Gigi',
        'Tambal Gigi',
        'Cabut Gigi',
        'Perawatan Saluran Akar',
        'Pemasangan Kawat Gigi',
        'Bleaching (Pemutihan Gigi)',
        'Veneer Gigi',
        'Implan Gigi',
        'Kontrol Pasca Perawatan',
        'Lainnya (jelaskan di catatan)'
    ];
    return view('appointments.edit', compact('appointment', 'patients', 'doctors', 'availableServices'));

    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, Appointment $appointment)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:users,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'service_description' => 'nullable|string|max:255',
            'status' => 'required|string|in:Dijadwalkan,Dikonfirmasi,Selesai,Dibatalkan Pasien,Dibatalkan Klinik,Tidak Hadir',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $appointment->status; // Ambil status lama sebelum diupdate

        $appointment->update($validatedData);

        // --- AWAL LOGIKA PENAMBAHAN POIN LOYALITAS ---
        if ($validatedData['status'] == 'Selesai' && $oldStatus != 'Selesai') {
            $patient = $appointment->patient; // Mengambil objek pasien dari relasi
            if ($patient) {
                $pointsToAward = 10; // Tentukan berapa poin yang diberikan per kunjungan selesai

                // 1. Tambah poin ke pasien
                $patient->total_loyalty_points += $pointsToAward;
                $patient->save();

                // 2. Catat transaksi poin
                LoyaltyPointTransaction::create([
                    'patient_id' => $appointment->patient_id,
                    'appointment_id' => $appointment->id,
                    'points' => $pointsToAward,
                    'description' => 'Poin dari janji temu selesai pada ' . $appointment->appointment_date->isoFormat('D MMM YYYY'),
                    // 'transaction_date' akan otomatis diisi current timestamp berdasarkan migrasi
                    // 'staff_id' bisa diisi jika ada staf yang memverifikasi penyelesaian, untuk saat ini kita kosongkan
                ]);
            }
        }
        // --- AKHIR LOGIKA PENAMBAHAN POIN LOYALITAS ---

        return redirect()->route('appointments.index')
                         ->with('success', 'Janji temu berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment) // Type-hint Appointment $appointment
    {
        // Logika tambahan bisa di sini sebelum menghapus,
    // misalnya, cek apakah janji temu ini boleh dihapus berdasarkan statusnya,
    // atau membuat log aktivitas penghapusan.
    // Untuk saat ini, kita langsung hapus.

    $appointment->delete();

    // Redirect ke halaman daftar janji temu dengan pesan sukses
    return redirect()->route('appointments.index')
                     ->with('success', 'Janji temu berhasil dihapus!');
    }
}