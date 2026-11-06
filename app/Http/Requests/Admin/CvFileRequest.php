<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CvFileRequest extends FormRequest
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
            'file_pdf' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'file_pdf.required' => 'File CV wajib dipilih.',
            'file_pdf.file' => 'File CV gagal diunggah. Silakan coba lagi.',
            'file_pdf.mimes' => 'File CV harus berformat PDF.',
            'file_pdf.max' => 'Ukuran file CV maksimal 5 MB.',
            'file_pdf.uploaded' => 'File CV gagal diunggah. Silakan coba lagi.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'file_pdf' => 'file CV',
        ];
    }
}
