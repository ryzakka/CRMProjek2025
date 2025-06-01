<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoyaltyPointTransaction;
use App\Models\Patient;
use App\Models\Reward; // <-- Tambahkan ini
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini

class LoyaltyController extends Controller
{
    public function transactionHistory()
    {
        // ... (kode method transactionHistory yang sudah ada) ...
         $user = Auth::user();
         $patientProfile = $user->patientProfile()->first();

         if (!$patientProfile) {
             return redirect()->route('dashboard')->with('error', 'Profil pasien tidak ditemukan.');
         }

         $transactions = LoyaltyPointTransaction::where('patient_id', $patientProfile->id)
                                                 ->with(['appointment', 'promotion']) 
                                                 ->latest('transaction_date')
                                                 ->latest('id')
                                                 ->paginate(15);

         return view('patient.loyalty.transaction_history', compact('patientProfile', 'transactions'));
    }

    /**
     * Process reward redemption by the authenticated patient.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reward  $reward
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redeemReward(Request $request, Reward $reward) // <-- METHOD BARU
    {
        $user = Auth::user();
        $patientProfile = $user->patientProfile()->first();

        if (!$patientProfile) {
            return redirect()->route('patient.rewards.index')->with('error', 'Profil pasien tidak ditemukan.');
        }

        // 1. Cek apakah reward aktif
        if (!$reward->is_active) {
            return redirect()->route('patient.rewards.index')->with('error', 'Reward ini sudah tidak aktif.');
        }

        // 2. Cek apakah poin pasien mencukupi
        if ($patientProfile->total_loyalty_points < $reward->points_required) {
            return redirect()->route('patient.rewards.index')->with('error', 'Poin Anda tidak mencukupi untuk menukarkan reward ini.');
        }

        // 3. Cek ketersediaan reward jika ada batas kuantitas
        if (!is_null($reward->quantity_available) && $reward->quantity_available <= 0) {
            return redirect()->route('patient.rewards.index')->with('error', 'Stok reward ini sudah habis.');
        }

        DB::beginTransaction();
        try {
            // Kurangi poin pasien
            $patientProfile->total_loyalty_points -= $reward->points_required;
            $patientProfile->save();

            // Catat transaksi penukaran poin
            LoyaltyPointTransaction::create([
                'patient_id' => $patientProfile->id,
                'promotion_id' => null, // Bukan dari promosi spesifik, tapi dari penukaran reward
                'appointment_id' => null, 
                'points' => -$reward->points_required, // Poin negatif karena penukaran
                'description' => 'Penukaran poin dengan reward: ' . $reward->name,
                // staff_id bisa null karena ini dilakukan oleh pasien sendiri
            ]);

            // Kurangi kuantitas reward jika ada batasnya
            if (!is_null($reward->quantity_available)) {
                $reward->decrement('quantity_available');
            }

            DB::commit();

            return redirect()->route('patient.loyalty.history') // Arahkan ke riwayat poin
                             ->with('success', 'Selamat! Anda berhasil menukarkan ' . $reward->points_required . ' poin dengan: ' . $reward->name . '. Silakan hubungi staf klinik untuk pengambilan/penggunaan reward Anda.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error('Error patient redeeming reward: ' . $e->getMessage()); // Opsional
            return redirect()->route('patient.rewards.index')
                             ->with('error', 'Terjadi kesalahan saat memproses penukaran poin Anda. Silakan coba lagi.');
        }
    }
}