<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Controllers untuk Staf/Admin
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\PointRedemptionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\PromotionController as AdminPromotionController; // <-- TAMBAHKAN INI

// Controllers untuk Pasien
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Patient\DoctorController as PatientDoctorController;
use App\Http\Controllers\Patient\RewardController as PatientRewardController;
use App\Http\Controllers\Admin\PatientPromotionAwardController;
use App\Http\Controllers\Patient\LoyaltyController as PatientLoyaltyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Rute Dashboard dengan logika peran
    Route::get('/dashboard', function (Request $request) {
    $user = Auth::user();
    if ($user && $user->role === 'patient') {
        $user->load('patientProfile'); // Eager load profil pasien
        return view('patient.dashboard', compact('user')); // <-- PASTIKAN 'compact(\'user\')' ADA DI SINI
    } elseif ($user && in_array($user->role, ['admin', 'dokter', 'staff_front_office'])) {
        return view('dashboard'); // Untuk dashboard staf, kita belum mengirim $user secara eksplisit, tapi bisa jika perlu
    } else {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('error', 'Peran pengguna tidak valid atau sesi bermasalah. Silakan login kembali.');
    }
})->middleware('verified')->name('dashboard');

    // Rute Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // =====================================
    // === RUTE UNTUK STAF / ADMIN / DOKTER ===
    // =====================================
    Route::resource('patients', PatientController::class);
    Route::get('/patients/{patient}/loyalty-transactions', [PatientController::class, 'loyaltyTransactions'])->name('patients.loyalty_transactions');
    Route::resource('appointments', AppointmentController::class);        
    Route::resource('feedbacks', FeedbackController::class);
    Route::resource('rewards', RewardController::class); // Staf melihat daftar reward, bisa CRUD nanti
    Route::get('/patients/{patient}/redeem-points', [PointRedemptionController::class, 'create'])->name('points.redeem.create');
    Route::post('/patients/{patient}/redeem-points', [PointRedemptionController::class, 'store'])->name('points.redeem.store');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/patients/{patient}/loyalty-transactions', [PatientController::class, 'loyaltyTransactions'])->name('patients.loyalty_transactions');

    // Grup Rute untuk Admin
    Route::prefix('admin')->name('admin.')->group(function() {
        // Rute untuk Manajemen Program Promosi oleh Admin
        Route::resource('promotions', AdminPromotionController::class); // Akan menghasilkan admin.promotions.index, dll.
        Route::get('/patients/{patient}/award-promo-points/create', [PatientPromotionAwardController::class, 'create'])->name('patients.award_promo.create'); // <-- TAMBAHKAN INI
        Route::post('/patients/{patient}/award-promo-points', [PatientPromotionAwardController::class, 'store'])->name('patients.award_promo.store'); // <-- TAMBAHKAN INI

    });


    // ============================
    // === RUTE UNTUK PASIEN ===
    // ============================
    Route::prefix('patient')->name('patient.')->middleware('auth')->group(function () {
        Route::get('appointments/create', [PatientAppointmentController::class, 'create'])->name('appointments.create');
        Route::post('appointments', [PatientAppointmentController::class, 'store'])->name('appointments.store');
        Route::get('rewards', [PatientRewardController::class, 'index'])->name('rewards.index');
        Route::get('doctors', [PatientDoctorController::class, 'index'])->name('doctors.index');
        Route::get('my-appointments', [PatientAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('my-loyalty-history', [PatientLoyaltyController::class, 'transactionHistory'])->name('loyalty.history');
        Route::post('my-loyalty/redeem/{reward}', [PatientLoyaltyController::class, 'redeemReward'])->name('loyalty.redeem');
    });
});

require __DIR__.'/auth.php';