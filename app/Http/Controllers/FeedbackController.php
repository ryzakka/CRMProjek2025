<?php

namespace App\Http\Controllers;

use App\Models\Feedback; // Ini akan otomatis ditambahkan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


         // Mengambil data umpan balik, diurutkan berdasarkan tanggal terbaru feedback diterima,
        // dengan data pasien dan janji temu terkait (eager loading)
        // dan menggunakan pagination.
        $feedbacks = Feedback::with(['patient', 'appointment'])
                                ->latest('submitted_at') // Urutkan berdasarkan tanggal feedback terbaru
                                ->paginate(15);

        return view('feedbacks.index', compact('feedbacks'));
        // Mengirim data $feedbacks ke view 'feedbacks.index'
    }

    /**
     * Show the form for creating a new resource.
     * (Mungkin tidak kita gunakan langsung untuk feedback dari staf,
     * karena feedback biasanya datang dari pasien atau survei otomatis)
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * (Sama seperti create, mungkin lebih untuk staf input manual keluhan)
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback) // Type-hint Feedback $feedback
    {
        // Memastikan relasi yang mungkin ingin ditampilkan ter-load (opsional jika sudah didefinisikan baik di model)
    // $feedback->load(['patient', 'appointment', 'staffPenanggungJawab']);

    return view('feedbacks.show', compact('feedback'));
    // Mengirim data $feedback ke view 'feedbacks.show'
    }

    /**
     * Show the form for editing the specified resource.
     * (Ini akan kita gunakan untuk staf memperbarui status/catatan feedback)
     */
    public function edit(Feedback $feedback) // Type-hint Feedback $feedback
    {
        // $feedback->load(['patient', 'appointment']); // Opsional: load relasi jika diperlukan di form
    return view('feedbacks.edit', compact('feedback'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback) // Type-hint Feedback $feedback
    {
          $validatedData = $request->validate([
            'status_penanganan' => 'required|string|in:Baru,Diproses,Selesai,Tidak Perlu Tindakan',
            'catatan_tindak_lanjut' => 'nullable|string',
        ]);

        $feedback->status_penanganan = $validatedData['status_penanganan'];
        $feedback->catatan_tindak_lanjut = $validatedData['catatan_tindak_lanjut'];
        $feedback->staff_id_penanggung_jawab = Auth::id(); // Catat staf yang melakukan update
        $feedback->save();

        return redirect()->route('feedbacks.show', $feedback->id)
                         ->with('success', 'Status dan catatan umpan balik berhasil diperbarui!');

    }

    /**
     * Remove the specified resource from storage.
     * (Mungkin berguna untuk menghapus feedback spam atau yang salah)
     */
    public function destroy(Feedback $feedback) // Type-hint Feedback $feedback
    {
        // Anda bisa menambahkan logika otorisasi di sini jika hanya peran tertentu yang boleh menghapus

    $feedback->delete();

    return redirect()->route('feedbacks.index')
                     ->with('success', 'Umpan balik berhasil dihapus!');
    }
}