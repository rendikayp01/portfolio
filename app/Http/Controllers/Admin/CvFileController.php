<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CvFileRequest;
use App\Models\CvFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CvFileController extends Controller
{
    /**
     * Daftar file CV beserta status aktifnya.
     */
    public function index(): View
    {
        return view('admin.cv-files.index', [
            'cvFiles' => CvFile::query()->latest('id')->paginate(10),
        ]);
    }

    public function store(CvFileRequest $request): RedirectResponse
    {
        $path = $request->file('file_pdf')->store('cv', 'public');

        if ($path === false) {
            throw ValidationException::withMessages([
                'file_pdf' => 'File CV gagal diunggah. Silakan coba lagi.',
            ]);
        }

        $isFirstFile = ! CvFile::query()->exists();

        CvFile::create([
            'file_pdf' => $path,
            'aktif' => $isFirstFile,
        ]);

        return back()->with(
            'success',
            $isFirstFile
                ? 'File CV berhasil diunggah dan langsung diaktifkan.'
                : 'File CV berhasil diunggah. Aktifkan jika ingin dipakai di website.',
        );
    }

    public function activate(CvFile $cvFile): RedirectResponse
    {
        $cvFile->update(['aktif' => true]);

        return back()->with('success', 'File CV berhasil diaktifkan.');
    }

    public function destroy(CvFile $cvFile): RedirectResponse
    {
        $path = $cvFile->file_pdf;
        $wasActive = $cvFile->aktif;

        $cvFile->delete();
        Storage::disk('public')->delete($path);

        if ($wasActive) {
            CvFile::query()->latest('id')->first()?->update(['aktif' => true]);
        }

        return back()->with('success', 'File CV berhasil dihapus.');
    }
}
