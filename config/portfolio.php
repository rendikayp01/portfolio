<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Akun Admin
    |--------------------------------------------------------------------------
    | Kredensial dibaca dari .env agar tidak ada data sensitif di dalam kode.
    | Akun ini dibuat oleh database/seeders/AdminUserSeeder.php.
    */
    'admin' => [
        'name' => env('ADMIN_NAME', 'Administrator'),
        'email' => env('ADMIN_EMAIL'),
        'password' => env('ADMIN_PASSWORD'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Warna Brand
    |--------------------------------------------------------------------------
    | Nilai ini juga dipakai oleh Tailwind di resources/css/app.css.
    */
    'brand' => [
        'accent' => '#0F766E',
        'background' => '#FAFAF9',
        'text' => '#0F172A',
    ],
];
