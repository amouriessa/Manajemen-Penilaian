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
        Schema::table('surah_hafalans', function (Blueprint $table) {
            $table->foreignId('penilaian_id')
              ->nullable()
              ->constrained('penilaians')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surah_hafalans', function (Blueprint $table) {
            $table->dropForeign(['penilaian_id']);
            $table->dropColumn('penilaian_id');
        });
    }
};
