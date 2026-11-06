<?php

namespace App\Http\Requests\Admin;

use App\Models\Experience;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExperienceRequest extends FormRequest
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
        $maxTahun = now()->year + 1;

        return [
            'tipe' => ['required', 'string', Rule::in(array_keys(Experience::tipeLabels()))],
            'judul' => ['required', 'string', 'max:150'],
            'institusi' => ['required', 'string', 'max:150'],
            'tahun_mulai' => ['required', 'integer', 'between:1950,'.$maxTahun],
            'tahun_selesai' => [
                'required_unless:tipe,'.Experience::TIPE_SERTIFIKAT,
                'nullable',
                'integer',
                'between:1950,'.$maxTahun,
                'gte:tahun_mulai',
            ],
            'deskripsi' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tipe.required' => 'Tipe riwayat wajib dipilih.',
            'tipe.in' => 'Tipe riwayat tidak valid.',
            'judul.required' => 'Judul wajib diisi.',
            'judul.max' => 'Judul maksimal 150 karakter.',
            'institusi.required' => 'Nama institusi wajib diisi.',
            'institusi.max' => 'Nama institusi maksimal 150 karakter.',
            'tahun_mulai.required' => 'Tahun mulai wajib diisi.',
            'tahun_mulai.integer' => 'Tahun mulai harus berupa angka.',
            'tahun_mulai.between' => 'Tahun mulai harus berada di antara :min dan :max.',
            'tahun_selesai.required_unless' => 'Tahun selesai wajib diisi untuk pendidikan dan pengalaman.',
            'tahun_selesai.integer' => 'Tahun selesai harus berupa angka.',
            'tahun_selesai.between' => 'Tahun selesai harus berada di antara :min dan :max.',
            'tahun_selesai.gte' => 'Tahun selesai tidak boleh lebih awal dari tahun mulai.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'tipe' => 'tipe riwayat',
            'judul' => 'judul',
            'institusi' => 'institusi',
            'tahun_mulai' => 'tahun mulai',
            'tahun_selesai' => 'tahun selesai',
            'deskripsi' => 'deskripsi',
        ];
    }
}
