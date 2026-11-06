<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Data profil contoh. Silakan ganti melalui panel admin.
     */
    public function run(): void
    {
        if (Profile::query()->exists()) {
            return;
        }

        Profile::create([
            'nama' => 'Nama Lengkap',
            'headline' => 'Web Developer · Pengolahan Data & Administrasi',
            'bio' => "Saya adalah web developer yang juga terbiasa menangani administrasi dan pengolahan data. Saya senang membangun aplikasi web yang rapi, mudah digunakan, dan menyelesaikan masalah nyata.\n\nSelain menulis kode, saya terbiasa menyusun laporan, merapikan dokumen, dan mengolah data menggunakan Microsoft Excel, Word, dan PowerPoint.",
            'foto' => null,
            'email' => 'halo@example.com',
            'no_wa' => '6281234567890',
            'link_linkedin' => 'https://www.linkedin.com/in/nama-lengkap',
            'link_github' => 'https://github.com/nama-lengkap',
        ]);
    }
}
