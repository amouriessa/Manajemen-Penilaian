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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengumpulan_id')->nullable()->constrained('pengumpulans')->nullOnDelete();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->foreignId('tugas_hafalan_id')->constrained('tugas_hafalans')->onDelete('cascade');
            $table->enum('jenis_penilaian', ['langsung', 'pengumpulan'])->nullable();
            $table->enum('jenis_hafalan', ['baru', 'murajaah'])->nullable();
            $table->integer('nilai_tajwid')->nullable();
            $table->integer('nilai_harakat')->nullable();
            $table->integer('nilai_makhraj')->nullable();
            $table->integer('nilai_total')->nullable();
            $table->enum('predikat', ['mumtaz', 'jayyid_jiddan', 'jiddan'])->nullable();
            $table->text('catatan')->nullable();
            $table->dateTime('assessed_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
