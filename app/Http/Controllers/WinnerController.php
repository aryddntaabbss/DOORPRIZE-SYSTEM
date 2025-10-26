<?php

namespace App\Http\Controllers;

use App\Events\DoorprizeDrawn;
use App\Models\Category;
use App\Models\Participant;
use App\Models\Winner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class WinnerController extends Controller
{
    /**
     * Tampilkan daftar pemenang dan kategori.
     */
    public function index()
    {
        $categories = Category::withCount('winners')->get();
        $activeCategory = Category::where('is_active', true)->first();
        $winners = Winner::with(['participant', 'category'])
            ->latest()
            ->paginate(20);

        return view('dashboard.winners', compact('categories', 'activeCategory', 'winners'));
    }

    // WinnerController.php
    public function setActive(Request $request)
    {
        Category::query()->update(['is_active' => false]);
        $category = Category::findOrFail($request->category_id);
        $category->is_active = true;
        $category->save();

        return back()->with('success', "Kategori {$category->name} sedang diundi!");
    }


    /**
     * Acak pemenang dari kategori aktif.
     */
    public function drawWinner()
    {
        try {
            // Ambil kategori aktif
            $category = Category::where('is_active', true)->first();

            if (!$category) {
                return back()->with('error', 'Tidak ada kategori aktif! Pilih kategori terlebih dahulu.');
            }

            // Hitung berapa pemenang yang sudah ada untuk kategori ini
            $existingWinnersCount = Winner::where('category_id', $category->id)->count();
            if ($existingWinnersCount >= $category->total_winners) {
                return back()->with('error', "Kategori {$category->name} sudah mencapai jumlah pemenang maksimal!");
            }

            $remainingWinners = $category->total_winners - $existingWinnersCount;

            // Ambil peserta yang belum pernah menang
            $eligible = Participant::where('is_winner', false)
                ->inRandomOrder()
                ->limit($remainingWinners)
                ->get();

            if ($eligible->isEmpty()) {
                return back()->with('error', "Tidak ada peserta untuk kategori {$category->name}!");
            }

            // Simpan hasil undian
            foreach ($eligible as $p) {
                Winner::create([
                    'participant_id' => $p->id,
                    'category_id'   => $category->id,
                ]);

                $p->update(['is_winner' => true]);
            }

            // Bisa digunakan untuk broadcast realtime
            event(new DoorprizeDrawn($eligible, $category));

            return back()->with('success', "Pemenang kategori {$category->name} berhasil diundi!");
        } catch (\Exception $e) {
            return back()->with('error', "Terjadi kesalahan: " . $e->getMessage());
        }
    }

    /**
     * Reset semua data undian.
     */
    public function resetAll()
    {
        Winner::truncate();
        Participant::query()->update(['is_winner' => false]);
        Category::query()->update(['is_active' => false]);

        return back()->with('success', 'Semua data undian berhasil direset!');
    }
}


