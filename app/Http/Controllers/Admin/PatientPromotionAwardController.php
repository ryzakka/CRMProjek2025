<?php

namespace App\Http\Controllers\Admin; // Pastikan namespace benar

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Promotion;
use App\Models\LoyaltyPointTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\PatientPromotionAwardController;

class PatientPromotionAwardController extends Controller
{
    /**
     * Show the form for awarding promotional points to a specific patient.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\View\View
     */
    public function create(Patient $patient)
    {
        // Ambil semua promosi yang aktif
        $promotions = Promotion::where('is_active', true)
                                ->orderBy('title')
                                ->get();

        return view('admin.patient_promotion_awards.create', compact('patient', 'promotions'));
    }

    /**
     * Store the awarded promotional points for a patient.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'promotion_id' => 'required|exists:promotions,id',
        ]);

        $promotion = Promotion::findOrFail($validated['promotion_id']);

        // Pastikan promosi masih aktif (dobel cek)
        if (!$promotion->is_active) {
            return redirect()->back()->with('error', 'Promosi ini sudah tidak aktif.');
        }
        // Bisa ditambahkan validasi lain seperti tanggal berlaku promosi jika ada start_date & end_date

        DB::beginTransaction();
        try {
            // Tambah poin ke pasien
            $patient->total_loyalty_points += $promotion->points_awarded;
            $patient->save();

            // Catat transaksi poin
            LoyaltyPointTransaction::create([
                'patient_id' => $patient->id,
                'promotion_id' => $promotion->id,
                'appointment_id' => null, // Tidak terkait janji temu spesifik
                'points' => $promotion->points_awarded, // Poin positif
                'description' => 'Poin dari promosi: ' . $promotion->title,
                'staff_id' => Auth::id(), // Staf yang memproses
                // transaction_date akan otomatis terisi
            ]);

            DB::commit();

            return redirect()->route('patients.show', $patient->id)
                             ->with('success', $promotion->points_awarded . ' poin dari promosi "' . $promotion->title . '" berhasil diberikan kepada ' . $patient->name . '.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error('Error awarding promo points: ' . $e->getMessage()); // Opsional: logging
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan saat memberikan poin promosi. Silakan coba lagi.');
        }
    }
}