<?php

namespace App\Models;

use Database\Factories\SkillFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'deskripsi', 'kategori', 'urutan'])]
class Skill extends Model
{
    /** @use HasFactory<SkillFactory> */
    use HasFactory;

    public const KATEGORI_ADMINISTRASI = 'administrasi';

    public const KATEGORI_WEB = 'web';

    /**
     * Label kategori untuk formulir dan tampilan.
     *
     * @return array<string, string>
     */
    public static function kategoriLabels(): array
    {
        return [
            self::KATEGORI_ADMINISTRASI => 'Administrasi & Pengolahan Data',
            self::KATEGORI_WEB => 'Web Development',
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
        ];
    }

    public function scopeKategori(Builder $query, string $kategori): Builder
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('urutan')->orderBy('id');
    }
}
