<x-admin-layout
    title="Keahlian"
    heading="Keahlian"
    description="Kelola daftar keahlian yang dikelompokkan berdasarkan kategori."
>
    <x-slot:actions>
        <a
            href="{{ route('admin.skills.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span class="hidden sm:inline">Tambah keahlian</span>
            <span class="sm:hidden">Tambah</span>
        </a>
    </x-slot:actions>

    <div class="space-y-5">
        <form method="GET" action="{{ route('admin.skills.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="q" class="block text-sm font-medium text-slate-700">Cari keahlian</label>
                    <input
                        id="q"
                        name="q"
                        type="search"
                        value="{{ $search }}"
                        placeholder="Cari nama atau deskripsi…"
                        class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand"
                    >
                </div>

                <div class="sm:w-64">
                    <label for="kategori" class="block text-sm font-medium text-slate-700">Kategori</label>
                    <select
                        id="kategori"
                        name="kategori"
                        class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition focus:border-brand focus:ring-brand"
                    >
                        <option value="">Semua kategori</option>
                        @foreach ($kategoriLabels as $value => $label)
                            <option value="{{ $value }}" @selected($kategori === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <x-primary-button>Terapkan</x-primary-button>

                    @if ($search !== '' || $kategori !== '')
                        <a
                            href="{{ route('admin.skills.index') }}"
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
                    <span class="font-semibold text-ink">{{ $skills->firstItem() ?? 0 }}–{{ $skills->lastItem() ?? 0 }}</span>
                    dari <span class="font-semibold text-ink">{{ $skills->total() }}</span> keahlian
                </p>

                @if ($search !== '' || $kategori !== '')
                    <p class="text-xs text-muted">
                        Filter aktif:
                        @if ($search !== '')
                            <span class="font-medium text-ink">“{{ $search }}”</span>
                        @endif
                        @if ($kategori !== '')
                            <span class="font-medium text-ink">{{ $kategoriLabels[$kategori] ?? $kategori }}</span>
                        @endif
                    </p>
                @endif
            </div>

            @if ($skills->isEmpty())
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                    </svg>
                    <h3 class="mt-3 text-sm font-semibold text-ink">
                        {{ $search !== '' || $kategori !== '' ? 'Tidak ada keahlian yang cocok' : 'Belum ada keahlian' }}
                    </h3>
                    <p class="mt-1 text-sm text-muted">
                        {{ $search !== '' || $kategori !== '' ? 'Coba ubah kata kunci atau filter kategori.' : 'Tambahkan keahlian pertama Anda.' }}
                    </p>
                    @if ($search === '' && $kategori === '')
                        <a
                            href="{{ route('admin.skills.create') }}"
                            class="mt-5 inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah keahlian
                        </a>
                    @endif
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 sm:px-5">Keahlian</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Kategori</th>
                                <th scope="col" class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 sm:table-cell">Urutan</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 sm:px-5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($skills as $skill)
                                <tr class="transition hover:bg-slate-50/60">
                                    <td class="px-4 py-3 sm:px-5">
                                        <p class="font-semibold text-ink">{{ $skill->nama }}</p>
                                        <p class="mt-0.5 max-w-xl text-xs text-muted">{{ $skill->deskripsi }}</p>
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($skill->kategori === \App\Models\Skill::KATEGORI_WEB)
                                            <span class="inline-flex items-center rounded-full bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700 ring-1 ring-inset ring-sky-200">
                                                Web Development
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-200">
                                                Administrasi
                                            </span>
                                        @endif
                                    </td>

                                    <td class="hidden px-4 py-3 text-slate-600 sm:table-cell">
                                        {{ $skill->urutan }}
                                    </td>

                                    <td class="px-4 py-3 sm:px-5">
                                        <div class="flex items-center justify-end gap-2">
                                            <a
                                                href="{{ route('admin.skills.edit', $skill) }}"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-brand/40 hover:bg-brand/5 hover:text-brand-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
                                            >
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                                </svg>
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.skills.destroy', $skill) }}"
                                                onsubmit="return confirm('Hapus keahlian “{{ $skill->nama }}”?');"
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

                @if ($skills->hasPages())
                    <div class="border-t border-slate-100 px-4 py-3 sm:px-5">
                        {{ $skills->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-admin-layout>
