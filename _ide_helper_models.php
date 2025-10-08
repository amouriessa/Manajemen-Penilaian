<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Admin whereUpdatedAt($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\Student|null $student
 * @property-read \App\Models\TugasHafalan|null $tugasHafalan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HafalanSubmission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HafalanSubmission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HafalanSubmission query()
 */
	class HafalanSubmission extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $teacher_id
 * @property string $nama
 * @property string $tingkatan_kelas
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $tingkatan_label
 * @property-read \App\Models\Teacher|null $guru
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SiswaKelas> $siswaKelas
 * @property-read int|null $siswa_kelas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @property-read \App\Models\TahunAjaran|null $tahunAjaran
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TugasHafalan> $tugasHafalan
 * @property-read int|null $tugas_hafalan_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasTahfidz newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasTahfidz newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasTahfidz query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasTahfidz whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasTahfidz whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasTahfidz whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasTahfidz whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasTahfidz whereTingkatanKelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasTahfidz whereUpdatedAt($value)
 */
	class KelasTahfidz extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tugas_hafalan_id
 * @property int $student_id
 * @property string $file_pengumpulan
 * @property string $status
 * @property string $submitted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Penilaian|null $penilaian
 * @property-read \App\Models\Student $siswa
 * @property-read \App\Models\SurahHafalan|null $surahHafalan
 * @property-read \App\Models\TugasHafalan $tugasHafalan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumpulan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumpulan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumpulan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumpulan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumpulan whereFilePengumpulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumpulan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumpulan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumpulan whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumpulan whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumpulan whereTugasHafalanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengumpulan whereUpdatedAt($value)
 */
	class Pengumpulan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $pengumpulan_id
 * @property int $student_id
 * @property int $teacher_id
 * @property int|null $tugas_hafalan_id
 * @property string|null $jenis_penilaian
 * @property string|null $jenis_hafalan
 * @property int|null $nilai_tajwid
 * @property int|null $nilai_harakat
 * @property int|null $nilai_makhraj
 * @property int|null $nilai_total
 * @property string|null $predikat
 * @property string|null $catatan
 * @property string $assessed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $predikat_label
 * @property-read \App\Models\Teacher $guru
 * @property-read \App\Models\Pengumpulan|null $pengumpulan
 * @property-read \App\Models\Student $siswa
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurahHafalan> $surahHafalanPenilaian
 * @property-read int|null $surah_hafalan_penilaian_count
 * @property-read \App\Models\TugasHafalan|null $tugasHafalan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereAssessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereJenisHafalan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereJenisPenilaian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereNilaiHarakat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereNilaiMakhraj($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereNilaiTajwid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereNilaiTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian wherePengumpulanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian wherePredikat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereTugasHafalanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Penilaian whereUpdatedAt($value)
 */
	class Penilaian extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $student_id
 * @property int $kelas_tahfidz_id
 * @property int $tahun_ajaran_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $tingkatan_label
 * @property-read \App\Models\KelasTahfidz $kelasTahfidz
 * @property-read \App\Models\Student $siswa
 * @property-read \App\Models\TahunAjaran $tahunAjaran
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiswaKelas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiswaKelas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiswaKelas query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiswaKelas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiswaKelas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiswaKelas whereKelasTahfidzId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiswaKelas whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiswaKelas whereTahunAjaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SiswaKelas whereUpdatedAt($value)
 */
	class SiswaKelas extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int|null $tahun_angkatan_id
 * @property string $nis
 * @property string|null $jenis_kelamin
 * @property string|null $tanggal_lahir
 * @property string|null $alamat
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HafalanSubmission> $hafalanSubmissions
 * @property-read int|null $hafalan_submissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\KelasTahfidz> $kelasTahfidz
 * @property-read int|null $kelas_tahfidz_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pengumpulan> $pengumpulan
 * @property-read int|null $pengumpulan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Penilaian> $penilaian
 * @property-read int|null $penilaian_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SiswaKelas> $riwayatKelas
 * @property-read int|null $riwayat_kelas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SiswaKelas> $siswaKelas
 * @property-read int|null $siswa_kelas_count
 * @property-read mixed $status_label
 * @property-read \App\Models\TahunAngkatan|null $tahunAngkatan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TugasHafalan> $tugasSiswa
 * @property-read int|null $tugas_siswa_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereNis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereTahunAngkatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereUserId($value)
 */
	class Student extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property int $total_ayat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TugasHafalan> $tugasHafalan
 * @property-read int|null $tugas_hafalan_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surah query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surah whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surah whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surah whereTotalAyat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Surah whereUpdatedAt($value)
 */
	class Surah extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $tugas_hafalan_id
 * @property int $surah_id
 * @property int $ayat_awal
 * @property int $ayat_akhir
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $penilaian_id
 * @property int|null $pengumpulan_id
 * @property-read \App\Models\Pengumpulan|null $pengumpulan
 * @property-read \App\Models\Penilaian|null $penilaian
 * @property-read \App\Models\Surah $surah
 * @property-read \App\Models\TugasHafalan|null $tugasHafalan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurahHafalan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurahHafalan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurahHafalan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurahHafalan whereAyatAkhir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurahHafalan whereAyatAwal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurahHafalan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurahHafalan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurahHafalan wherePengumpulanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurahHafalan wherePenilaianId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurahHafalan whereSurahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurahHafalan whereTugasHafalanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SurahHafalan whereUpdatedAt($value)
 */
	class SurahHafalan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $tahun_ajaran
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SiswaKelas> $siswaKelas
 * @property-read int|null $siswa_kelas_count
 * @property-read mixed $status_label
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAjaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAjaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAjaran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAjaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAjaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAjaran whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAjaran whereTahunAjaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAjaran whereUpdatedAt($value)
 */
	class TahunAjaran extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $tahun_angkatan
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $siswa
 * @property-read int|null $siswa_count
 * @property-read mixed $status_label
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAngkatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAngkatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAngkatan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAngkatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAngkatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAngkatan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAngkatan whereTahunAngkatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAngkatan whereUpdatedAt($value)
 */
	class TahunAngkatan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $nip
 * @property string|null $jenis_kelamin
 * @property string|null $tanggal_lahir
 * @property string|null $alamat
 * @property string|null $nomor_telp
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\KelasTahfidz> $kelasTahfidz
 * @property-read int|null $kelas_tahfidz_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Penilaian> $penilaian
 * @property-read int|null $penilaian_count
 * @property-read mixed $status_label
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TugasHafalan> $tugasHafalan
 * @property-read int|null $tugas_hafalan_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereNomorTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereUserId($value)
 */
	class Teacher extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $teacher_id
 * @property int $kelas_tahfidz_id
 * @property string $nama
 * @property string|null $deskripsi
 * @property string $jenis_tugas
 * @property string $tenggat_waktu
 * @property string $status
 * @property int $is_archived
 * @property int $is_for_all_student
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Teacher $guru
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HafalanSubmission> $hafalanSubmissions
 * @property-read int|null $hafalan_submissions_count
 * @property-read \App\Models\KelasTahfidz $kelasTahfidz
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pengumpulan> $pengumpulan
 * @property-read int|null $pengumpulan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Penilaian> $penilaian
 * @property-read int|null $penilaian_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $siswa
 * @property-read int|null $siswa_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SurahHafalan> $surahHafalan
 * @property-read int|null $surah_hafalan_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan archived()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan whereIsArchived($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan whereIsForAllStudent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan whereJenisTugas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan whereKelasTahfidzId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan whereTenggatWaktu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasHafalan whereUpdatedAt($value)
 */
	class TugasHafalan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tugas_hafalan_id
 * @property int $student_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasSiswa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasSiswa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasSiswa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasSiswa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasSiswa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasSiswa whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasSiswa whereTugasHafalanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TugasSiswa whereUpdatedAt($value)
 */
	class TugasSiswa extends \Eloquent {}
}

namespace App\Models{
/**
 * @property Teacher $guru
 * @property int $id
 * @property string|null $avatar
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int $is_logged_in
 * @property \Illuminate\Support\Carbon|null $last_login_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Student|null $siswa
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsLoggedIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

