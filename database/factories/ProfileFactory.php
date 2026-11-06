<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'headline' => 'Web Developer · Pengolahan Data & Administrasi',
            'bio' => fake()->paragraphs(2, true),
            'foto' => null,
            'email' => fake()->unique()->safeEmail(),
            'no_wa' => '08'.fake()->numerify('##########'),
            'link_linkedin' => 'https://www.linkedin.com/in/'.fake()->userName(),
            'link_github' => 'https://github.com/'.fake()->userName(),
        ];
    }
}
