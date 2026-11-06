<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Proyek contoh: tiga tampil dan satu draft untuk menguji filter status.
     */
    public function run(): void
    {
        $projects = [
            [
                'judul' => 'Sistem Informasi Arsip Sekolah',
                'slug' => 'sistem-informasi-arsip-sekolah',
                'ringkasan' => 'Aplikasi web untuk mendigitalkan arsip sekolah, mempercepat pencarian dokumen, dan merapikan pencatatan surat masuk serta surat keluar.',
                'deskripsi_masalah' => 'Arsip sekolah masih disimpan dalam lemari fisik. Dokumen sulit dicari, rawan hilang, dan memakan banyak ruang penyimpanan.',
                'deskripsi_solusi' => 'Membangun aplikasi Laravel dengan fitur kategori arsip, pencarian, unggah PDF, dan pengaturan hak akses admin. MySQL digunakan untuk menyimpan metadata dokumen secara terstruktur.',
                'deskripsi_hasil' => 'Waktu pencarian dokumen turun dari beberapa menit menjadi hitungan detik. Pengelolaan surat menjadi lebih rapi dan mudah diaudit.',
                'kategori' => 'Web Application',
                'teknologi' => 'Laravel, MySQL, Blade, Tailwind CSS',
                'peran' => 'Full-stack Developer',
                'tahun' => 2024,
                'urutan' => 1,
                'status' => Project::STATUS_TAMPIL,
            ],
            [
                'judul' => 'Dashboard Rekap Data Penjualan',
                'slug' => 'dashboard-rekap-data-penjualan',
                'ringkasan' => 'Template Excel interaktif untuk merangkum data penjualan bulanan, menghitung performa produk, dan menyajikan grafik ringkas.',
                'deskripsi_masalah' => 'Rekap penjualan dilakukan manual dengan banyak salinan file. Data sering tidak konsisten dan proses rekap memakan waktu.',
                'deskripsi_solusi' => 'Menyusun template Excel dengan tabel terstruktur, rumus otomatis, pivot table, dan dashboard grafik yang mudah diperbarui.',
                'deskripsi_hasil' => 'Proses rekap bulanan menjadi lebih cepat dan konsisten. Tim dapat langsung membaca tren penjualan dari satu dashboard.',
                'kategori' => 'Pengolahan Data',
                'teknologi' => 'Microsoft Excel, Pivot Table, Power Query',
                'peran' => 'Data & Reporting',
                'tahun' => 2023,
                'urutan' => 2,
                'status' => Project::STATUS_TAMPIL,
            ],
            [
                'judul' => 'Website Profil Sekolah',
                'slug' => 'website-profil-sekolah',
                'ringkasan' => 'Website responsif untuk menampilkan profil sekolah, program, berita, dan informasi penerimaan siswa baru.',
                'deskripsi_masalah' => 'Informasi sekolah tersebar di media sosial dan brosur, sehingga calon siswa dan orang tua kesulitan mendapatkan informasi resmi.',
                'deskripsi_solusi' => 'Membangun website profil dengan halaman terstruktur, tampilan responsif, dan panel admin sederhana untuk memperbarui berita.',
                'deskripsi_hasil' => 'Sekolah memiliki kanal informasi resmi yang mudah diakses dari HP. Pembaruan konten dapat dilakukan tanpa bantuan developer.',
                'kategori' => 'Company Profile',
                'teknologi' => 'Laravel, Blade, Tailwind CSS',
                'peran' => 'Web Developer',
                'tahun' => 2024,
                'urutan' => 3,
                'status' => Project::STATUS_TAMPIL,
            ],
            [
                'judul' => 'Aplikasi Manajemen Tugas',
                'slug' => 'aplikasi-manajemen-tugas',
                'ringkasan' => 'Aplikasi internal untuk mengelola tugas tim, tenggat waktu, dan status pekerjaan dalam satu tempat.',
                'deskripsi_masalah' => 'Pembagian tugas masih dilakukan lewat pesan singkat sehingga status pekerjaan sulit dipantau.',
                'deskripsi_solusi' => 'Membangun aplikasi manajemen tugas dengan daftar tugas, penanggung jawab, tenggat waktu, dan status pengerjaan.',
                'deskripsi_hasil' => 'Pekerjaan tim menjadi lebih terlihat dan mudah dikoordinasikan. Proyek ini masih dalam tahap pengembangan.',
                'kategori' => 'Web Application',
                'teknologi' => 'Laravel, MySQL, Tailwind CSS',
                'peran' => 'Full-stack Developer',
                'tahun' => 2025,
                'urutan' => 4,
                'status' => Project::STATUS_DRAFT,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['slug' => $project['slug']],
                $project,
            );
        }
    }
}
