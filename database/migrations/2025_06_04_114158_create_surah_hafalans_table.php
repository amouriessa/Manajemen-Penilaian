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
        Schema::create('surah_hafalans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_hafalan_id')->constrained('tugas_hafalans')->onDelete('cascade');
            $table->foreignId('surah_id')->constrained('surahs')->onDelete('cascade');
            $table->integer('ayat_awal');
            $table->integer('ayat_akhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surah_hafalans');
    }
};
