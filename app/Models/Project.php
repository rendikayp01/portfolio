<?php

namespace App\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Fillable([
    'judul',
    'slug',
    'ringkasan',
    'deskripsi_masalah',
    'deskripsi_solusi',
    'deskripsi_hasil',
    'gambar',
    'kategori',
    'teknologi',
    'peran',
    'tahun',
    'urutan',
    'status',
])]
class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    public const STATUS_TAMPIL = 'tampil';

    public const STATUS_DRAFT = 'draft';

    /**
     * @return array<string, string>
     */
    public static function statusLabels(): array
    {
        return [
            self::STATUS_TAMPIL => 'Tampil',
            self::STATUS_DRAFT => 'Draft',
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'urutan' => 'integer',
        ];
    }

    /**
     * Gunakan slug untuk route model binding pada halaman detail proyek.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Buat slug unik dari judul proyek.
     */
    public static function generateUniqueSlug(string $judul, ?int $ignoreId = null): string
    {
        $base = Str::slug($judul) ?: 'proyek';
        $slug = $base;
        $suffix = 2;

        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId !== null, fn (Builder $query): Builder => $query->whereKeyNot($ignoreId))
            ->exists()
        ) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    /**
     * URL gambar proyek dari disk publik.
     */
    public function gambarUrl(): ?string
    {
        return $this->gambar
            ? Storage::disk('public')->url($this->gambar)
            : null;
    }

    public function isTampil(): bool
    {
        return $this->status === self::STATUS_TAMPIL;
    }

    public function statusLabel(): string
    {
        return self::statusLabels()[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Teknologi disimpan sebagai teks dipisahkan koma.
     *
     * @return array<int, string>
     */
    public function teknologiList(): array
    {
        return array_values(array_filter(array_map(
            static fn (string $teknologi): string => trim($teknologi),
            explode(',', $this->teknologi),
        )));
    }

    public function scopeTampil(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_TAMPIL);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('urutan')->orderByDesc('tahun')->orderByDesc('id');
    }
}
