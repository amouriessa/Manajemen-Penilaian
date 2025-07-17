<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort');
        $perPage = $request->input('perPage', 10);

        $tahunAjaranQuery = TahunAjaran::query();

        $tahunAjaranQuery->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                // Untuk status, cari berdasarkan boolean (1/0) atau string 'true'/'false'
                // tergantung bagaimana Anda menangani input search.
                // Jika search adalah string seperti "aktif", Anda perlu konversi.
                // Untuk kasus boolean, search langsung ke 0 atau 1
                $q->where('tahun_ajaran', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%"); // Ini mungkin perlu diubah jika search string
            });
        });

        // Pengaturan Sorting
        if ($sort == 'status_asc') {
            // true (1) akan di atas false (0) jika asc, jadi ini akan menempatkan "aktif" paling bawah
            $tahunAjaranQuery->orderBy('status', 'asc')->orderBy('created_at', 'desc');
        } elseif ($sort == 'status_desc') {
            // false (0) akan di atas true (1) jika desc, jadi ini akan menempatkan "aktif" paling atas
            $tahunAjaranQuery->orderBy('status', 'desc')->orderBy('created_at', 'desc');
        } elseif ($sort == 'newest') {
            $tahunAjaranQuery->orderBy('created_at', 'desc');
        } elseif ($sort == 'oldest') {
            $tahunAjaranQuery->orderBy('created_at', 'asc');
        } else {
            // Default: 'aktif' (true) di atas, lalu urutkan berdasarkan created_at terbaru
            $tahunAjaranQuery->orderBy('status', 'desc')->orderBy('created_at', 'desc');
        }

        $tahunAjaran = $tahunAjaranQuery->paginate($perPage)->appends($request->query());

        return view('admin.tahun_ajaran.index', compact('tahunAjaran'));
    }

    public function create()
    {
        return view('admin.tahun_ajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_awal' => 'required|integer|min:2000|max:2100',
            'tahun_akhir' => 'required|integer|gt:tahun_awal|max:2100',
            'status' => 'required|boolean',
        ]);

        $tahunAjaranFormatted = $request->tahun_awal . '/' . $request->tahun_akhir;

        // Cek apakah sudah ada tahun ajaran dengan format itu
        if (TahunAjaran::where('tahun_ajaran', $tahunAjaranFormatted)->exists()) {
            return redirect()->back()->withInput()->withErrors([
                'tahun_ajaran' => 'Tahun ajaran ' . $tahunAjaranFormatted . ' sudah ada.'
            ]);
        }

        // Jika status aktif, nonaktifkan yang lainnya
        if ($request->status) {
            TahunAjaran::where('status', true)->update(['status' => false]);
        }

        TahunAjaran::create([
            'tahun_ajaran' => $tahunAjaranFormatted,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tahun_ajaran.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('admin.tahun_ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $request->validate([
            'tahun_awal' => 'required|integer|min:2000|max:2100',
            'tahun_akhir' => 'required|integer|gt:tahun_awal|max:2100',
            'status' => 'required|boolean',
        ]);

        $tahunAjaranFormatted = $request->tahun_awal . '/' . $request->tahun_akhir;

        // Cek jika nama tahun ajaran baru sama dengan milik entri lain
        if (
            TahunAjaran::where('tahun_ajaran', $tahunAjaranFormatted)
                ->where('id', '!=', $tahunAjaran->id)
                ->exists()
        ) {
            return redirect()->back()->withInput()->withErrors([
                'tahun_ajaran' => 'Tahun ajaran ' . $tahunAjaranFormatted . ' sudah digunakan oleh entri lain.'
            ]);
        }

        // Jika status aktif, nonaktifkan yang lainnya
        if ($request->status) {
            TahunAjaran::where('status', true)->where('id', '!=', $tahunAjaran->id)->update(['status' => false]);
        }

        $tahunAjaran->update([
            'tahun_ajaran' => $tahunAjaranFormatted,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tahun_ajaran.index')->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->delete();

        return redirect()->route('admin.tahun_ajaran.index')->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
