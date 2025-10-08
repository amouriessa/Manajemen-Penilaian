<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Surah;
use Illuminate\Http\Request;

class SurahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');
        $perPage = $request->input('perPage', 10);

        $surahQuery = Surah::query()
            ->when($search, function ($query) use ($search) {
                $normalizedSearch = str_replace(['-', "'", ' '], '', strtolower($search));

                $query->whereRaw("REPLACE(LOWER(REPLACE(REPLACE(nama, '-', ''), '''', '')), ' ', '') LIKE ?", ["%{$normalizedSearch}%"])
                    ->orWhere('total_ayat', 'like', "%{$search}%");
            });

        // Sorting logic
        if ($sort == 'name_asc') {
            $surahQuery->orderBy('nama', 'asc');
        } elseif ($sort == 'name_desc') {
            $surahQuery->orderBy('nama', 'desc');
        } elseif ($sort == 'newest') {
            $surahQuery->orderBy('created_at', 'desc');
        } elseif ($sort == 'oldest') {
            $surahQuery->orderBy('created_at', 'asc');
        }
        $surah = $surahQuery->paginate($perPage)->appends($request->query());

        // $surah = Surah::all();
        return view('admin.surah.index', compact('surah'));
    }

    public function create()
    {
        return view('admin.surah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:surahs,nama',
            'total_ayat' => 'required|integer|min:1',
        ]);

        Surah::create($request->only('nama', 'total_ayat'));

        return redirect()->route('admin.surah.index')->with('success', 'Surah berhasil ditambahkan.');
    }

    public function edit(Surah $surah)
    {
        return view('admin.surah.edit', compact('surah'));
    }

    public function update(Request $request, Surah $surah)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:surahs,nama,' . $surah->id,
            'total_ayat' => 'required|integer|min:1',
        ]);

        $surah->update($request->only('nama', 'total_ayat'));

        return redirect()->route('admin.surah.index')->with('success', 'Surah berhasil diperbarui.');
    }

    public function destroy(Surah $surah)
    {
        // Optional: detach all relation to tugas hafalan
        $surah->tugasHafalans()->detach();

        $surah->delete();

        return redirect()->route('admin.surah.index')->with('success', 'Surah berhasil dihapus.');
    }
}
