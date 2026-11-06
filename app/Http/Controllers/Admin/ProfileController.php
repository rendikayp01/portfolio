<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Formulir profil pemilik portofolio.
     */
    public function edit(): View
    {
        return view('admin.profile.edit', [
            'profile' => Profile::current(),
        ]);
    }

    public function update(ProfileRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $profile = Profile::current();
        $oldPhoto = $profile?->foto;

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->uploadPhoto($request->file('foto'));
        }

        if ($profile) {
            $profile->update($data);
        } else {
            $profile = Profile::create($data);
        }

        if (isset($data['foto'])) {
            $this->deletePhoto($oldPhoto);
        }

        return to_route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Simpan foto profil ke disk publik dan kembalikan path-nya.
     */
    private function uploadPhoto(?UploadedFile $photo): ?string
    {
        if (! $photo) {
            return null;
        }

        $path = $photo->store('profile', 'public');

        if ($path === false) {
            throw ValidationException::withMessages([
                'foto' => 'Foto gagal diunggah. Silakan coba lagi.',
            ]);
        }

        return $path;
    }

    /**
     * Hapus foto profil lama dari disk publik.
     */
    private function deletePhoto(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
