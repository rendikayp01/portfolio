<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Riwayat pendidikan, pengalaman, dan sertifikat contoh.
     */
    public function run(): void
    {
        $experiences = [
            [
                'tipe' => Experience::TIPE_PENDIDIKAN,
                'judul' => 'S1 Teknik Informatika',
                'institusi' => 'Universitas Nusantara',
                'tahun_mulai' => 2019,
                'tahun_selesai' => 2023,
                'deskripsi' => 'Mempelajari rekayasa perangkat lunak, basis data, dan pengembangan aplikasi web. Lulus dengan skripsi tentang sistem informasi berbasis web.',
            ],
            [
                'tipe' => Experience::TIPE_PENDIDIKAN,
                'judul' => 'SMK Rekayasa Perangkat Lunak',
                'institusi' => 'SMK Negeri 1 Contoh',
                'tahun_mulai' => 2016,
                'tahun_selesai' => 2019,
                'deskripsi' => 'Mempelajari dasar pemrograman, basis data, serta pengembangan aplikasi desktop dan web.',
            ],
            [
                'tipe' => Experience::TIPE_PENGALAMAN,
                'judul' => 'Web Developer Freelance',
                'institusi' => 'Mandiri',
                'tahun_mulai' => 2023,
                'tahun_selesai' => null,
                'deskripsi' => 'Mengerjakan website profil bisnis, landing page, dan perbaikan tampilan responsif untuk beberapa klien.',
            ],
            [
                'tipe' => Experience::TIPE_PENGALAMAN,
                'judul' => 'Admin Data & Administrasi',
                'institusi' => 'PT Contoh Digital',
                'tahun_mulai' => 2022,
                'tahun_selesai' => 2023,
                'deskripsi' => 'Mengelola rekap data operasional, menyusun laporan Excel, dan merapikan arsip dokumen perusahaan.',
            ],
            [
                'tipe' => Experience::TIPE_PENGALAMAN,
                'judul' => 'Magang Web Developer',
                'institusi' => 'Studio Kreatif Contoh',
                'tahun_mulai' => 2021,
                'tahun_selesai' => 2022,
                'deskripsi' => 'Membantu pengembangan fitur backend, pengujian formulir, dan dokumentasi proyek.',
            ],
            [
                'tipe' => Experience::TIPE_SERTIFIKAT,
                'judul' => 'Junior Web Developer',
                'institusi' => 'BNSP',
                'tahun_mulai' => 2023,
                'tahun_selesai' => null,
                'deskripsi' => 'Sertifikasi kompetensi di bidang pengembangan web.',
            ],
            [
                'tipe' => Experience::TIPE_SERTIFIKAT,
                'judul' => 'Microsoft Office Specialist',
                'institusi' => 'Certiport',
                'tahun_mulai' => 2022,
                'tahun_selesai' => null,
                'deskripsi' => 'Sertifikasi penggunaan Microsoft Excel, Word, dan PowerPoint.',
            ],
            [
                'tipe' => Experience::TIPE_SERTIFIKAT,
                'judul' => 'Belajar Dasar Pemrograman Web',
                'institusi' => 'Dicoding',
                'tahun_mulai' => 2021,
                'tahun_selesai' => null,
                'deskripsi' => 'Kelas dasar HTML, CSS, dan JavaScript.',
            ],
        ];

        foreach ($experiences as $experience) {
            Experience::updateOrCreate(
                [
                    'tipe' => $experience['tipe'],
                    'judul' => $experience['judul'],
                    'institusi' => $experience['institusi'],
                ],
                $experience,
            );
        }
    }
}
