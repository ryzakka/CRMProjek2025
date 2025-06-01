<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $promotions = Promotion::with('createdByStaff') // Eager load staf pembuat
                              ->latest() // Urutkan berdasarkan terbaru
                              ->paginate(10);
        return view('admin.promotions.index', compact('promotions'));
  
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tidak ada data khusus yang perlu dikirim ke view untuk form create ini
    // kecuali jika Anda ingin dropdown untuk created_by_staff_id,
    // tapi kita akan set itu otomatis ke user yang login.
    return view('admin.promotions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_awarded' => 'required|integer|min:1',
            'promo_code' => 'nullable|string|max:50|unique:promotions,promo_code', // Unik di tabel promotions
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            // 'is_active' tidak perlu divalidasi di sini karena checkbox, kita handle di bawah
        ]);

        // Menyiapkan data untuk disimpan
        $dataToStore = $validatedData;
        $dataToStore['is_active'] = $request->has('is_active'); // Checkbox value: true if checked, false otherwise
        $dataToStore['created_by_staff_id'] = Auth::id(); // ID staf yang login saat ini

        Promotion::create($dataToStore);

        return redirect()->route('admin.promotions.index')
                         ->with('success', 'Program promosi baru berhasil ditambahkan!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
         // Eager load relasi createdByStaff untuk menampilkan nama staf pembuat
    $promotion->load('createdByStaff'); 

    return view('admin.promotions.show', compact('promotion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
         return view('admin.promotions.edit', compact('promotion'));
    // Mengirim data $promotion yang akan diedit ke view 'admin.promotions.edit'

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_awarded' => 'required|integer|min:1',
            'promo_code' => 'nullable|string|max:50|unique:promotions,promo_code,' . $promotion->id, // Abaikan ID promosi saat ini untuk validasi unik
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $dataToUpdate = $validatedData;
        $dataToUpdate['is_active'] = $request->has('is_active');
        // created_by_staff_id biasanya tidak diubah saat update, kecuali ada logika khusus

        $promotion->update($dataToUpdate);

        return redirect()->route('admin.promotions.show', $promotion->id)
                         ->with('success', 'Program promosi berhasil diperbarui!');
 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
         // Logika otorisasi bisa ditambahkan di sini jika perlu

    // Sebelum menghapus, Anda mungkin ingin mempertimbangkan apa yang terjadi
    // pada loyalty_point_transactions yang mungkin terkait dengan promo_code dari promosi ini.
    // Untuk saat ini, kita hanya menghapus data promosinya saja.
    $promotion->delete();

    return redirect()->route('admin.promotions.index')
                     ->with('success', 'Program promosi berhasil dihapus!');

    }
}
