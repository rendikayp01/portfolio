<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = 'Proyek '.fake()->unique()->words(3, true);

        return [
            'judul' => Str::title($judul),
            'slug' => Str::slug($judul).'-'.fake()->unique()->numberBetween(100, 999),
            'ringkasan' => fake()->sentence(18),
            'deskripsi_masalah' => fake()->paragraph(),
            'deskripsi_solusi' => fake()->paragraph(),
            'deskripsi_hasil' => fake()->paragraph(),
            'gambar' => null,
            'kategori' => fake()->randomElement(['Web Application', 'Pengolahan Data', 'Company Profile']),
            'teknologi' => 'Laravel, MySQL, Tailwind CSS',
            'peran' => 'Full-stack Developer',
            'tahun' => fake()->numberBetween(2020, (int) date('Y')),
            'urutan' => fake()->numberBetween(1, 10),
            'status' => Project::STATUS_TAMPIL,
        ];
    }

    /**
     * Proyek yang boleh tampil di halaman publik.
     */
    public function tampil(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Project::STATUS_TAMPIL,
        ]);
    }

    /**
     * Proyek yang belum ditampilkan.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Project::STATUS_DRAFT,
        ]);
    }
}
