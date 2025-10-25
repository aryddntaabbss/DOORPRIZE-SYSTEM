<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        // Paginate 25 data per halaman dengan append query string
        $participants = Participant::latest()->paginate(10)->withQueryString();
        return view('dashboard.participants', compact('participants'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'start' => 'required|integer|min:1',
            'end' => 'required|integer|gt:start'
        ]);

        for ($i = $request->start; $i <= $request->end; $i++) {
            $bib = str_pad($i, 4, '0', STR_PAD_LEFT);
            Participant::firstOrCreate(['bib_number' => $bib]);
        }

        return back()->with('success', 'Peserta berhasil digenerate!');
    }
}
