<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Penilaian;
use App\Models\Student;
use App\Models\Surah;
use App\Models\SurahHafalan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PenilaianLangsungController extends Controller
{
    public function index(Request $request)
    {
        $query = Penilaian::with(['siswa.user', 'guru.user', 'surahHafalanPenilaian.surah'])
            ->where('jenis_penilaian', 'langsung');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('siswa.user', fn($q2) =>
                    $q2->where('name', 'like', "%$search%"))
                ->orWhereHas('surahHafalanPenilaian.surah', fn($q3) =>
                    $q3->where('nama', 'like', "%$search%"));
            });
        }

        $filter = $request->input('filter');
        if ($filter === 'sort:newest') {
            $query->latest('assessed_at');
        } elseif ($filter === 'sort:oldest') {
            $query->oldest('assessed_at');
        } elseif (str_starts_with($filter, 'predikat:')) {
            $predikat = explode(':', $filter)[1] ?? null;
            if ($predikat) $query->where('predikat', $predikat);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $penilaian = $query->paginate($request->input('perPage', 10))->withQueryString();
        return view('teacher.penilaian.langsung.index', compact('penilaian'));
    }

    public function create()
    {
        $siswa = Student::with('user')->get();
        $surahList = Surah::all();
        return view('teacher.penilaian.langsung.create', compact('siswa', 'surahList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'jenis_penilaian' => 'required|string|in:langsung',
            'jenis_tugas' => 'required|in:baru,murajaah',
            'nilai_tajwid' => 'required|integer|min:0|max:100',
            'nilai_harakat' => 'required|integer|min:0|max:100',
            'nilai_makhraj' => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string|max:1000',
            'surah_data' => 'nullable|array',
            'surah_data.*.surah_id' => 'required_with:surah_data.*.ayat_awal,surah_data.*.ayat_akhir|exists:surahs,id',
            'surah_data.*.ayat_awal' => 'nullable|integer|min:1',
            'surah_data.*.ayat_akhir' => 'nullable|integer|min:1|gte:surah_data.*.ayat_awal',
        ]);

        $teacher = Auth::user()->guru;
        if (!$teacher) {
            return back()->with('error', 'Akun Anda belum terhubung sebagai guru.');
        }

        $nilaiTotal = round(($request->nilai_tajwid + $request->nilai_harakat + $request->nilai_makhraj) / 3);
        $predikat = match (true) {
            $nilaiTotal >= 90 => 'mumtaz',
            $nilaiTotal >= 80 => 'jayyid_jiddan',
            default => 'jiddan',
        };

        // Simpan penilaian dulu
        $penilaian = Penilaian::create([
            'pengumpulan_id' => null,
            'student_id' => $request->student_id,
            'teacher_id' => $teacher->id,
            'jenis_penilaian' => $request->jenis_penilaian,
            'jenis_hafalan' => $request->jenis_tugas,
            'nilai_tajwid' => $request->nilai_tajwid,
            'nilai_harakat' => $request->nilai_harakat,
            'nilai_makhraj' => $request->nilai_makhraj,
            'nilai_total' => $nilaiTotal,
            'predikat' => $predikat,
            'catatan' => $request->catatan,
            'assessed_at' => now(),
        ]);

        // Simpan surah hafalan (jika ada)
        if ($request->filled('surah_data')) {
            foreach ($request->surah_data as $data) {
                SurahHafalan::create([
                    'penilaian_id' => $penilaian->id,
                    'tugas_hafalan_id' => null,
                    'surah_id' => $data['surah_id'],
                    'ayat_awal' => $data['ayat_awal'],
                    'ayat_akhir' => $data['ayat_akhir'],
                ]);
            }
        }

        return redirect()->route('teacher.penilaian.langsung.index')->with('success', 'Penilaian langsung berhasil disimpan!');
    }

    public function edit(Penilaian $penilaian)
    {
        if ($penilaian->jenis_penilaian !== 'langsung') {
            return redirect()->route('teacher.penilaian.langsung.index')
                ->with('error', 'Penilaian ini bukan tipe langsung.');
        }

        $penilaian->load(['siswa.user', 'surahHafalanPenilaian.surah']);
        $siswa = Student::with('user')->get();
        $surahList = Surah::all();

        return view('teacher.penilaian.langsung.edit', compact('penilaian', 'siswa', 'surahList'));
    }


    public function update(Request $request, Penilaian $penilaian)
    {
        if ($penilaian->jenis_penilaian !== 'langsung') {
            return redirect()->route('teacher.penilaian.langsung.index')
                ->with('error', 'Penilaian ini bukan tipe langsung.');
        }

        $request->validate([
            //'student_id' => 'required|exists:students,id',
            'jenis_tugas' => 'required|in:baru,murajaah',
            'nilai_tajwid' => 'required|integer|min:0|max:100',
            'nilai_harakat' => 'required|integer|min:0|max:100',
            'nilai_makhraj' => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string|max:1000',
            'surah_data' => 'nullable|array',
            'surah_data.*.surah_id' => 'required_with:surah_data.*.ayat_awal,surah_data.*.ayat_akhir|exists:surahs,id',
            'surah_data.*.ayat_awal' => 'nullable|integer|min:1',
            'surah_data.*.ayat_akhir' => 'nullable|integer|min:1|gte:surah_data.*.ayat_awal',
        ]);

        $nilaiTotal = round(($request->nilai_tajwid + $request->nilai_harakat + $request->nilai_makhraj) / 3);
        $predikat = match (true) {
            $nilaiTotal >= 90 => 'mumtaz',
            $nilaiTotal >= 80 => 'jayyid_jiddan',
            default => 'jiddan',
        };

        $penilaian->update([
            //'student_id' => $request->student_id,
            'jenis_hafalan' => $request->jenis_tugas,
            'nilai_tajwid' => $request->nilai_tajwid,
            'nilai_harakat' => $request->nilai_harakat,
            'nilai_makhraj' => $request->nilai_makhraj,
            'nilai_total' => $nilaiTotal,
            'predikat' => $predikat,
            'catatan' => $request->catatan,
            'assessed_at' => now(),
        ]);

        // Hapus dulu surah hafalan lama
        $penilaian->surahHafalanPenilaian()->delete();

        // Tambahkan ulang (jika ada input surah)
        if ($request->filled('surah_data')) {
            foreach ($request->surah_data as $data) {
                SurahHafalan::create([
                    'penilaian_id' => $penilaian->id,
                    'tugas_hafalan_id' => null,
                    'surah_id' => $data['surah_id'],
                    'ayat_awal' => $data['ayat_awal'],
                    'ayat_akhir' => $data['ayat_akhir'],
                ]);
            }
        }

        return redirect()->route('teacher.penilaian.langsung.index')
            ->with('success', 'Penilaian berhasil diperbarui.');
    }


    public function searchStudentUser(Request $request)
    {
        $search = $request->input('q');

        $students = Student::with('user')
            ->whereHas('user', fn($q) =>
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
            ->limit(20)
            ->get();

        return response()->json(
            $students->map(fn($s) => [
                'value' => $s->id,
                'text' => $s->user->name,
                'email' => $s->user->email
            ])
        );
    }

    public function show(Penilaian $penilaian)
    {
        if ($penilaian->jenis_penilaian !== 'langsung') {
            return redirect()->route('teacher.penilaian.langsung.index')->with('error', 'Penilaian ini bukan tipe langsung.');
        }

        $penilaian->load(['siswa.user', 'guru.user', 'surahHafalanPenilaian.surah']);
        return view('teacher.penilaian.langsung.show', compact('penilaian'));
    }

    public function destroy(Penilaian $penilaian)
    {
        if ($penilaian->jenis_penilaian !== 'langsung') {
            return redirect()->route('teacher.penilaian.langsung.index')->with('error', 'Penilaian ini bukan tipe langsung.');
        }

        $penilaian->surahHafalanPenilaian()->delete();
        $penilaian->delete();

        return redirect()->route('teacher.penilaian.langsung.index')->with('success', 'Penilaian berhasil dihapus.');
    }

}
