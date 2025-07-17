<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAngkatan;
use Illuminate\Http\Request;

class TahunAngkatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');
        $perPage = $request->input('perPage', 10);

        $tahunAngkatanQuery = TahunAngkatan::with('siswa')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('tahun_angkatan', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
                });
            });

            $sort = $request->sort;
            if ($sort == 'status_asc') {
                $tahunAngkatanQuery->orderBy('status', 'asc')->orderBy('created_at', 'desc');
            } elseif ($sort == 'status_desc') {
                $tahunAngkatanQuery->orderBy('status', 'desc')->orderBy('created_at', 'desc');
            } elseif ($sort == 'newest') {
                $tahunAngkatanQuery->orderBy('created_at', 'desc');
            } elseif ($sort == 'oldest') {
                $tahunAngkatanQuery->orderBy('created_at', 'asc');
            } else {
                // Default: urutkan status aktif dulu, lalu terbaru
                $tahunAngkatanQuery->orderBy('status', 'desc')->orderBy('created_at', 'desc');
            }

        $tahunAngkatan = $tahunAngkatanQuery->paginate($perPage)->appends($request->query());

        // $tahunAngkatan = TahunAngkatan::all();
        return view('admin.tahun_angkatan.index', compact('tahunAngkatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tahun_angkatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'tahun_angkatan' => 'required|digits:4|integer|min:2000|max:' . now()->year,
           'status' => 'nullable|boolean',
        ]);

        // Simpan ke DB
        TahunAngkatan::create($request->all());

        return redirect()->route('admin.tahun_angkatan.index')->with('success', 'Tahun angkatan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TahunAngkatan $tahunAngkatan)
    {
        return view('admin.tahun_angkatan.edit', compact('tahunAngkatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TahunAngkatan $tahunAngkatan)
    {
        $request->validate([
            'tahun_angkatan' => 'required|digits:4|integer|min:2000|max:' . now()->year,
            'status' => 'nullable|boolean',
        ]);

        $tahunAngkatan->update($request->all());

        return redirect()->route('admin.tahun_angkatan.index')->with('success', 'Tahun angkatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TahunAngkatan $tahun_angkatan)
    {
        $tahun_angkatan->delete();
        return redirect()->route('admin.tahun_angkatan.index')->with('success', 'Tahun angkatan berhasil dihapus.');
    }
}
