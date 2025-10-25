<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('dashboard.categories', compact('categories'));
    }

    public function setActive($id)
    {
        // Set semua kategori jadi tidak aktif
        Category::query()->update(['is_active' => false]);

        // Set kategori yang dipilih jadi aktif
        $category = Category::findOrFail($id);
        $category->is_active = true;
        $category->save();

        return back()->with('success', "Kategori {$category->name} sedang diundi!");
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'total_winners' => 'required|integer|min:1',
        ]);

        Category::create([
            'name' => $request->name,
            'total_winners' => $request->total_winners
        ]);

        return back()->with('success', 'Kategori hadiah berhasil ditambahkan!');
    }
}
