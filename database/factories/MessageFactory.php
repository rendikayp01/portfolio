<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Message>
 */
class MessageFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->safeEmail(),
            'pesan' => fake()->paragraph(),
            'sudah_dibaca' => false,
        ];
    }

    /**
     * Pesan yang sudah dibaca admin.
     */
    public function sudahDibaca(): static
    {
        return $this->state(fn (array $attributes): array => [
            'sudah_dibaca' => true,
        ]);
    }
}
