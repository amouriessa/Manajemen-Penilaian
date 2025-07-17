<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\KelasTahfidz;
use App\Models\SiswaKelas;
use App\Models\Student;
use App\Models\Surah;
use App\Models\TahunAjaran;
use App\Models\Teacher;
use App\Models\TugasHafalan;
use App\Models\TugasSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class TugasHafalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $teacherId = Auth::user()->guru->id;

        // Auto-archive overdue tasks
        TugasHafalan::where('teacher_id', $teacherId)
            ->where('is_archived', false)
            ->whereDate('tenggat_waktu', '<', Carbon::today())
            ->update(['is_archived' => true]);

        $allowedSortColumns = ['nama', 'tenggat_waktu', 'created_at'];
        $sortBy = $request->input('sort_by', 'tenggat_waktu');
        $sortOrder = $request->input('sort_order', 'desc');

        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'tenggat_waktu';
        }
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        // Base query with eager loading for siswa (relasi di TugasHafalan) and surahHafalan
        $baseQuery = TugasHafalan::where('teacher_id', $teacherId)
        ->with([
            'surahHafalan', // Memuat relasi many-to-many ke Surah
            'siswa' => function($query) {
                // Memuat relasi many-to-many ke Student
                // Dan eager load relasi 'user' dari Student, serta 'kelasTahfidz'
                $query->with(['user', 'kelasTahfidz']);
            }
        ]);

        // --- Pencarian ---
        if ($request->filled('search')) {
            $search = $request->input('search');
            $baseQuery->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhereHas('surahHafalan', function ($qr) use ($search) {
                      $qr->where('nama', 'like', '%' . $search . '%');
                  })
                  // Cari berdasarkan nama siswa (Student) yang dituju
                  ->orWhereHas('siswa.user', function ($qr) use ($search) { // <-- PERBAIKAN DI SINI
                    $qr->where('name', 'like', '%' . $search . '%'); // <-- PERBAIKAN DI SINI, kolom 'name' di tabel 'users'
                });
            });
        }

        // --- Filter Status (No change needed here) ---
        $activeTasksQuery = null;
        $archivedTasksQuery = null;

        if ($request->filled('status')) {
            if ($request->input('status') === 'active') {
                $activeTasksQuery = (clone $baseQuery)->active();
            } elseif ($request->input('status') === 'archived') {
                $archivedTasksQuery = (clone $baseQuery)->archived();
            } else {
                $activeTasksQuery = (clone $baseQuery)->active();
                $archivedTasksQuery = (clone $baseQuery)->archived();
            }
        } else {
            $activeTasksQuery = (clone $baseQuery)->active();
            $archivedTasksQuery = (clone $baseQuery)->archived();
        }

        // --- Filter Siswa tertentu ---
        if ($request->filled('siswa_id')) {
            $siswaIdToFilter = $request->input('siswa_id');
            if ($activeTasksQuery) {
                $activeTasksQuery->whereHas('siswa', function($q) use ($siswaIdToFilter) { // <-- Changed to 'siswa' (singular)
                    $q->where('students.id', $siswaIdToFilter); // Nama tabel tetap 'students'
                });
            }
            if ($archivedTasksQuery) {
                $archivedTasksQuery->whereHas('siswa', function($q) use ($siswaIdToFilter) { // <-- Changed to 'siswa' (singular)
                    $q->where('students.id', $siswaIdToFilter);
                });
            }
        }

        // --- Filter Kelas ---
        if ($request->filled('kelas_id')) {
            $kelasIdToFilter = $request->input('kelas_id');
            if ($activeTasksQuery) {
                // Di sini, relasi tetap 'siswa.kelasTahfidz' karena relasi dari Student ke KelasTahfidz
                // tidak berubah namanya (tetap kelasTahfidz)
                $activeTasksQuery->whereHas('siswa.kelasTahfidz', function($q) use ($kelasIdToFilter) {
                    $q->where('kelas_tahfidz.id', $kelasIdToFilter);
                });
            }
            if ($archivedTasksQuery) {
                $archivedTasksQuery->whereHas('siswa.kelasTahfidz', function($q) use ($kelasIdToFilter) {
                    $q->where('kelas_tahfidz.id', $kelasIdToFilter);
                });
            }
        }

        // --- Sorting (No change needed here) ---
        if ($activeTasksQuery) {
            $activeTasksQuery->orderBy($sortBy, $sortOrder);
        }
        if ($archivedTasksQuery) {
            $archivedTasksQuery->orderBy($sortBy, $sortOrder);
        }

        // --- Paginasi (No change needed here) ---
        $perPage = $request->input('perPage', 10);
        $activeTasks = $activeTasksQuery ? $activeTasksQuery->paginate($perPage, ['*'], 'active_page')->appends($request->query()) : null;
        $archivedTasks = $archivedTasksQuery ? $archivedTasksQuery->paginate($perPage, ['*'], 'archived_page')->appends($request->query()) : null;

        // --- Data tambahan untuk dropdown filter ---
        // Dapatkan kelas yang diajar oleh guru ini
        $kelasList = KelasTahfidz::where('teacher_id', Auth::user()->guru->id)->get();

        // Dapatkan students (siswa) yang ada di kelas-kelas yang diajar oleh guru ini
        $studentsList = Student::whereHas('kelasTahfidz', function($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            })->with('kelasTahfidz', 'user')->get();

        return view('teacher.tugas_hafalan.index', compact('activeTasks', 'archivedTasks', 'kelasList', 'studentsList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guru = auth()->user()->guru;

        if (!$guru) {
            abort(403, 'Data guru tidak ditemukan untuk user ini.');
        }

        // Ambil kelas tahfidz milik guru yang memiliki siswa dengan tahun ajaran aktif
        $kelasTahfidz = $guru->kelasTahfidz()
            ->whereHas('siswaKelas', function ($query) {
                $query->whereHas('tahunAjaran', function ($q) {
                    $q->where('status', true);
                });
            })
            ->get();

        $surahs = Surah::orderBy('nama')->get();

        // Ambil siswa dari kelas-kelas tersebut
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();
        $studentIds = SiswaKelas::whereIn('kelas_tahfidz_id', $kelasTahfidz->pluck('id'))
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->pluck('student_id');

        $students = Student::with('user')->whereIn('id', $studentIds)->get();

        return view('teacher.tugas_hafalan.create', compact('kelasTahfidz', 'surahs', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // ... (Your validation code remains the same)

    DB::transaction(function () use ($request) {
        $firstSurah = $request->surah_data[0];
        $surahModel = Surah::find($firstSurah['surah_id']);
        $namaTugas = now()->format('Ymd-His') . ' - ' . $surahModel->nama .
            ' Ayat ' . $firstSurah['ayat_awal'] . '-' . $firstSurah['ayat_akhir'] .
            ' - ' . '(' . ucfirst($request->jenis_tugas) . ')';

        $tugas = TugasHafalan::create([
            'teacher_id' => Auth::user()->guru->id,
            'kelas_tahfidz_id' => $request->kelas_tahfidz_id,
            'nama' => $namaTugas,
            'deskripsi' => $request->deskripsi,
            'jenis_tugas' => $request->jenis_tugas,
            'tenggat_waktu' => $request->tenggat_waktu,
            'status' => 'aktif',
            'is_archived' => false,
            'is_for_all_student' => $request->is_for_all_student,
        ]);

        // --- Perbaikan untuk surahHafalan (HasMany) ---
        // Siapkan data untuk dibuat
        $surahToCreate = [];
        foreach ($request->surah_data as $surah) {
            $surahToCreate[] = [
                'surah_id' => $surah['surah_id'],
                'ayat_awal' => $surah['ayat_awal'],
                'ayat_akhir' => $surah['ayat_akhir'],
                'created_at' => now(), // Important for mass assignment
                'updated_at' => now(), // Important for mass assignment
            ];
        }
        $tugas->surahHafalan()->createMany($surahToCreate);
        // --- Akhir Perbaikan ---

        // Assign students based on is_for_all_student (This part is correct because 'siswa' is belongsToMany)
        $studentIdsToAssign = [];
        if ($request->is_for_all_student) {
            $tahunAjaranAktif = TahunAjaran::where('status', true)->first();
            if (!$tahunAjaranAktif) {
                throw new \Exception('Tidak ada tahun ajaran aktif.');
            }
            $studentIdsToAssign = SiswaKelas::where('kelas_tahfidz_id', $request->kelas_tahfidz_id)
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->pluck('student_id')
                ->toArray();
        } else {
            $studentIdsToAssign = $request->student_ids ?? [];
        }
        $tugas->siswa()->sync($studentIdsToAssign);
    });

    return redirect()->route('teacher.tugas_hafalan.index')->with('success', 'Tugas hafalan berhasil dibuat.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Implement show logic if needed
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TugasHafalan $tugasHafalan)
{
    $guru = Auth::user()->guru;

    // Pastikan guru hanya bisa mengedit tugas miliknya
    if ($tugasHafalan->teacher_id !== $guru->id) {
        abort(403, 'Anda tidak memiliki akses untuk mengedit tugas ini.');
    }

    // --- Perbaikan di sini: Muat relasi yang diperlukan ---
    // Memuat 'kelasTahfidz' langsung pada tugasHafalan
    // Memuat 'surahHafalan' DAN relasi 'surah' di dalamnya
    // Memuat 'siswa' dan relasi 'user' di dalamnya
    $tugasHafalan->load([
        'kelasTahfidz', // Memuat relasi KelasTahfidz langsung pada TugasHafalan
        'surahHafalan.surah', // Memuat relasi Surah melalui SurahHafalan
        'siswa.user' // Eager load 'user' dari Student untuk nama siswa
    ]);

    // Ambil kelas tahfidz milik guru yang memiliki siswa dengan tahun ajaran aktif
    // Ini adalah daftar untuk dropdown pilihan kelas
    $kelasTahfidzOptions = $guru->kelasTahfidz()
        ->whereHas('siswaKelas', function ($query) {
            $query->whereHas('tahunAjaran', function ($q) {
                // Periksa status aktif tahun ajaran, sesuaikan jika 'status' adalah boolean
                $q->where('status', true); // Jika 'status' boolean
                // $q->where('status', 'aktif'); // Jika 'status' string 'aktif'
            });
        })
        ->get();

    // Ambil seluruh surah untuk dipilih kembali (untuk dropdown surah)
    $surahs = Surah::orderBy('nama')->get();

    // Ambil surah yang sudah terhubung ke tugas ini dengan ayat awal/akhir
    // Menggunakan relasi 'surah' yang sudah di-eager load dari SurahHafalan
    $surahHafalanTerpilih = $tugasHafalan->surahHafalan->map(function ($sh) {
        return [
            'id' => $sh->id, // ID dari record SurahHafalan itu sendiri
            'surah_id' => $sh->surah_id,
            'nama' => $sh->surah->nama, // Akses nama surah melalui relasi 'surah'
            'ayat_awal' => $sh->ayat_awal,
            'ayat_akhir' => $sh->ayat_akhir,
        ];
    });

    // Ambil siswa yang sudah ditugaskan (untuk pre-select checkbox/dropdown)
    $siswaTerpilihIds = $tugasHafalan->siswa->pluck('id')->toArray();

    // Ambil daftar semua siswa yang relevan untuk dropdown (seperti di create)
    $tahunAjaranAktif = TahunAjaran::where('status', true)->first(); // Sesuaikan dengan status tahun ajaran Anda
    $studentsOptions = collect(); // Inisialisasi koleksi kosong

    if ($tahunAjaranAktif) {
        $studentIdsInKelasGuru = SiswaKelas::whereIn('kelas_tahfidz_id', $kelasTahfidzOptions->pluck('id'))
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->pluck('student_id');

        $studentsOptions = Student::with('user')->whereIn('id', $studentIdsInKelasGuru)->get();
    }


    // Determine if it was assigned to all or specific students based on is_for_all_student
    $isForAllStudent = $tugasHafalan->is_for_all_student;

    return view('teacher.tugas_hafalan.edit', compact(
        'tugasHafalan',
        'kelasTahfidzOptions', // Gunakan nama yang lebih jelas untuk daftar pilihan kelas
        'surahs',
        'surahHafalanTerpilih', // Gunakan nama yang lebih jelas untuk data surah yang sudah dipilih
        'siswaTerpilihIds',
        'studentsOptions', // Daftar semua siswa yang bisa dipilih
        'isForAllStudent'
    ));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            //'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis_tugas' => 'required|in:baru,murajaah',
            'tenggat_waktu' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
            'kelas_tahfidz_id' => 'required|exists:kelas_tahfidzs,id',
            'surah_data' => 'required|array',
            'surah_data.*.surah_id' => 'required|exists:surahs,id',
            'surah_data.*.ayat_awal' => 'required|integer',
            'surah_data.*.ayat_akhir' => 'required|integer',
            'is_for_all_student' => ['required', Rule::in([0, 1])], // Added validation
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        foreach ($request->surah_data as $index => $surah) {
            if ($surah['ayat_akhir'] < $surah['ayat_awal']) {
                return back()->withErrors([
                    "surah_data.$index.ayat_akhir" => "Ayat akhir tidak boleh lebih kecil dari ayat awal (baris ke-" . ($index + 1) . ")."
                ])->withInput();
            }
            $surahModel = Surah::find($surah['surah_id']);
            if ($surahModel && $surah['ayat_akhir'] > $surahModel->total_ayat) {
                return back()->withErrors([
                    "surah_data.$index.ayat_akhir" => "Ayat akhir melebihi total ayat Surah " . $surahModel->nama . " (" . ($index + 1) . ")."
                ])->withInput();
            }
        }

        DB::transaction(function () use ($request, $id) {
            $tugas = TugasHafalan::findOrFail($id);

            // Ensure the teacher owns this task before updating
            if ($tugas->teacher_id !== Auth::user()->guru->id) {
                abort(403, 'Anda tidak memiliki akses untuk mengedit tugas ini.');
            }

            $generatedName = $this->generateTaskName($request->surah_data, $request->jenis_tugas);

            $tugas->update([
                'nama' => $generatedName,
                'deskripsi' => $request->deskripsi,
                'jenis_tugas' => $request->jenis_tugas,
                'tenggat_waktu' => $request->tenggat_waktu,
                'status' => $request->status,
                'kelas_tahfidz_id' => $request->kelas_tahfidz_id,
                'is_for_all_student' => $request->is_for_all_student, // Update this value
            ]);

            // // Synchronize surahs
            // $surahSyncData = [];
            // foreach ($request->surah_data as $surah) {
            //     $surahSyncData[$surah['surah_id']] = [
            //         'ayat_awal' => $surah['ayat_awal'],
            //         'ayat_akhir' => $surah['ayat_akhir'],
            //     ];
            // }
            // $tugas->surahHafalan()->sync($surahSyncData);

            // --- CORRECTED LOGIC FOR HASMANY RELATIONSHIP ---
        // 1. Delete all existing SurahHafalan records for this TugasHafalan
        $tugas->surahHafalan()->delete(); // This deletes all child records

        // 2. Prepare new data for creation
        $surahToCreate = [];
        foreach ($request->surah_data as $surah) {
            $surahToCreate[] = [
                'surah_id' => $surah['surah_id'],
                'ayat_awal' => $surah['ayat_awal'],
                'ayat_akhir' => $surah['ayat_akhir'],
                // 'tugas_hafalan_id' will be automatically set by createMany
                'created_at' => now(), // Important for mass assignment
                'updated_at' => now(), // Important for mass assignment
            ];
        }

        // 3. Create the new SurahHafalan records
        $tugas->surahHafalan()->createMany($surahToCreate);
        // --- END CORRECTED LOGIC ---

            // Synchronize students based on is_for_all_student
            $studentIdsToAssign = [];
            if ($request->is_for_all_student) {
                $tahunAjaranAktif = TahunAjaran::where('status', true)->first();
                if (!$tahunAjaranAktif) {
                    throw new \Exception('Tidak ada tahun ajaran aktif.');
                }
                $studentIdsToAssign = SiswaKelas::where('kelas_tahfidz_id', $request->kelas_tahfidz_id)
                    ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                    ->pluck('student_id')
                    ->toArray();
            } else {
                $studentIdsToAssign = $request->student_ids ?? [];
            }
            $tugas->siswa()->sync($studentIdsToAssign);
        });

        return redirect()->route('teacher.tugas_hafalan.index')->with('success', 'Tugas hafalan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tugas = TugasHafalan::findOrFail($id);

        // Ensure the teacher owns this task before deleting
        if ($tugas->teacher_id !== Auth::user()->guru->id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus tugas ini.');
        }

        DB::transaction(function () use ($tugas) {
            // Hapus relasi pivot terlebih dahulu
            $tugas->surahHafalan()->delete();
            $tugas->siswa()->detach(); // Detach students from tugas_siswas table

            $tugas->delete();
        });

        return redirect()->route('teacher.tugas_hafalan.index')->with('success', 'Tugas hafalan berhasil dihapus.');
    }

    private function generateTaskName(array $surahData, string $jenisTugas): string
    {
        $namaSurahList = [];

        foreach ($surahData as $data) {
            $surah = Surah::find($data['surah_id']);
            if ($surah) {
                $namaSurahList[] = $surah->nama . ' (' . $data['ayat_awal'] . '-' . $data['ayat_akhir'] . ')';
            }
        }

        $tanggal = now()->format('Ymd_His'); // YYYYMMDD_HHMMSS
        $jenis = ucfirst($jenisTugas); // Baru / Murajaah

        return "{$jenis} - " . implode(', ', $namaSurahList) . " - {$tanggal}";
    }

    public function getSiswaByKelas($kelasTahfidzId)
    {
        // 1. Cek Tahun Ajaran Aktif
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        if (!$tahunAjaranAktif) {
            Log::warning('Permintaan siswa untuk kelas ' . $kelasTahfidzId . ': Tidak ada Tahun Ajaran aktif ditemukan.');
            // Mengembalikan respons 404 atau respons kosong dengan status OK,
            // tergantung bagaimana Anda ingin JavaScript menanganinya.
            // Jika 404, itu berarti resource (tahun ajaran aktif) tidak ditemukan.
            return response()->json([], 404);
            // Atau, jika Anda hanya ingin mengembalikan array kosong tanpa error HTTP:
            // return response()->json([]);
        }

        // 2. Query Siswa berdasarkan Kelas dan Tahun Ajaran Aktif
        $siswa = Student::whereHas('siswaKelas', function ($query) use ($kelasTahfidzId, $tahunAjaranAktif) {
            $query->where('kelas_tahfidz_id', $kelasTahfidzId)
                  ->where('tahun_ajaran_id', $tahunAjaranAktif->id); // Sesuaikan dengan PK TahunAjaran Anda
        })
        ->with('user:id,name') // Ambil relasi user dengan field id dan name
        ->select('id', 'user_id') // Pilih kolom student_id (PK) dan user_id (FK ke users)
        ->get()
        ->map(function ($student) {
            return [
                'id' => $student->id, // Kunci 'id' untuk value di <option>
                'name' => $student->user->name, // Kunci 'name' untuk teks di <option>
            ];
        });

        // 3. Logging untuk Debugging (opsional, sangat membantu)
        Log::info('Berhasil mengambil ' . $siswa->count() . ' siswa untuk kelas ID ' . $kelasTahfidzId);
        // Log::debug('Data siswa JSON: ' . $siswa->toJson()); // Untuk melihat struktur JSON lengkap

        return response()->json($siswa);
    }

    public function toggleArchive(TugasHafalan $tugasHafalan)
    {
        $this->authorizeTaskOwner($tugasHafalan);

        $tugasHafalan->is_archived = ! $tugasHafalan->is_archived;
        $tugasHafalan->save();

        return redirect()->route('teacher.tugas_hafalan.index')->with('success', $tugasHafalan->is_archived ? 'Tugas diarsipkan.' : 'Tugas dipulihkan.');
    }

    private function authorizeTaskOwner(TugasHafalan $tugasHafalan)
    {
        // Ensure the teacher owns this task before deleting
        if ($tugasHafalan->teacher_id !== Auth::user()->guru->id) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }
    }

}
