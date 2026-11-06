<x-admin-layout
    title="Pengalaman / CV"
    heading="Pengalaman / CV"
    description="Kelola riwayat pendidikan, pengalaman kerja, dan sertifikat."
>
    <x-slot:actions>
        <a
            href="{{ route('admin.experiences.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span class="hidden sm:inline">Tambah riwayat</span>
            <span class="sm:hidden">Tambah</span>
        </a>
    </x-slot:actions>

    <div class="space-y-5">
        <form method="GET" action="{{ route('admin.experiences.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="q" class="block text-sm font-medium text-slate-700">Cari riwayat</label>
                    <input
                        id="q"
                        name="q"
                        type="search"
                        value="{{ $search }}"
                        placeholder="Cari judul atau institusi…"
                        class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand"
                    >
                </div>

                <div class="sm:w-56">
                    <label for="tipe" class="block text-sm font-medium text-slate-700">Tipe</label>
                    <select
                        id="tipe"
                        name="tipe"
                        class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition focus:border-brand focus:ring-brand"
                    >
                        <option value="">Semua tipe</option>
                        @foreach ($tipeLabels as $value => $label)
                            <option value="{{ $value }}" @selected($tipe === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <x-primary-button>Terapkan</x-primary-button>

                    @if ($search !== '' || $tipe !== '')
                        <a
                            href="{{ route('admin.experiences.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
                        >
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 px-4 py-3 sm:px-5">
                <p class="text-sm text-muted">
                    Menampilkan
                    <span class="font-semibold text-ink">{{ $experiences->firstItem() ?? 0 }}–{{ $experiences->lastItem() ?? 0 }}</span>
                    dari <span class="font-semibold text-ink">{{ $experiences->total() }}</span> riwayat
                </p>

                @if ($search !== '' || $tipe !== '')
                    <p class="text-xs text-muted">
                        Filter aktif:
                        @if ($search !== '')
                            <span class="font-medium text-ink">“{{ $search }}”</span>
                        @endif
                        @if ($tipe !== '')
                            <span class="font-medium text-ink">{{ $tipeLabels[$tipe] ?? $tipe }}</span>
                        @endif
                    </p>
                @endif
            </div>

            @if ($experiences->isEmpty())
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>
                    <h3 class="mt-3 text-sm font-semibold text-ink">
                        {{ $search !== '' || $tipe !== '' ? 'Tidak ada riwayat yang cocok' : 'Belum ada riwayat' }}
                    </h3>
                    <p class="mt-1 text-sm text-muted">
                        {{ $search !== '' || $tipe !== '' ? 'Coba ubah kata kunci atau filter tipe.' : 'Tambahkan pendidikan, pengalaman, atau sertifikat pertama Anda.' }}
                    </p>
                    @if ($search === '' && $tipe === '')
                        <a
                            href="{{ route('admin.experiences.create') }}"
                            class="mt-5 inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah riwayat
                        </a>
                    @endif
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 sm:px-5">Riwayat</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Tipe</th>
                                <th scope="col" class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 sm:table-cell">Periode</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 sm:px-5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($experiences as $experience)
                                <tr class="transition hover:bg-slate-50/60">
                                    <td class="px-4 py-3 sm:px-5">
                                        <p class="font-semibold text-ink">{{ $experience->judul }}</p>
                                        <p class="mt-0.5 text-xs text-muted">{{ $experience->institusi }}</p>
                                        <p class="mt-0.5 text-xs text-muted sm:hidden">{{ $experience->periodeLabel() }}</p>
                                    </td>

                                    <td class="px-4 py-3">
                                        @php
                                            $badge = match ($experience->tipe) {
                                                \App\Models\Experience::TIPE_PENDIDIKAN => 'bg-sky-50 text-sky-700 ring-sky-200',
                                                \App\Models\Experience::TIPE_PENGALAMAN => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                                                default => 'bg-amber-50 text-amber-700 ring-amber-200',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $badge }}">
                                            {{ $experience->tipeLabel() }}
                                        </span>
                                    </td>

                                    <td class="hidden px-4 py-3 text-slate-600 sm:table-cell">
                                        {{ $experience->periodeLabel() }}
                                    </td>

                                    <td class="px-4 py-3 sm:px-5">
                                        <div class="flex items-center justify-end gap-2">
                                            <a
                                                href="{{ route('admin.experiences.edit', $experience) }}"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-brand/40 hover:bg-brand/5 hover:text-brand-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
                                            >
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                                </svg>
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.experiences.destroy', $experience) }}"
                                                onsubmit="return confirm('Hapus riwayat “{{ $experience->judul }}”?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-white px-3 py-1.5 text-xs font-semibold text-red-600 shadow-sm transition hover:border-red-300 hover:bg-red-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2"
                                                >
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($experiences->hasPages())
                    <div class="border-t border-slate-100 px-4 py-3 sm:px-5">
                        {{ $experiences->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-admin-layout>
