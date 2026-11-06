<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Profil pemilik portofolio. Aplikasi hanya memakai satu baris profil.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 120);
            $table->string('headline', 180);
            $table->text('bio');
            $table->string('foto')->nullable();
            $table->string('email', 150)->unique();
            $table->string('no_wa', 30);
            $table->string('link_linkedin')->nullable();
            $table->string('link_github')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
