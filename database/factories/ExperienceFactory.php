<?php

namespace Database\Factories;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Experience>
 */
class ExperienceFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipe = fake()->randomElement(array_keys(Experience::tipeLabels()));
        $tahunMulai = fake()->numberBetween(2015, (int) date('Y'));

        return [
            'tipe' => $tipe,
            'judul' => ucfirst(fake()->words(3, true)),
            'institusi' => fake()->company(),
            'tahun_mulai' => $tahunMulai,
            'tahun_selesai' => $tipe === Experience::TIPE_SERTIFIKAT
                ? null
                : fake()->numberBetween($tahunMulai, min(2030, $tahunMulai + 4)),
            'deskripsi' => fake()->paragraph(),
        ];
    }

    public function pendidikan(): static
    {
        return $this->state(fn (array $attributes): array => [
            'tipe' => Experience::TIPE_PENDIDIKAN,
        ]);
    }

    public function pengalaman(): static
    {
        return $this->state(fn (array $attributes): array => [
            'tipe' => Experience::TIPE_PENGALAMAN,
        ]);
    }

    public function sertifikat(): static
    {
        return $this->state(fn (array $attributes): array => [
            'tipe' => Experience::TIPE_SERTIFIKAT,
            'tahun_selesai' => null,
        ]);
    }
}
