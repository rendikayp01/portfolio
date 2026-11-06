<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Keahlian dikelompokkan menjadi administrasi dan web.
     */
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('deskripsi', 255);
            $table->string('kategori', 20);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();

            $table->index(['kategori', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
