<?php

namespace App\Http\Requests\Admin;

use App\Models\Skill;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SkillRequest extends FormRequest
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
            'nama' => ['required', 'string', 'max:100'],
            'deskripsi' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', Rule::in(array_keys(Skill::kategoriLabels()))],
            'urutan' => ['required', 'integer', 'min:0', 'max:9999'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama keahlian wajib diisi.',
            'nama.max' => 'Nama keahlian maksimal 100 karakter.',
            'deskripsi.required' => 'Deskripsi keahlian wajib diisi.',
            'deskripsi.max' => 'Deskripsi keahlian maksimal 255 karakter.',
            'kategori.required' => 'Kategori keahlian wajib dipilih.',
            'kategori.in' => 'Kategori keahlian tidak valid.',
            'urutan.required' => 'Urutan tampil wajib diisi.',
            'urutan.integer' => 'Urutan tampil harus berupa angka.',
            'urutan.min' => 'Urutan tampil tidak boleh negatif.',
            'urutan.max' => 'Urutan tampil maksimal 9999.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nama' => 'nama keahlian',
            'deskripsi' => 'deskripsi',
            'kategori' => 'kategori',
            'urutan' => 'urutan tampil',
        ];
    }
}
