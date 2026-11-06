<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Proyek portofolio. Slug dipakai untuk route detail proyek.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 150);
            $table->string('slug', 160)->unique();
            $table->string('ringkasan', 300);
            $table->text('deskripsi_masalah');
            $table->text('deskripsi_solusi');
            $table->text('deskripsi_hasil');
            $table->string('gambar')->nullable();
            $table->string('kategori', 100);
            $table->string('teknologi', 200);
            $table->string('peran', 100);
            $table->unsignedSmallInteger('tahun');
            $table->unsignedInteger('urutan')->default(0);
            $table->string('status', 10)->default('draft');
            $table->timestamps();

            $table->index(['status', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
