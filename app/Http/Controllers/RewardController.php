<?php

namespace App\Http\Controllers; // Ini adalah RewardController untuk Staf

use App\Models\Reward;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth; // Jika Anda ingin mencatat siapa yang mengupdate

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rewards = Reward::where('is_active', true) 
                           ->orderBy('points_required', 'asc')
                           ->paginate(10);
        return view('rewards.index', compact('rewards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rewardTypes = [
            'DISCOUNT_PERCENTAGE' => 'Diskon Persentase (%)',
            'DISCOUNT_FIXED_AMOUNT' => 'Diskon Nominal Tetap (Rp)',
            'FREE_SERVICE' => 'Layanan Gratis',
            'MERCHANDISE' => 'Barang Merchandise',
        ];
        return view('rewards.create', compact('rewardTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rewardTypes = ['DISCOUNT_PERCENTAGE', 'DISCOUNT_FIXED_AMOUNT', 'FREE_SERVICE', 'MERCHANDISE'];
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:rewards,name', // Nama reward unik
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:1',
            'type' => 'required|string|in:'.implode(',', $rewardTypes),
            'value' => 'nullable|numeric|min:0',
            'quantity_available' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $dataToStore = $validatedData;
        $dataToStore['is_active'] = $request->has('is_active');
        if (!in_array($validatedData['type'], ['DISCOUNT_PERCENTAGE', 'DISCOUNT_FIXED_AMOUNT'])) {
            $dataToStore['value'] = null;
        }
        // $dataToStore['created_by_staff_id'] = Auth::id(); // Jika Anda punya kolom ini di tabel rewards

        Reward::create($dataToStore);

        return redirect()->route('rewards.index')
                         ->with('success', 'Reward baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reward $reward) // <-- METHOD BARU DIISI
    {
        // $reward->load('createdByStaff'); // Jika Anda punya relasi ini dan ingin menampilkannya
        return view('rewards.show', compact('reward'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reward $reward) // <-- METHOD BARU DIISI
    {
        $rewardTypes = [
            'DISCOUNT_PERCENTAGE' => 'Diskon Persentase (%)',
            'DISCOUNT_FIXED_AMOUNT' => 'Diskon Nominal Tetap (Rp)',
            'FREE_SERVICE' => 'Layanan Gratis',
            'MERCHANDISE' => 'Barang Merchandise',
        ];
        return view('rewards.edit', compact('reward', 'rewardTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reward $reward) // <-- METHOD BARU DIISI
    {
        $rewardTypes = ['DISCOUNT_PERCENTAGE', 'DISCOUNT_FIXED_AMOUNT', 'FREE_SERVICE', 'MERCHANDISE'];
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:rewards,name,' . $reward->id, // Abaikan ID reward saat ini
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:1',
            'type' => 'required|string|in:'.implode(',', $rewardTypes),
            'value' => 'nullable|numeric|min:0',
            'quantity_available' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $dataToUpdate = $validatedData;
        $dataToUpdate['is_active'] = $request->has('is_active');
        if (!in_array($validatedData['type'], ['DISCOUNT_PERCENTAGE', 'DISCOUNT_FIXED_AMOUNT'])) {
            $dataToUpdate['value'] = null;
        }

        $reward->update($dataToUpdate);

        return redirect()->route('rewards.show', $reward->id) // Redirect ke detail setelah update
                         ->with('success', 'Reward berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reward $reward) // <-- METHOD BARU DIISI
    {
        // Pertimbangkan apa yang terjadi jika reward ini pernah ditukarkan.
        // Untuk saat ini, kita langsung hapus.
        $reward->delete();

        return redirect()->route('rewards.index')
                         ->with('success', 'Reward berhasil dihapus!');
    }
}