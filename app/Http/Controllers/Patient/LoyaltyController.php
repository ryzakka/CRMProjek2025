<?php

namespace App\Http\Controllers\Patient; // Pastikan namespace benar

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoyaltyPointTransaction;
use App\Models\Patient; // Kita mungkin butuh ini untuk info pasien di view
use Illuminate\Support\Facades\Auth;

class LoyaltyController extends Controller
{
    /**
     * Display the loyalty point transaction history for the authenticated patient.
     *
     * @return \Illuminate\View\View
     */
    public function transactionHistory()
    {
        $user = Auth::user();
        $patientProfile = $user->patientProfile()->first(); // Ambil profil pasien terkait

        if (!$patientProfile) {
            // Seharusnya tidak terjadi jika registrasi benar
            return redirect()->route('dashboard')->with('error', 'Profil pasien tidak ditemukan.');
        }

        $transactions = LoyaltyPointTransaction::where('patient_id', $patientProfile->id)
                                                ->with(['appointment', 'promotion']) // Eager load relasi
                                                ->latest('transaction_date')
                                                ->latest('id') // Urutan sekunder
                                                ->paginate(15);

        return view('patient.loyalty.transaction_history', compact('patientProfile', 'transactions'));
    }
}