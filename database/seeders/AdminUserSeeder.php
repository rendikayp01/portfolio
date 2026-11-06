<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    /**
     * Membuat satu akun admin dari nilai ADMIN_* di .env.
     */
    public function run(): void
    {
        $name = config('portfolio.admin.name');
        $email = config('portfolio.admin.email');
        $password = config('portfolio.admin.password');

        if (blank($email) || blank($password)) {
            throw new RuntimeException(
                'ADMIN_EMAIL dan ADMIN_PASSWORD wajib diisi di .env sebelum menjalankan seeder.'
            );
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => $password,
            ],
        );
    }
}
