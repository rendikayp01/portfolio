<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Dua pesan contoh untuk menguji halaman pesan masuk.
     */
    public function run(): void
    {
        if (Message::query()->exists()) {
            return;
        }

        Message::create([
            'nama' => 'Dina Pratiwi',
            'email' => 'dina.pratiwi@example.com',
            'pesan' => 'Halo, saya tertarik dengan pengalaman Anda di bidang web development dan pengolahan data. Apakah Anda terbuka untuk peluang kerja full-time?',
            'sudah_dibaca' => false,
        ]);

        Message::create([
            'nama' => 'Raka Pratama',
            'email' => 'raka.pratama@example.com',
            'pesan' => 'Selamat pagi, kami sedang mencari web developer untuk proyek website perusahaan. Boleh diskusi lebih lanjut mengenai portofolio Anda?',
            'sudah_dibaca' => true,
        ]);
    }
}
