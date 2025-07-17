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
            $table->foreignId('pengumpulan_id')
                  ->nullable() // Sesuaikan jika Anda ingin kolom ini wajib diisi
                  ->constrained('pengumpulans') // Nama tabel yang direferensikan
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surah_hafalans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pengumpulan_id'); // Menghapus foreignId yang dibatasi
            // Atau: $table->dropForeign(['pengumpulan_id']);

            // Menghapus kolom
            $table->dropColumn('pengumpulan_id');
        });
    }
};
