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
        Schema::create('pengumpulans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_hafalan_id')->constrained('tugas_hafalans')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students');
            $table->string('file_pengumpulan');
            $table->enum('status', ['pending', 'dinilai', 'ditolak', 'mengulang', 'telat', 'dikumpulkan']);
            $table->dateTime('submitted_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumpulans');
    }
};
