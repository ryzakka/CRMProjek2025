<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Import model User
use Illuminate\Support\Facades\Hash; // Import Hash facade untuk password

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Opsional: Hapus data dokter lama agar tidak duplikat jika seeder dijalankan berkali-kali
        // User::where('role', 'dokter')->delete();

        $doctorsData = [
            [
                'name' => 'Dr. Budi Santoso', 'email' => 'budi.santoso@klinik.com', 'phone_number' => '081200000001',
                'gender' => 'Laki-laki', 'specialization' => 'Dokter Umum', 'room' => 'Poli Umum A - R.101',
                'availability_schedule' => "Senin: 08:00 - 12:00\nRabu: 08:00 - 12:00\nJumat: 13:00 - 17:00",
            ],
            [
                'name' => 'Dr. Anita Sari Dewi', 'email' => 'anita.sari@klinik.com', 'phone_number' => '081200000002',
                'gender' => 'Perempuan', 'specialization' => 'Dokter Gigi', 'room' => 'Poli Gigi - R.203',
                'availability_schedule' => "Selasa: 09:00 - 15:00\nKamis: 09:00 - 15:00\nSabtu: 10:00 - 14:00 (Minggu ke-1 & ke-3)",
            ],
            [
                'name' => 'Dr. Chandra Wijaya', 'email' => 'chandra.wijaya@klinik.com', 'phone_number' => '081200000003',
                'gender' => 'Laki-laki', 'specialization' => 'Spesialis Anak', 'room' => 'Poli Anak Ceria - R.105',
                'availability_schedule' => "Senin - Jumat: 10:00 - 16:00",
            ],
            [
                'name' => 'Dr. Siti Aminah', 'email' => 'siti.aminah@klinik.com', 'phone_number' => '081200000004',
                'gender' => 'Perempuan', 'specialization' => 'Dokter Umum', 'room' => 'Poli Umum B - R.102',
                'availability_schedule' => "Selasa: 14:00 - 18:00\nKamis: 14:00 - 18:00",
            ],
            [
                'name' => 'Dr. Rina Permata', 'email' => 'rina.permata@klinik.com', 'phone_number' => '081200000005',
                'gender' => 'Perempuan', 'specialization' => 'Spesialis Kulit & Kelamin', 'room' => 'Poli Kulit - R.301',
                'availability_schedule' => "Rabu: 10:00 - 14:00\nJumat: 10:00 - 14:00",
            ],
            [
                'name' => 'Dr. Agus Prasetyo', 'email' => 'agus.prasetyo@klinik.com', 'phone_number' => '081200000006',
                'gender' => 'Laki-laki', 'specialization' => 'Dokter Gigi', 'room' => 'Poli Gigi - R.204',
                'availability_schedule' => "Senin: 13:00 - 17:00\nRabu: 13:00 - 17:00",
            ],
            [
                'name' => 'Dr. Dian Lestari', 'email' => 'dian.lestari@klinik.com', 'phone_number' => '081200000007',
                'gender' => 'Perempuan', 'specialization' => 'Spesialis Anak', 'room' => 'Poli Anak Sehat - R.106',
                'availability_schedule' => "Selasa: 08:00 - 11:00\nKamis: 08:00 - 11:00",
            ],
            [
                'name' => 'Dr. Eko Saputra', 'email' => 'eko.saputra@klinik.com', 'phone_number' => '081200000008',
                'gender' => 'Laki-laki', 'specialization' => 'Dokter Umum', 'room' => 'Poli Umum C - R.103',
                'availability_schedule' => "Senin - Jumat: 16:00 - 20:00",
            ],
            [
                'name' => 'Dr. Fitri Handayani', 'email' => 'fitri.handayani@klinik.com', 'phone_number' => '081200000009',
                'gender' => 'Perempuan', 'specialization' => 'Spesialis THT', 'room' => 'Poli THT - R.305',
                'availability_schedule' => "Senin: 09:00 - 13:00\nKamis: 14:00 - 17:00",
            ],
            [
                'name' => 'Dr. Gilang Ramadhan', 'email' => 'gilang.ramadhan@klinik.com', 'phone_number' => '081200000010',
                'gender' => 'Laki-laki', 'specialization' => 'Spesialis Mata', 'room' => 'Poli Mata - R.302',
                'availability_schedule' => "Rabu: 14:00 - 18:00\nJumat: 09:00 - 12:00",
            ],
            [
                'name' => 'Dr. Indah Cahyani', 'email' => 'indah.cahyani@klinik.com', 'phone_number' => '081200000011',
                'gender' => 'Perempuan', 'specialization' => 'Dokter Gigi Anak', 'room' => 'Poli Gigi Anak - R.205',
                'availability_schedule' => "Senin: 10:00 - 15:00\nRabu: 10:00 - 15:00",
            ],
            [
                'name' => 'Dr. Joko Susilo', 'email' => 'joko.susilo@klinik.com', 'phone_number' => '081200000012',
                'gender' => 'Laki-laki', 'specialization' => 'Dokter Umum', 'room' => 'Poli Umum D - R.104',
                'availability_schedule' => "Selasa: 16:00 - 20:00\nJumat: 16:00 - 20:00",
            ],
            [
                'name' => 'Dr. Kartika Putri', 'email' => 'kartika.putri@klinik.com', 'phone_number' => '081200000013',
                'gender' => 'Perempuan', 'specialization' => 'Spesialis Penyakit Dalam', 'room' => 'Poli Internis - R.401',
                'availability_schedule' => "Senin: 14:00 - 17:00\nRabu: 14:00 - 17:00",
            ],
            [
                'name' => 'Dr. Leo Martin', 'email' => 'leo.martin@klinik.com', 'phone_number' => '081200000014',
                'gender' => 'Laki-laki', 'specialization' => 'Ahli Gizi', 'room' => 'Konsultasi Gizi - R.210',
                'availability_schedule' => "Selasa: 10:00 - 16:00\nKamis: 10:00 - 16:00",
            ],
            [
                'name' => 'Dr. Maya Anggraini', 'email' => 'maya.anggraini@klinik.com', 'phone_number' => '081200000015',
                'gender' => 'Perempuan', 'specialization' => 'Psikolog Klinis', 'room' => 'Konseling - R.501',
                'availability_schedule' => "Senin - Jumat: By Appointment Only",
            ]
        ];

        foreach ($doctorsData as $doctor) {
            User::create([
                'name' => $doctor['name'],
                'email' => $doctor['email'],
                'password' => Hash::make('password123'), // Gunakan password yang sama untuk semua data contoh, atau variasikan
                'email_verified_at' => now(),
                'role' => 'dokter',
                'phone_number' => $doctor['phone_number'],
                'is_active' => true,
                'gender' => $doctor['gender'],
                'specialization' => $doctor['specialization'],
                'room' => $doctor['room'],
                'availability_schedule' => $doctor['availability_schedule'],
            ]);
        }

        $this->command->info('Tabel Users berhasil diisi dengan data dokter contoh!');
    }
}