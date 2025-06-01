<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Reward;
use App\Models\LoyaltyPointTransaction; // <-- Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini untuk transaksi database

class PointRedemptionController extends Controller
{
    /**
     * Show the form for creating a new point redemption.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\View\View
     */
    public function create(Patient $patient)
    {
        $rewards = Reward::where('is_active', true)
                           ->where('points_required', '<=', $patient->total_loyalty_points)
                           ->orderBy('points_required', 'asc')
                           ->get();

        return view('points_redemption.create', compact('patient', 'rewards'));
    }

    /**
     * Store a newly created point redemption in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'reward_id' => 'required|exists:rewards,id',
        ]);

        $reward = Reward::findOrFail($validated['reward_id']);

        // 1. Cek apakah reward aktif
        if (!$reward->is_active) {
            return redirect()->back()->with('error', 'Reward ini sudah tidak aktif.');
        }

        // 2. Cek apakah poin pasien mencukupi
        if ($patient->total_loyalty_points < $reward->points_required) {
            return redirect()->back()->with('error', 'Poin pasien tidak mencukupi untuk reward ini.');
        }

        // 3. Cek ketersediaan reward jika ada batas kuantitas
        if (!is_null($reward->quantity_available) && $reward->quantity_available <= 0) {
            return redirect()->back()->with('error', 'Stok reward ini sudah habis.');
        }

        // Mulai Database Transaction (agar semua operasi berhasil atau semua gagal)
        // Ini adalah praktik yang baik untuk menjaga konsistensi data
        DB::beginTransaction();

        try {
            // Kurangi poin pasien
            $patient->total_loyalty_points -= $reward->points_required;
            $patient->save();

            // Catat transaksi penukaran poin
            LoyaltyPointTransaction::create([
                'patient_id' => $patient->id,
                'appointment_id' => null, // Tidak terkait langsung dengan appointment spesifik
                'points' => -$reward->points_required, // Poin negatif karena penukaran
                'description' => 'Penukaran poin dengan reward: ' . $reward->name,
                'staff_id' => Auth()->id(), // Staf yang memproses
            ]);

            // Kurangi kuantitas reward jika ada batasnya
            if (!is_null($reward->quantity_available)) {
                $reward->decrement('quantity_available');
                // atau $reward->quantity_available -= 1; $reward->save();
            }

            DB::commit(); // Semua operasi berhasil, simpan perubahan ke database

            return redirect()->route('patients.show', $patient->id)
                             ->with('success', 'Poin berhasil ditukarkan dengan: ' . $reward->name . '!');

        } catch (\Exception $e) {
            DB::rollBack(); // Terjadi kesalahan, batalkan semua perubahan
            // Anda bisa menambahkan logging error di sini: Log::error($e->getMessage());
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan saat memproses penukaran poin. Silakan coba lagi.');
        }
    }
}