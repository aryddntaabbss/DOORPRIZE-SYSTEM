<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    /**
     * Display a listing of participants.
     */
    public function index(Request $request): View
    {
        $perPage = $request->input('per_page', 10);
        $participants = Participant::query()
            ->when($request->search, function ($query, $search) {
                return $query->where('bib_number', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $categories = Category::all();
        return view('dashboard.participants', compact('participants', 'categories'));
    }

    /**
     * Show the form for editing a participant.
     */
    public function edit(int $id): View
    {
        $participant = Participant::findOrFail($id);
        $categories = Category::all();
        return view('dashboard.participants_edit', compact('participant', 'categories'));
    }

    /**
     * Update a participant.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $participant = Participant::findOrFail($id);

        $request->validate([
            'bib_number' => "required|string|unique:participants,bib_number,{$participant->id}",
            'name' => 'nullable|string|max:255',
            'priority' => 'nullable|boolean',
            'priority_category_id' => 'nullable|exists:categories,id',
        ]);

        $participant->update([
            'bib_number' => $request->bib_number,
            'name' => $request->name,
            'priority' => (bool) $request->input('priority', false),
            'priority_category_id' => $request->input('priority_category_id'),
        ]);

        return redirect()->route('participants.index')->with('success', 'Peserta berhasil diperbarui.');
    }

    /**
     * Remove a participant.
     */
    public function destroy(int $id): RedirectResponse
    {
        $participant = Participant::findOrFail($id);
        $participant->delete();
        return back()->with('success', 'Peserta berhasil dihapus.');
    }

    /**
     * Prioritize/un-prioritize a participant for a category.
     */
    public function prioritize(Request $request): RedirectResponse
    {
        $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $participant = Participant::findOrFail($request->participant_id);
        if ($request->filled('category_id')) {
            $participant->update([
                'priority' => true,
                'priority_category_id' => $request->category_id,
            ]);
            return back()->with('success', 'Peserta diprioritaskan untuk kategori.');
        }

        // Un-prioritize
        $participant->update([
            'priority' => false,
            'priority_category_id' => null,
        ]);
        return back()->with('success', 'Prioritas peserta dihapus.');
    }

    /**
     * Generate new participant BIB numbers.
     */
    public function generate(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'start' => 'required|integer|min:1',
                'end' => 'required|integer|gt:start'
            ]);

            $start = (int) $request->start;
            $end = (int) $request->end;

            // Protect against accidentally huge ranges that can time out or OOM
            $maxRange = 20000; // configurable limit
            $count = $end - $start + 1;
            if ($count > $maxRange) {
                return back()->with('error', "Rentang terlalu besar (maks {$maxRange} nomor). Coba bagi menjadi beberapa batch.");
            }

            // Determine padding length from the end value but minimum 4
            $padLength = max(4, strlen((string) $end));

            // Check for existing BIB numbers in the range first
            $existingCount = Participant::whereBetween('bib_number', [
                str_pad($start, $padLength, '0', STR_PAD_LEFT),
                str_pad($end, $padLength, '0', STR_PAD_LEFT)
            ])->count();

            if ($existingCount === $count) {
                return back()->with('error', 'Semua nomor dalam rentang ini sudah ada.');
            }

            $toInsert = [];
            $now = now();

            for ($i = $start; $i <= $end; $i++) {
                $bib = str_pad($i, $padLength, '0', STR_PAD_LEFT);
                $toInsert[] = [
                    'bib_number' => $bib,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // Filter out existing BIBs
            $existing = Participant::whereIn('bib_number', array_column($toInsert, 'bib_number'))
                ->pluck('bib_number')
                ->all();

            $filtered = array_filter($toInsert, function ($row) use ($existing) {
                return !in_array($row['bib_number'], $existing, true);
            });

            if (empty($filtered)) {
                return back()->with('error', 'Tidak ada nomor baru yang dapat dibuat — semua nomor sudah ada.');
            }

            // Insert in chunks within a transaction
            $created = DB::transaction(function () use ($filtered) {
                $totalCreated = 0;
                foreach (array_chunk($filtered, 1000) as $chunk) {
                    DB::table('participants')->insert($chunk);
                    $totalCreated += count($chunk);
                }
                return $totalCreated;
            });

            return back()->with('success', "Berhasil membuat {$created} peserta baru.");
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            report($e); // Log the error
            return back()->with('error', 'Terjadi kesalahan saat membuat peserta. Silakan coba lagi.');
        }
    }
}
