<?php

namespace App\Http\Requests\Admin;

use App\Models\Profile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
        $profileId = Profile::current()?->id;

        return [
            'nama' => ['required', 'string', 'max:120'],
            'headline' => ['required', 'string', 'max:180'],
            'bio' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'email' => [
                'required',
                'string',
                'email',
                'max:150',
                Rule::unique('profiles', 'email')->ignore($profileId),
            ],
            'no_wa' => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]+$/'],
            'link_linkedin' => ['nullable', 'url', 'max:255'],
            'link_github' => ['nullable', 'url', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.max' => 'Nama lengkap maksimal 120 karakter.',
            'headline.required' => 'Headline wajib diisi.',
            'headline.max' => 'Headline maksimal 180 karakter.',
            'bio.required' => 'Bio wajib diisi.',
            'foto.image' => 'File yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WebP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
            'foto.uploaded' => 'Foto gagal diunggah. Silakan coba lagi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 150 karakter.',
            'email.unique' => 'Email tersebut sudah dipakai.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'no_wa.max' => 'Nomor WhatsApp maksimal 30 karakter.',
            'no_wa.regex' => 'Nomor WhatsApp hanya boleh berisi angka, spasi, tanda hubung, tanda kurung, dan tanda plus.',
            'link_linkedin.url' => 'Tautan LinkedIn harus berupa URL yang valid.',
            'link_linkedin.max' => 'Tautan LinkedIn maksimal 255 karakter.',
            'link_github.url' => 'Tautan GitHub harus berupa URL yang valid.',
            'link_github.max' => 'Tautan GitHub maksimal 255 karakter.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nama' => 'nama lengkap',
            'headline' => 'headline',
            'bio' => 'bio',
            'foto' => 'foto profil',
            'email' => 'email',
            'no_wa' => 'nomor WhatsApp',
            'link_linkedin' => 'tautan LinkedIn',
            'link_github' => 'tautan GitHub',
        ];
    }
}
