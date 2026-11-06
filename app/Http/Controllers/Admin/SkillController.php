<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SkillRequest;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillController extends Controller
{
    /**
     * Daftar keahlian dengan pencarian, filter kategori, dan pagination.
     */
    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();
        $kategoriLabels = Skill::kategoriLabels();
        $kategori = $request->string('kategori')->toString();

        if (! array_key_exists($kategori, $kategoriLabels)) {
            $kategori = '';
        }

        $skills = Skill::query()
            ->when($search !== '', fn (Builder $query): Builder => $query->where(function (Builder $query) use ($search): void {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            }))
            ->when($kategori !== '', fn (Builder $query): Builder => $query->kategori($kategori))
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        return view('admin.skills.index', compact('skills', 'search', 'kategori', 'kategoriLabels'));
    }

    public function create(): View
    {
        return view('admin.skills.create', [
            'kategoriLabels' => Skill::kategoriLabels(),
        ]);
    }

    public function store(SkillRequest $request): RedirectResponse
    {
        Skill::create($request->validated());

        return to_route('admin.skills.index')
            ->with('success', 'Keahlian berhasil ditambahkan.');
    }

    public function edit(Skill $skill): View
    {
        return view('admin.skills.edit', [
            'skill' => $skill,
            'kategoriLabels' => Skill::kategoriLabels(),
        ]);
    }

    public function update(SkillRequest $request, Skill $skill): RedirectResponse
    {
        $skill->update($request->validated());

        return to_route('admin.skills.index')
            ->with('success', 'Keahlian berhasil diperbarui.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return to_route('admin.skills.index')
            ->with('success', 'Keahlian berhasil dihapus.');
    }
}
