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
        Schema::create('kelas_tahfidzs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->onDelete('set null');
            $table->string('nama');
            $table->enum('tingkatan_kelas', ['7', '8', '9']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_tahfidzs');
    }
};
