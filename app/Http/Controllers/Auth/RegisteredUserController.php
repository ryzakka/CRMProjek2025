<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Patient;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
         $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
             'phone_number' => ['required', 'string', 'max:20'], 
            // Tambahkan validasi untuk field pasien jika diperlukan di form registrasi,
            // misalnya phone_number jika Anda ingin pasien mengisinya saat registrasi.
            // 'phone_number' => ['required', 'string', 'max:20'], 
        ]);

        // Buat User baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient', // <--- SET PERAN MENJADI 'patient'
            // 'phone_number' => $request->phone_number, // Jika Anda menambahkannya di form & validasi User
        ]);

        // Buat Profil Pasien baru yang terhubung dengan User
        // Asumsi 'phone_number' dan 'registration_date' akan diisi dari data registrasi atau default
        // Anda mungkin perlu menambahkan input phone_number di form registrasi jika itu wajib untuk pasien
        Patient::create([
    'user_id' => $user->id,
    'name' => $user->name,
    'email' => $user->email,
    'phone_number' => $request->phone_number, // <-- AMBIL DARI REQUEST
    'registration_date' => now(),
    'total_loyalty_points' => 0,
]);

        event(new Registered($user));

        Auth::login($user);

        // Setelah login, pasien akan diarahkan ke dashboard mereka
        // Kita akan buat rute '/patient/dashboard' nanti
        return redirect(route('dashboard')); // Untuk sementara, arahkan ke dashboard umum dulu
                                            // Nanti kita ubah ini untuk redirect berdasarkan peran
    }
}
