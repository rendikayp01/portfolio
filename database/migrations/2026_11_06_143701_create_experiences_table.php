<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Riwayat pendidikan, pengalaman kerja, dan sertifikat untuk bagian CV.
     */
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('tipe', 20);
            $table->string('judul', 150);
            $table->string('institusi', 150);
            $table->unsignedSmallInteger('tahun_mulai');
            $table->unsignedSmallInteger('tahun_selesai')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->index(['tipe', 'tahun_mulai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
