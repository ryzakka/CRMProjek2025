<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\LoyaltyPointTransaction;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::latest()->paginate(10); // Mengambil semua pasien, diurutkan terbaru, dengan pagination
        return view('patients.index', compact('patients'));
        // Mengirim data $patients ke view 'patients.index'
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('patients.create');  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Langkah 1: Validasi input dari form
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20|unique:patients,phone_number', // unik di tabel patients, kolom phone_number
        'email' => 'nullable|email|max:255|unique:patients,email', // boleh kosong, tapi jika diisi harus format email dan unik
        'date_of_birth' => 'nullable|date',
        'gender' => 'nullable|string|in:Laki-laki,Perempuan,Lainnya', // hanya menerima nilai ini
         'patient_type' => 'nullable|string|max:50',
        'address' => 'nullable|string',
        'registration_date' => 'required|date',
        'preferences_notes' => 'nullable|string',
        // 'total_loyalty_points' akan default 0 (sesuai definisi di migrasi/model) jadi tidak perlu divalidasi di sini saat create
    ]);

    // Langkah 2: Buat record pasien baru di database
    // Ini bisa dilakukan karena kita sudah mendefinisikan $fillable di Model Patient
    Patient::create($validatedData);

    // Langkah 3: Redirect ke halaman daftar pasien dengan pesan sukses
    return redirect()->route('patients.index')
                     ->with('success', 'Data pasien baru berhasil ditambahkan!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
          return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
         return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        // Langkah 1: Validasi input dari form
    // Perhatikan aturan 'unique' yang perlu mengabaikan ID pasien saat ini
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20|unique:patients,phone_number,' . $patient->id,
        'email' => 'nullable|email|max:255|unique:patients,email,' . $patient->id,
        'date_of_birth' => 'nullable|date',
        'gender' => 'nullable|string|in:Laki-laki,Perempuan,Lainnya',
        'patient_type' => 'nullable|string|max:50',
        'address' => 'nullable|string',
        'registration_date' => 'required|date',
        'preferences_notes' => 'nullable|string',
        // 'total_loyalty_points' biasanya tidak diupdate langsung dari form ini,
        // melainkan melalui transaksi poin, jadi tidak kita sertakan di sini.
    ]);

    // Langkah 2: Update record pasien di database
    $patient->update($validatedData);

    // Langkah 3: Redirect ke halaman daftar pasien dengan pesan sukses
    return redirect()->route('patients.index')
                     ->with('success', 'Data pasien berhasil diperbarui!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        // Hapus data pasien dari database
    $patient->delete();

    // Redirect ke halaman daftar pasien dengan pesan sukses
    return redirect()->route('patients.index')
                     ->with('success', 'Data pasien berhasil dihapus!');
    }
    public function loyaltyTransactions(Patient $patient) // <-- METHOD INI
    {
        $transactions = LoyaltyPointTransaction::where('patient_id', $patient->id)
                                                ->with(['appointment', 'promotion', 'staff']) // Eager load relasi
                                                ->latest('transaction_date') // Urutkan terbaru dulu
                                                ->latest('id') // Urutan sekunder jika tanggal sama
                                                ->paginate(15);

        return view('patients.loyalty_transactions', compact('patient', 'transactions'));
    }
}
