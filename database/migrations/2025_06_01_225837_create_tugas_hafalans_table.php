<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tugas_hafalans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers');
            $table->foreignId('kelas_tahfidz_id')->constrained('kelas_tahfidzs');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->enum('jenis_tugas', ['baru', 'murajaah']);
            $table->date('tenggat_waktu');
            $table->enum('status', ['pending', 'aktif', 'telat', 'selesai', 'dibatalkan'])->default('pending');
            $table->boolean('is_archived')->default(false);
            $table->boolean('is_for_all_student')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_hafalans');
    }
};
