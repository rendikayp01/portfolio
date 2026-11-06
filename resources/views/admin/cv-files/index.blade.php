<x-admin-layout
    title="File CV"
    heading="File CV"
    description="Unggah dan kelola file CV PDF yang dapat diunduh pengunjung."
>
    <div class="space-y-5">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-base font-semibold text-ink">Unggah file CV</h2>
                <p class="mt-1 text-sm text-muted">File harus berformat PDF dengan ukuran maksimal 5 MB.</p>
            </div>

            <form method="POST" action="{{ route('admin.cv-files.store') }}" enctype="multipart/form-data" class="mt-5">
                @csrf

                <div class="flex flex-col gap-3 sm:flex-row sm:items-start">
                    <div class="flex-1">
                        <x-input-label for="file_pdf" value="File PDF" />
                        <input
                            id="file_pdf"
                            name="file_pdf"
                            type="file"
                            accept="application/pdf"
                            required
                            class="mt-1.5 block w-full cursor-pointer rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-brand/10 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-brand-dark hover:file:bg-brand/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand"
                        >
                        <x-input-error :messages="$errors->get('file_pdf')" class="mt-1.5" />
                    </div>

                    <div class="sm:pt-7">
                        <x-primary-button>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Unggah file
                        </x-primary-button>
                    </div>
                </div>

                <p class="mt-3 text-xs text-muted">
                    File pertama yang diunggah akan otomatis aktif. Hanya satu file CV yang aktif pada satu waktu.
                </p>
            </form>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 px-4 py-3 sm:px-5">
                <p class="text-sm text-muted">
                    <span class="font-semibold text-ink">{{ $cvFiles->total() }}</span> file CV tersimpan
                </p>
                <p class="text-xs text-muted">Hanya file aktif yang dipakai di website.</p>
            </div>

            @if ($cvFiles->isEmpty())
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <h3 class="mt-3 text-sm font-semibold text-ink">Belum ada file CV</h3>
                    <p class="mt-1 text-sm text-muted">Unggah file PDF melalui formulir di atas.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 sm:px-5">File</th>
                                <th scope="col" class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 md:table-cell">Diunggah</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 sm:px-5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($cvFiles as $cvFile)
                                <tr class="transition hover:bg-slate-50/60">
                                    <td class="px-4 py-3 sm:px-5">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600 ring-1 ring-inset ring-red-100">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                </svg>
                                            </span>
                                            <div class="min-w-0">
                                                <p class="max-w-xs truncate font-semibold text-ink">{{ $cvFile->namaFile() }}</p>
                                                <p class="mt-0.5 text-xs text-muted">{{ $cvFile->file_pdf }}</p>
                                                <p class="mt-0.5 text-xs text-muted md:hidden">{{ $cvFile->created_at->format('d M Y, H:i') }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="hidden px-4 py-3 text-slate-600 md:table-cell">
                                        {{ $cvFile->created_at->format('d M Y, H:i') }}
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($cvFile->aktif)
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-200">
                                                Tidak aktif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 sm:px-5">
                                        <div class="flex items-center justify-end gap-2">
                                            <a
                                                href="{{ $cvFile->url() }}"
                                                target="_blank"
                                                rel="noopener"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-brand/40 hover:bg-brand/5 hover:text-brand-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
                                            >
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                                </svg>
                                                Lihat
                                            </a>

                                            @unless ($cvFile->aktif)
                                                <form method="POST" action="{{ route('admin.cv-files.activate', $cvFile) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center gap-1.5 rounded-lg border border-brand/30 bg-brand/5 px-3 py-1.5 text-xs font-semibold text-brand-dark shadow-sm transition hover:bg-brand/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
                                                    >
                                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                                        </svg>
                                                        Aktifkan
                                                    </button>
                                                </form>
                                            @endunless

                                            <form
                                                method="POST"
                                                action="{{ route('admin.cv-files.destroy', $cvFile) }}"
                                                onsubmit="return confirm('Hapus file {{ $cvFile->namaFile() }}?{{ $cvFile->aktif ? ' File ini sedang aktif dan website tidak akan memiliki CV sampai file lain diaktifkan.' : '' }}');"
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

                @if ($cvFiles->hasPages())
                    <div class="border-t border-slate-100 px-4 py-3 sm:px-5">
                        {{ $cvFiles->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-admin-layout>
