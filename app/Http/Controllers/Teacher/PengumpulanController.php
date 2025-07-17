<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Pengumpulan;
use App\Models\Penilaian;
use App\Models\TugasHafalan; // Pastikan ini tetap ada jika diperlukan oleh method lain
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;// Penting untuk logging error

class PengumpulanController extends Controller
{
    /**
     * Menampilkan daftar pengumpulan hafalan yang relevan untuk guru yang sedang login.
     */
    // public function index(Request $request)
    // {
    //     $teacherId = Auth::user()->guru->id;

    //     $query = Pengumpulan::with(['surahHafalan.surah', 'siswa.user', 'penilaian'])
    //         ->whereHas('tugasHafalan', function ($q) use ($teacherId) {
    //             $q->where('teacher_id', $teacherId);
    //         });

    //     // 🔍 Pencarian berdasarkan nama surah
    //     if ($request->filled('search')) {
    //         $search = $request->search;

    //         $query->where(function ($q) use ($search) {
    //             $q->whereHas('surahHafalan.surah', function ($subQuery) use ($search) {
    //                 $subQuery->where('nama', 'like', '%' . $search . '%');
    //             })->orWhereHas('siswa.user', function ($subQuery) use ($search) {
    //                 $subQuery->where('name', 'like', '%' . $search . '%');
    //             });
    //         });
    //     }

    //     // 🔽 Sorting dan Filtering
    //     if ($request->filled('filter')) {
    //         if ($request->filter === 'sort:newest') {
    //             $query->orderBy('submitted_at', 'desc');
    //         } elseif ($request->filter === 'sort:oldest') {
    //             $query->orderBy('submitted_at', 'asc');
    //         } elseif (Str::startsWith($request->filter, 'status:')) {
    //             $status = Str::after($request->filter, 'status:');
    //             $query->where('status', $status);
    //         }
    //     } else {
    //         // Default sort jika tidak ada filter
    //         $query->orderBy('submitted_at', 'desc');
    //     }

    //     $perPage = $request->get('perPage', 10);

    //     $pengumpulans = $query->orderByDesc('submitted_at')->paginate($perPage)->withQueryString();

    //     $totalBelumDinilai = Pengumpulan::whereHas('tugasHafalan', function ($q) use ($teacherId) {
    //         $q->where('teacher_id', $teacherId);
    //     })->whereDoesntHave('penilaian')->count();

    //     return view('teacher.pengumpulan.index', compact('pengumpulans'));
    // }

    public function index(Request $request)
    {
        $teacherId = Auth::user()->guru->id;

        $query = Pengumpulan::with(['surahHafalan.surah', 'siswa.user', 'penilaian'])
            ->whereHas('tugasHafalan', function ($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            });

        // 🔍 Pencarian berdasarkan nama surah atau nama siswa
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('surahHafalan.surah', function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', '%' . $search . '%');
                })->orWhereHas('siswa.user', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        // 🔽 Sorting dan Filtering
        if ($request->filled('filter')) {
            if ($request->filter === 'sort:newest') {
                $query->orderBy('submitted_at', 'desc');
            } elseif ($request->filter === 'sort:oldest') {
                $query->orderBy('submitted_at', 'asc');
            } elseif (Str::startsWith($request->filter, 'status:')) {
                $status = Str::after($request->filter, 'status:');
                $query->where('status', $status)->orderBy('submitted_at', 'desc');
            } else {
                $query->orderBy('submitted_at', 'desc');
            }
        } else {
            $query->orderBy('submitted_at', 'desc');
        }

        $perPage = $request->get('perPage', 10);

        $pengumpulans = $query->paginate($perPage)->withQueryString();

        // Hitung total belum dinilai
        $totalBelumDinilai = Pengumpulan::whereHas('tugasHafalan', function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->whereDoesntHave('penilaian')->count();

        return view('teacher.pengumpulan.index', compact('pengumpulans', 'totalBelumDinilai'));
    }

    /**
     * Menampilkan form untuk membuat penilaian baru terhadap sebuah pengumpulan.
     * Menggunakan Route Model Binding untuk mendapatkan objek Pengumpulan.
     */
    public function create(Pengumpulan $pengumpulan)
    {
        // Mengecek apakah pengumpulan ini sudah memiliki penilaian.
        // Jika sudah, redirect ke halaman detail dengan pesan informasi.
        if ($pengumpulan->penilaian()->exists()) {
            return redirect()->route('teacher.pengumpulan.show', $pengumpulan)
                             ->with('info', 'Pengumpulan ini sudah memiliki penilaian. Anda bisa melihat atau mengeditnya.');
        }

        // Memuat relasi yang diperlukan (surahHafalan.surah, tugasHafalan, siswa.user)
        // untuk memastikan data tersedia di view form.
        $pengumpulan->loadMissing('surahHafalan.surah', 'tugasHafalan', 'siswa.user');

        // Memastikan guru yang sedang login berhak menilai pengumpulan ini.
        // Ini adalah lapisan keamanan penting.
        if (Auth::user()->guru->id !== $pengumpulan->tugasHafalan->teacher_id) {
            abort(403, 'Akses tidak diizinkan. Pengumpulan ini bukan dari tugas hafalan yang Anda ampu.');
        }

        // Menampilkan view form pembuatan penilaian.
        return view('teacher.penilaian.pengumpulan.create', compact('pengumpulan'));
    }

    /**
     * Menyimpan penilaian baru ke dalam database.
     * Menggunakan transaksi database untuk memastikan data konsisten.
     */
    public function storePenilaian(Request $request, Pengumpulan $pengumpulan)
    {
        DB::beginTransaction(); // Memulai transaksi database

        try {
            // **1. Mendapatkan ID Guru yang Sedang Login Secara Otomatis**
            // Mengakses relasi 'guru' dari user yang terautentikasi.
            $guru = Auth::user()->guru;

            // Jika objek guru tidak ditemukan, artinya ada masalah pada data user/guru.
            if (!$guru) {
                // Log error detail untuk debugging.
                Log::error("Authenticated user " . Auth::id() . " does not have a 'guru' relationship during penilaian store attempt.");
                throw new \Exception('Data guru tidak ditemukan untuk akun ini. Pastikan Anda login sebagai guru yang valid.');
            }
            $teacherId = $guru->id; // ID guru yang sedang login

            // **2. Validasi Data Input dari Form Penilaian**
            $request->validate([
                'nilai_tajwid'  => 'required|numeric|min:0|max:100',
                'nilai_harakat' => 'required|numeric|min:0|max:100',
                'nilai_makhraj' => 'required|numeric|min:0|max:100',
                'catatan'       => 'nullable|string|max:500', // Menambahkan batasan panjang untuk catatan
            ]);

            // **3. Mencegah Penilaian Ganda untuk Pengumpulan yang Sama**
            // Jika pengumpulan ini sudah memiliki penilaian, lempar error untuk mencegah duplikasi.
            if ($pengumpulan->penilaian()->exists()) {
                throw new \Exception('Pengumpulan ini sudah memiliki penilaian. Anda tidak dapat membuat penilaian baru.');
            }

            // **4. Memastikan Guru yang Menilai Adalah Pemilik Tugas Hafalan (Lapisan Keamanan)**
            // Memastikan guru yang mencoba menilai adalah guru yang memiliki tugas hafalan terkait pengumpulan.
            if ($guru->id !== $pengumpulan->tugasHafalan->teacher_id) {
                throw new \Exception('Akses tidak diizinkan. Anda bukan guru yang memiliki tugas hafalan ini.');
            }

            // **5. Menghitung Nilai Total dan Menentukan Predikat**
            $nilaiTotal = round(($request->nilai_tajwid + $request->nilai_harakat + $request->nilai_makhraj) / 3);

            // Logika penentuan predikat berdasarkan nilai total.
            $predikat = match (true) {
                $nilaiTotal >= 90 => 'mumtaz',
                $nilaiTotal >= 80 => 'jayyid_jiddan',
                default => 'jiddan', // Nilai 70-79: jayyid      // Nilai di bawah 70: maqbul
            };

            // **6. Membuat Record Penilaian Baru di Database**
            Penilaian::create([
                'pengumpulan_id'    => $pengumpulan->id,
                'student_id'        => $pengumpulan->siswa->id, // Mengambil ID siswa dari relasi Pengumpulan
                'tugas_hafalan_id'  => $pengumpulan->tugas_hafalan_id,
                'teacher_id'        => $teacherId, // **teacher_id diisi otomatis dari guru yang login**
                'jenis_penilaian'   => 'pengumpulan', // Nilai statis sesuai konteks
                'jenis_hafalan'     => $pengumpulan->tugasHafalan->jenis_tugas, // Mengambil jenis hafalan dari relasi TugasHafalan
                'nilai_tajwid'      => $request->nilai_tajwid,
                'nilai_harakat'     => $request->nilai_harakat,
                'nilai_makhraj'     => $request->nilai_makhraj,
                'nilai_total'       => $nilaiTotal,
                'predikat'          => $predikat,
                'catatan'           => $request->catatan,
                'assessed_at'       => now(), // Otomatis mengisi waktu penilaian saat ini
            ]);

            // **7. Memperbarui Status Pengumpulan Menjadi 'dinilai'**
            $pengumpulan->update(['status' => 'dinilai']);

            DB::commit(); // Mengkonfirmasi semua operasi database jika tidak ada error

            // Redirect dengan pesan sukses
            return redirect()->route('teacher.pengumpulan.index')->with('success', 'Penilaian berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack(); // Membatalkan transaksi jika terjadi error
            // Log error untuk debugging lebih lanjut di file storage/logs/laravel.log
            Log::error("Error storing penilaian for pengumpulan ID {$pengumpulan->id}: " . $e->getMessage());

            // Redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan penilaian: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail spesifik dari sebuah pengumpulan, termasuk penilaiannya jika ada.
     */
    public function show(Pengumpulan $pengumpulan)
    {
        // Memuat relasi yang diperlukan: tugasHafalan, siswa.user, dan penilaian.
        $pengumpulan->load(['tugasHafalan', 'siswa.user', 'penilaian']);

        // Memastikan guru yang sedang login berhak melihat pengumpulan ini.
        if (Auth::user()->guru->id !== $pengumpulan->tugasHafalan->teacher_id) {
            abort(403, 'Akses tidak diizinkan. Pengumpulan ini bukan dari tugas hafalan yang Anda ampu.');
        }

        return view('teacher.pengumpulan.show', compact('pengumpulan'));
    }

    /**
     * Menampilkan form untuk mengedit penilaian yang sudah ada.
     */
    public function edit(Pengumpulan $pengumpulan)
    {
        // Mendapatkan objek penilaian terkait pengumpulan ini.
        $penilaian = $pengumpulan->penilaian;

        // Jika penilaian belum ada, redirect kembali dengan pesan error.
        if (!$penilaian) {
            return redirect()->back()->with('error', 'Penilaian belum tersedia untuk pengumpulan ini. Silakan buat penilaian baru.');
        }

        // Memastikan guru yang sedang login berhak mengedit penilaian ini.
        if (Auth::user()->guru->id !== $penilaian->teacher_id) {
            abort(403, 'Akses tidak diizinkan. Anda tidak memiliki izin untuk mengedit penilaian ini.');
        }

        // Mengirimkan objek pengumpulan dan penilaian ke view form edit.
        return view('teacher.penilaian.pengumpulan.edit', [
            'pengumpulan' => $pengumpulan,
            'penilaian' => $penilaian,
        ]);
    }

    /**
     * Memperbarui penilaian yang sudah ada di database.
     * Menggunakan transaksi database untuk memastikan data konsisten.
     */
    public function updatePenilaian(Request $request, Pengumpulan $pengumpulan)
    {
        DB::beginTransaction(); // Memulai transaksi database

        try {
            // Mendapatkan ID guru yang sedang login.
            $guru = Auth::user()->guru;
            if (!$guru) {
                Log::error("Authenticated user " . Auth::id() . " does not have a 'guru' relationship during penilaian update attempt.");
                throw new \Exception('Data guru tidak ditemukan untuk akun ini. Pastikan Anda login sebagai guru yang valid.');
            }

            // Validasi data input dari form.
            $request->validate([
                'nilai_tajwid'  => 'required|numeric|min:0|max:100',
                'nilai_harakat' => 'required|numeric|min:0|max:100',
                'nilai_makhraj' => 'required|numeric|min:0|max:100',
                'catatan'       => 'nullable|string|max:500', // Menambahkan batasan panjang untuk catatan
            ]);

            // Mendapatkan objek penilaian yang akan diperbarui.
            $penilaian = $pengumpulan->penilaian;

            // Jika penilaian tidak ditemukan, lempar error.
            if (!$penilaian) {
                throw new \Exception('Penilaian untuk pengumpulan ini tidak ditemukan. Tidak dapat diperbarui.');
            }

            // Memastikan guru yang sedang login adalah guru yang membuat penilaian ini.
            // Ini adalah lapisan keamanan penting untuk mencegah guru lain mengedit penilaian.
            if ($guru->id !== $penilaian->teacher_id) {
                throw new \Exception('Akses tidak diizinkan. Anda tidak memiliki izin untuk mengedit penilaian ini.');
            }

            // Menghitung ulang nilai total dan menentukan predikat.
            $nilaiTotal = round(($request->nilai_tajwid + $request->nilai_harakat + $request->nilai_makhraj) / 3);

            $predikat = match (true) {
                $nilaiTotal >= 90 => 'mumtaz',
                $nilaiTotal >= 80 => 'jayyid_jiddan',
                default => 'jiddan', // Nilai 70-79: jayyid      // Nilai di bawah 70: maqbul
            };

            // Memperbarui data penilaian di database.
            $penilaian->update([
                'nilai_tajwid'  => $request->nilai_tajwid,
                'nilai_harakat' => $request->nilai_harakat,
                'nilai_makhraj' => $request->nilai_makhraj,
                'nilai_total'   => $nilaiTotal,
                'predikat'      => $predikat,
                'catatan'       => $request->catatan,
                'assessed_at'   => now(), // Memperbarui timestamp penilaian terakhir
            ]);

            DB::commit(); // Mengkonfirmasi semua operasi database

            // Redirect dengan pesan sukses.
            return redirect()->route('teacher.pengumpulan.index')->with('success', 'Penilaian berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack(); // Membatalkan transaksi jika terjadi error
            Log::error("Error updating penilaian for pengumpulan ID {$pengumpulan->id}: " . $e->getMessage());
            // Redirect kembali dengan pesan error.
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui penilaian: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus sebuah pengumpulan dan penilaian terkaitnya.
     */
    public function destroy(Pengumpulan $pengumpulan)
    {
        DB::beginTransaction(); // Memulai transaksi database untuk operasi hapus.

        try {
            // Memuat relasi tugasHafalan jika belum terload.
            $pengumpulan->loadMissing('tugasHafalan');

            // Memastikan guru yang menghapus adalah pemilik tugas hafalan ini.
            if (Auth::user()->guru->id !== $pengumpulan->tugasHafalan->teacher_id) {
                throw new \Exception('Akses tidak diizinkan. Anda bukan guru yang memiliki tugas hafalan ini.');
            }

            // Menghapus penilaian terkait jika ada.
            if ($pengumpulan->penilaian) {
                $pengumpulan->penilaian->delete();
            }

            // Menghapus pengumpulan itu sendiri.
            $pengumpulan->delete();

            DB::commit(); // Mengkonfirmasi transaksi jika semua berhasil.

            // Redirect dengan pesan sukses.
            return redirect()->route('teacher.pengumpulan.index')->with('success', 'Pengumpulan berhasil dihapus.');

        } catch (\Exception | \Throwable $e) { // Menangkap Exception atau Throwable untuk error lebih luas
            DB::rollBack(); // Membatalkan transaksi jika terjadi error.
            Log::error("Error deleting pengumpulan ID {$pengumpulan->id}: " . $e->getMessage());
            // Redirect kembali dengan pesan error.
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus pengumpulan. Silakan coba lagi: ' . $e->getMessage());
        }
    }

    /**
     * Mengunduh file pengumpulan yang diunggah oleh siswa.
     */
    public function downloadFile(Pengumpulan $pengumpulan)
    {
        // Mendapatkan path lengkap ke file. Sesuaikan 'storage/app/public/' jika lokasi berbeda.
        $filePath = storage_path('app/public/' . $pengumpulan->file_pengumpulan);

        // Memeriksa apakah file ada.
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Mengembalikan respons unduhan file.
        return response()->download($filePath);
    }
}
