<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Keahlian contoh untuk dua kategori.
     */
    public function run(): void
    {
        $skills = [
            Skill::KATEGORI_ADMINISTRASI => [
                ['nama' => 'Microsoft Excel', 'deskripsi' => 'Mengolah data, rumus, pivot table, dan visualisasi laporan.'],
                ['nama' => 'Microsoft Word', 'deskripsi' => 'Menyusun dokumen, surat resmi, dan laporan dengan format rapi.'],
                ['nama' => 'Microsoft PowerPoint', 'deskripsi' => 'Membuat presentasi yang jelas, informatif, dan mudah dipahami.'],
                ['nama' => 'Administrasi Dokumen', 'deskripsi' => 'Pengarsipan, rekap data, dan pengelolaan dokumen secara terstruktur.'],
                ['nama' => 'Pengolahan Data', 'deskripsi' => 'Membersihkan, merapikan, dan merangkum data untuk kebutuhan laporan.'],
            ],
            Skill::KATEGORI_WEB => [
                ['nama' => 'Laravel', 'deskripsi' => 'Membangun aplikasi web dengan struktur MVC dan keamanan bawaan.'],
                ['nama' => 'PHP & MySQL', 'deskripsi' => 'Mengelola data dan membangun fitur backend yang andal.'],
                ['nama' => 'Tailwind CSS', 'deskripsi' => 'Menyusun antarmuka responsif yang bersih dan konsisten.'],
                ['nama' => 'JavaScript', 'deskripsi' => 'Menambahkan interaksi dinamis pada halaman web.'],
                ['nama' => 'Git & GitHub', 'deskripsi' => 'Mengelola versi kode dan berkolaborasi dalam proyek.'],
            ],
        ];

        foreach ($skills as $kategori => $items) {
            foreach ($items as $index => $item) {
                Skill::updateOrCreate(
                    ['nama' => $item['nama']],
                    [
                        'deskripsi' => $item['deskripsi'],
                        'kategori' => $kategori,
                        'urutan' => $index + 1,
                    ],
                );
            }
        }
    }
}
