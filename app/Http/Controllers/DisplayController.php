<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Winner;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    // Halaman utama display
    public function index()
    {
        return view('display.index');
    }

    // Fetch data kategori yang sedang aktif dan pemenangnya
    public function fetchWinners()
    {
        try {
            // Ambil kategori yang sedang aktif
            $category = Category::where('is_active', true)->first();

            if (!$category) {
                return response()->json([
                    'active' => false,
                    'message' => 'Belum ada kategori yang aktif.',
                ]);
            }

            // Ambil semua pemenang untuk kategori ini dengan relasi participant
            $winners = Winner::with('participant')
                ->where('category_id', $category->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'active' => true,
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'total_winners' => $category->total_winners,
                    'current_winners_count' => $winners->count(),
                    'winners' => $winners->map(function ($w) {
                        return [
                            'id' => $w->id,
                            'bib_number' => $w->participant ? $w->participant->bib_number : 'N/A',
                            'created_at' => $w->created_at->format('H:i:s'),
                            'timestamp' => $w->created_at->timestamp,
                        ];
                    })->toArray(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'active' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'error' => true
            ]);
        }
    }
}
