<?php

namespace Database\Seeders;

use App\Models\CvFile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class CvFileSeeder extends Seeder
{
    /**
     * Menyalin PDF contoh ke storage publik dan menandainya aktif.
     */
    public function run(): void
    {
        if (CvFile::query()->exists()) {
            return;
        }

        $path = 'cv/contoh-cv.pdf';
        $source = database_path('seeders/files/contoh-cv.pdf');

        if (! is_file($source)) {
            throw new RuntimeException('File contoh CV tidak ditemukan: '.$source);
        }

        Storage::disk('public')->put($path, file_get_contents($source));

        CvFile::create([
            'file_pdf' => $path,
            'aktif' => true,
        ]);
    }
}
