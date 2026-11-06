<x-admin-layout
    title="Proyek"
    heading="Proyek"
    description="Kelola daftar proyek yang tampil di website portofolio."
>
    <x-slot:actions>
        <a
            href="{{ route('admin.projects.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span class="hidden sm:inline">Tambah proyek</span>
            <span class="sm:hidden">Tambah</span>
        </a>
    </x-slot:actions>

    <div class="space-y-5">
        <form method="GET" action="{{ route('admin.projects.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="q" class="block text-sm font-medium text-slate-700">Cari proyek</label>
                    <input
                        id="q"
                        name="q"
                        type="search"
                        value="{{ $search }}"
                        placeholder="Cari berdasarkan judul…"
                        class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand"
                    >
                </div>

                <div class="sm:w-48">
                    <label for="status" class="block text-sm font-medium text-slate-700">Status</label>
                    <select
                        id="status"
                        name="status"
                        class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition focus:border-brand focus:ring-brand"
                    >
                        <option value="">Semua status</option>
                        @foreach ($statusLabels as $value => $label)
                            <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <x-primary-button>Terapkan</x-primary-button>

                    @if ($search !== '' || $status !== '')
                        <a
                            href="{{ route('admin.projects.index') }}"
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
                    <span class="font-semibold text-ink">{{ $projects->firstItem() ?? 0 }}–{{ $projects->lastItem() ?? 0 }}</span>
                    dari <span class="font-semibold text-ink">{{ $projects->total() }}</span> proyek
                </p>

                @if ($search !== '' || $status !== '')
                    <p class="text-xs text-muted">
                        Filter aktif:
                        @if ($search !== '')
                            <span class="font-medium text-ink">“{{ $search }}”</span>
                        @endif
                        @if ($status !== '')
                            <span class="font-medium text-ink">{{ $statusLabels[$status] ?? $status }}</span>
                        @endif
                    </p>
                @endif
            </div>

            @if ($projects->isEmpty())
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                    </svg>
                    <h3 class="mt-3 text-sm font-semibold text-ink">
                        {{ $search !== '' || $status !== '' ? 'Tidak ada proyek yang cocok' : 'Belum ada proyek' }}
                    </h3>
                    <p class="mt-1 text-sm text-muted">
                        {{ $search !== '' || $status !== '' ? 'Coba ubah kata kunci atau filter status.' : 'Tambahkan proyek pertama Anda untuk mulai mengisi portofolio.' }}
                    </p>
                    @if ($search === '' && $status === '')
                        <a
                            href="{{ route('admin.projects.create') }}"
                            class="mt-5 inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah proyek
                        </a>
                    @endif
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 sm:px-5">Proyek</th>
                                <th scope="col" class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 md:table-cell">Kategori</th>
                                <th scope="col" class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 sm:table-cell">Tahun</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                                <th scope="col" class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:table-cell">Urutan</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 sm:px-5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($projects as $project)
                                <tr class="transition hover:bg-slate-50/60">
                                    <td class="px-4 py-3 sm:px-5">
                                        <div class="flex items-center gap-3">
                                            <div class="h-14 w-20 shrink-0 overflow-hidden rounded-lg border border-slate-200 bg-slate-100">
                                                @if ($project->gambarUrl())
                                                    <img
                                                        src="{{ $project->gambarUrl() }}"
                                                        alt="Gambar {{ $project->judul }}"
                                                        class="h-full w-full object-cover"
                                                        loading="lazy"
                                                    >
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center text-slate-400">
                                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="min-w-0">
                                                <p class="max-w-xs truncate font-semibold text-ink">{{ $project->judul }}</p>
                                                <p class="mt-0.5 max-w-xs truncate text-xs text-muted">/{{ $project->slug }}</p>
                                                <p class="mt-0.5 text-xs text-muted md:hidden">{{ $project->kategori }} · {{ $project->tahun }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="hidden px-4 py-3 md:table-cell">
                                        <span class="text-slate-600">{{ $project->kategori }}</span>
                                    </td>

                                    <td class="hidden px-4 py-3 text-slate-600 sm:table-cell">
                                        {{ $project->tahun }}
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($project->isTampil())
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>
                                                Tampil
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400" aria-hidden="true"></span>
                                                Draft
                                            </span>
                                        @endif
                                    </td>

                                    <td class="hidden px-4 py-3 text-slate-600 lg:table-cell">
                                        {{ $project->urutan }}
                                    </td>

                                    <td class="px-4 py-3 sm:px-5">
                                        <div class="flex items-center justify-end gap-2">
                                            <a
                                                href="{{ route('admin.projects.edit', $project) }}"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-brand/40 hover:bg-brand/5 hover:text-brand-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
                                            >
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                                </svg>
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.projects.destroy', $project) }}"
                                                onsubmit="return confirm('Hapus proyek “{{ $project->judul }}”? Tindakan ini tidak dapat dibatalkan.');"
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

                @if ($projects->hasPages())
                    <div class="border-t border-slate-100 px-4 py-3 sm:px-5">
                        {{ $projects->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-admin-layout>
