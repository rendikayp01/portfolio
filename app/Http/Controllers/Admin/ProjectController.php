<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Daftar proyek dengan pencarian, filter status, dan pagination.
     */
    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();
        $statusLabels = Project::statusLabels();
        $status = $request->string('status')->toString();

        if (! array_key_exists($status, $statusLabels)) {
            $status = '';
        }

        $projects = Project::query()
            ->when($search !== '', fn (Builder $query): Builder => $query->where('judul', 'like', "%{$search}%"))
            ->when($status !== '', fn (Builder $query): Builder => $query->where('status', $status))
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        return view('admin.projects.index', compact('projects', 'search', 'status', 'statusLabels'));
    }

    public function create(): View
    {
        return view('admin.projects.create');
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = Project::generateUniqueSlug($data['judul']);
        $data['gambar'] = $this->uploadImage($request->file('gambar'));

        Project::create($data);

        return to_route('admin.projects.index')
            ->with('success', 'Proyek berhasil ditambahkan.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $data = $request->validated();
        $oldImage = $project->gambar;

        if ($project->judul !== $data['judul']) {
            $data['slug'] = Project::generateUniqueSlug($data['judul'], $project->id);
        }

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $this->uploadImage($request->file('gambar'));
        }

        $project->update($data);

        if (isset($data['gambar'])) {
            $this->deleteImage($oldImage);
        }

        return to_route('admin.projects.index')
            ->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $image = $project->gambar;

        $project->delete();
        $this->deleteImage($image);

        return to_route('admin.projects.index')
            ->with('success', 'Proyek berhasil dihapus.');
    }

    /**
     * Simpan gambar ke disk publik dan kembalikan path-nya.
     */
    private function uploadImage(?UploadedFile $image): ?string
    {
        if (! $image) {
            return null;
        }

        $path = $image->store('projects', 'public');

        if ($path === false) {
            throw ValidationException::withMessages([
                'gambar' => 'Gambar gagal diunggah. Silakan coba lagi.',
            ]);
        }

        return $path;
    }

    /**
     * Hapus file gambar lama dari disk publik.
     */
    private function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
