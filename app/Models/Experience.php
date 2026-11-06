<?php

namespace App\Models;

use Database\Factories\ExperienceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'tipe',
    'judul',
    'institusi',
    'tahun_mulai',
    'tahun_selesai',
    'deskripsi',
])]
class Experience extends Model
{
    /** @use HasFactory<ExperienceFactory> */
    use HasFactory;

    public const TIPE_PENDIDIKAN = 'pendidikan';

    public const TIPE_PENGALAMAN = 'pengalaman';

    public const TIPE_SERTIFIKAT = 'sertifikat';

    /**
     * @return array<string, string>
     */
    public static function tipeLabels(): array
    {
        return [
            self::TIPE_PENDIDIKAN => 'Pendidikan',
            self::TIPE_PENGALAMAN => 'Pengalaman',
            self::TIPE_SERTIFIKAT => 'Sertifikat',
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tahun_mulai' => 'integer',
            'tahun_selesai' => 'integer',
        ];
    }

    public function tipeLabel(): string
    {
        return self::tipeLabels()[$this->tipe] ?? ucfirst($this->tipe);
    }

    /**
     * Format periode untuk timeline CV.
     */
    public function periodeLabel(): string
    {
        if ($this->tipe === self::TIPE_SERTIFIKAT) {
            return (string) $this->tahun_mulai;
        }

        return $this->tahun_selesai
            ? "{$this->tahun_mulai} – {$this->tahun_selesai}"
            : "{$this->tahun_mulai} – Sekarang";
    }

    public function scopeTipe(Builder $query, string $tipe): Builder
    {
        return $query->where('tipe', $tipe);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('tahun_mulai')->orderByDesc('id');
    }
}
