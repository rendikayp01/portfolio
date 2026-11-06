<?php

namespace Database\Factories;

use App\Models\CvFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CvFile>
 */
class CvFileFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_pdf' => 'cv/'.fake()->uuid().'.pdf',
            'aktif' => false,
        ];
    }

    /**
     * File CV yang dipakai di halaman publik.
     */
    public function aktif(): static
    {
        return $this->state(fn (array $attributes): array => [
            'aktif' => true,
        ]);
    }
}
