<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Skill>
 */
class SkillFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => ucfirst(fake()->unique()->words(2, true)),
            'deskripsi' => fake()->sentence(10),
            'kategori' => fake()->randomElement(array_keys(Skill::kategoriLabels())),
            'urutan' => fake()->numberBetween(1, 10),
        ];
    }
}
