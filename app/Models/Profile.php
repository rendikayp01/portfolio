<?php

namespace App\Models;

use Database\Factories\ProfileFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Fillable([
    'nama',
    'headline',
    'bio',
    'foto',
    'email',
    'no_wa',
    'link_linkedin',
    'link_github',
])]
class Profile extends Model
{
    /** @use HasFactory<ProfileFactory> */
    use HasFactory;

    /**
     * Ambil profil utama. Aplikasi ini hanya memakai satu profil.
     */
    public static function current(): ?self
    {
        return static::query()->oldest('id')->first();
    }

    /**
     * URL foto profil dari disk publik.
     */
    public function fotoUrl(): ?string
    {
        return $this->foto
            ? Storage::disk('public')->url($this->foto)
            : null;
    }

    /**
     * Tautan WhatsApp dalam format internasional.
     */
    public function whatsappUrl(): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $this->no_wa);

        if (! $digits) {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        return 'https://wa.me/'.$digits;
    }

    /**
     * Inisial nama untuk avatar cadangan.
     */
    public function inisial(): string
    {
        $words = preg_split('/\s+/', trim((string) $this->nama)) ?: [];
        $initials = '';

        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= Str::upper(Str::substr($word, 0, 1));
        }

        return $initials !== '' ? $initials : 'P';
    }
}
