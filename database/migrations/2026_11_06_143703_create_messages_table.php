<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pesan dari formulir kontak publik.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email', 150);
            $table->text('pesan');
            $table->boolean('sudah_dibaca')->default(false);
            $table->timestamps();

            $table->index('sudah_dibaca');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
