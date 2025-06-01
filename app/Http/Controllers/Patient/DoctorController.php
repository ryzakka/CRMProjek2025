<?php

namespace App\Http\Controllers\Patient; // Namespace yang benar

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Model User untuk mengambil data dokter

class DoctorController extends Controller
{
    /**
     * Display a listing of doctors for patients, with filtering.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
   {
       $query = User::where('role', 'dokter')->where('is_active', true);

       if ($request->filled('specialization')) {
           $query->where('specialization', $request->specialization);
       }
       if ($request->filled('gender')) {
           $query->where('gender', $request->gender);
       }
       $doctors = $query->orderBy('name', 'asc')->paginate(9);
       $specializations = User::where('role', 'dokter')
                               ->where('is_active', true)
                               ->whereNotNull('specialization')
                               ->distinct()->orderBy('specialization')->pluck('specialization');
       $genders = User::where('role', 'dokter')
                        ->where('is_active', true)
                        ->whereNotNull('gender')
                        ->distinct()->orderBy('gender')->pluck('gender');

       return view('patient.doctors.index', compact('doctors', 'specializations', 'genders', 'request'));
   }
}