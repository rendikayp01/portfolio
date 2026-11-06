<?php

namespace App\Http\Requests\Admin;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    /**
     * Hanya admin yang sudah login yang boleh mengirim formulir.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:150'],
            'ringkasan' => ['required', 'string', 'max:300'],
            'deskripsi_masalah' => ['required', 'string'],
            'deskripsi_solusi' => ['required', 'string'],
            'deskripsi_hasil' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'kategori' => ['required', 'string', 'max:100'],
            'teknologi' => ['required', 'string', 'max:200'],
            'peran' => ['required', 'string', 'max:100'],
            'tahun' => ['required', 'integer', 'between:2000,'.(now()->year + 1)],
            'urutan' => ['required', 'integer', 'min:0', 'max:9999'],
            'status' => ['required', 'string', Rule::in(array_keys(Project::statusLabels()))],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'judul.required' => 'Judul proyek wajib diisi.',
            'judul.max' => 'Judul proyek maksimal 150 karakter.',
            'ringkasan.required' => 'Ringkasan proyek wajib diisi.',
            'ringkasan.max' => 'Ringkasan proyek maksimal 300 karakter.',
            'deskripsi_masalah.required' => 'Bagian masalah wajib diisi.',
            'deskripsi_solusi.required' => 'Bagian solusi wajib diisi.',
            'deskripsi_hasil.required' => 'Bagian hasil wajib diisi.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WebP.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
            'gambar.uploaded' => 'Gambar gagal diunggah. Silakan coba lagi.',
            'kategori.required' => 'Kategori proyek wajib diisi.',
            'kategori.max' => 'Kategori proyek maksimal 100 karakter.',
            'teknologi.required' => 'Teknologi yang digunakan wajib diisi.',
            'teknologi.max' => 'Teknologi maksimal 200 karakter.',
            'peran.required' => 'Peran Anda dalam proyek wajib diisi.',
            'peran.max' => 'Peran maksimal 100 karakter.',
            'tahun.required' => 'Tahun proyek wajib diisi.',
            'tahun.integer' => 'Tahun proyek harus berupa angka.',
            'tahun.between' => 'Tahun proyek harus berada di antara :min dan :max.',
            'urutan.required' => 'Urutan tampil wajib diisi.',
            'urutan.integer' => 'Urutan tampil harus berupa angka.',
            'urutan.min' => 'Urutan tampil tidak boleh negatif.',
            'status.required' => 'Status proyek wajib dipilih.',
            'status.in' => 'Status proyek tidak valid.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'judul' => 'judul proyek',
            'ringkasan' => 'ringkasan',
            'deskripsi_masalah' => 'masalah',
            'deskripsi_solusi' => 'solusi',
            'deskripsi_hasil' => 'hasil',
            'gambar' => 'gambar proyek',
            'kategori' => 'kategori',
            'teknologi' => 'teknologi',
            'peran' => 'peran',
            'tahun' => 'tahun',
            'urutan' => 'urutan tampil',
            'status' => 'status',
        ];
    }
}
