<?php

namespace App\Http\Controllers\Patient; // Perhatikan namespace

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reward;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    /**
     * Display a listing of available rewards for the patient.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $user->load('patientProfile'); // Pastikan profil pasien ter-load

        $patientPoints = $user->patientProfile ? $user->patientProfile->total_loyalty_points : 0;

        // Ambil semua reward yang aktif, diurutkan berdasarkan poin yang dibutuhkan
        $rewards = Reward::where('is_active', true)
                           ->orderBy('points_required', 'asc')
                           ->get(); // Kita ambil semua, nanti di view kita tandai mana yang bisa di-redeem

        return view('patient.rewards.index', compact('rewards', 'patientPoints'));
    }
}