<?php

namespace App\Models;

use Database\Factories\CvFileFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable(['file_pdf', 'aktif'])]
class CvFile extends Model
{
    /** @use HasFactory<CvFileFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }

    /**
     * Pastikan hanya ada satu file CV yang aktif.
     */
    protected static function booted(): void
    {
        static::saved(function (self $cvFile): void {
            if ($cvFile->aktif) {
                static::query()
                    ->whereKeyNot($cvFile->getKey())
                    ->where('aktif', true)
                    ->update(['aktif' => false]);
            }
        });
    }

    public static function current(): ?self
    {
        return static::query()->where('aktif', true)->latest('id')->first();
    }

    /**
     * URL file PDF dari disk publik.
     */
    public function url(): string
    {
        return Storage::disk('public')->url($this->file_pdf);
    }

    /**
     * Nama file yang ditampilkan di daftar admin.
     */
    public function namaFile(): string
    {
        return basename($this->file_pdf);
    }

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('aktif', true);
    }
}
