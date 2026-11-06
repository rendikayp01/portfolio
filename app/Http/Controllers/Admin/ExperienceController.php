<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExperienceRequest;
use App\Models\Experience;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    /**
     * Daftar riwayat pendidikan, pengalaman, dan sertifikat.
     */
    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();
        $tipeLabels = Experience::tipeLabels();
        $tipe = $request->string('tipe')->toString();

        if (! array_key_exists($tipe, $tipeLabels)) {
            $tipe = '';
        }

        $experiences = Experience::query()
            ->when($search !== '', fn (Builder $query): Builder => $query->where(function (Builder $query) use ($search): void {
                $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('institusi', 'like', "%{$search}%");
            }))
            ->when($tipe !== '', fn (Builder $query): Builder => $query->tipe($tipe))
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        return view('admin.experiences.index', compact('experiences', 'search', 'tipe', 'tipeLabels'));
    }

    public function create(): View
    {
        return view('admin.experiences.create', [
            'tipeLabels' => Experience::tipeLabels(),
        ]);
    }

    public function store(ExperienceRequest $request): RedirectResponse
    {
        Experience::create($this->payload($request));

        return to_route('admin.experiences.index')
            ->with('success', 'Riwayat berhasil ditambahkan.');
    }

    public function edit(Experience $experience): View
    {
        return view('admin.experiences.edit', [
            'experience' => $experience,
            'tipeLabels' => Experience::tipeLabels(),
        ]);
    }

    public function update(ExperienceRequest $request, Experience $experience): RedirectResponse
    {
        $experience->update($this->payload($request));

        return to_route('admin.experiences.index')
            ->with('success', 'Riwayat berhasil diperbarui.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $experience->delete();

        return to_route('admin.experiences.index')
            ->with('success', 'Riwayat berhasil dihapus.');
    }

    /**
     * Tahun selesai selalu kosong untuk sertifikat.
     *
     * @return array<string, mixed>
     */
    private function payload(ExperienceRequest $request): array
    {
        $data = $request->validated();

        if ($data['tipe'] === Experience::TIPE_SERTIFIKAT) {
            $data['tahun_selesai'] = null;
        }

        return $data;
    }
}
