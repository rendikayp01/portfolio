<x-admin-layout
    title="Pesan masuk"
    heading="Pesan masuk"
    description="Baca dan kelola pesan yang dikirim melalui formulir kontak website."
>
    <div class="space-y-5">
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-2xl font-extrabold tracking-tight text-ink">{{ $totalCount }}</p>
                        <p class="text-xs font-medium text-muted">Total pesan</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-amber-200 bg-amber-50/60 p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-2xl font-extrabold tracking-tight text-amber-800">{{ $unreadCount }}</p>
                        <p class="text-xs font-medium text-amber-700">Belum dibaca</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-emerald-200 bg-emerald-50/60 p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-2xl font-extrabold tracking-tight text-emerald-800">{{ $totalCount - $unreadCount }}</p>
                        <p class="text-xs font-medium text-emerald-700">Sudah dibaca</p>
                    </div>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('admin.messages.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="q" class="block text-sm font-medium text-slate-700">Cari pesan</label>
                    <input
                        id="q"
                        name="q"
                        type="search"
                        value="{{ $search }}"
                        placeholder="Cari nama, email, atau isi pesan…"
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
                            href="{{ route('admin.messages.index') }}"
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
                    <span class="font-semibold text-ink">{{ $messages->firstItem() ?? 0 }}–{{ $messages->lastItem() ?? 0 }}</span>
                    dari <span class="font-semibold text-ink">{{ $messages->total() }}</span> pesan
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

            @if ($messages->isEmpty())
                <div class="px-6 py-16 text-center">
                    <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                    <h3 class="mt-3 text-sm font-semibold text-ink">
                        {{ $search !== '' || $status !== '' ? 'Tidak ada pesan yang cocok' : 'Belum ada pesan masuk' }}
                    </h3>
                    <p class="mt-1 text-sm text-muted">
                        {{ $search !== '' || $status !== '' ? 'Coba ubah kata kunci atau filter status.' : 'Pesan dari formulir kontak website akan muncul di sini.' }}
                    </p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 sm:px-5">Pengirim</th>
                                <th scope="col" class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 lg:table-cell">Pesan</th>
                                <th scope="col" class="hidden px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 md:table-cell">Diterima</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 sm:px-5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($messages as $message)
                                <tr @class(['transition hover:bg-slate-50/60', 'bg-brand/5' => ! $message->sudah_dibaca])>
                                    <td class="px-4 py-3 sm:px-5">
                                        <div class="flex items-start gap-3">
                                            <span @class([
                                                'mt-1 h-2.5 w-2.5 shrink-0 rounded-full',
                                                'bg-brand' => ! $message->sudah_dibaca,
                                                'bg-slate-200' => $message->sudah_dibaca,
                                            ]) aria-hidden="true"></span>

                                            <div class="min-w-0">
                                                <p @class(['truncate font-semibold', 'text-ink' => ! $message->sudah_dibaca, 'text-slate-700' => $message->sudah_dibaca])>
                                                    {{ $message->nama }}
                                                </p>
                                                <p class="mt-0.5 truncate text-xs text-muted">{{ $message->email }}</p>
                                                <p class="mt-1 max-w-xs truncate text-xs text-slate-600 lg:hidden">
                                                    {{ \Illuminate\Support\Str::limit($message->pesan, 70) }}
                                                </p>
                                                <p class="mt-1 text-xs text-muted md:hidden">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="hidden px-4 py-3 lg:table-cell">
                                        <p class="max-w-md text-sm leading-relaxed text-slate-600">
                                            {{ \Illuminate\Support\Str::limit($message->pesan, 110) }}
                                        </p>
                                    </td>

                                    <td class="hidden px-4 py-3 whitespace-nowrap text-slate-600 md:table-cell">
                                        {{ $message->created_at->format('d M Y, H:i') }}
                                    </td>

                                    <td class="px-4 py-3">
                                        @if ($message->sudah_dibaca)
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-slate-400" aria-hidden="true"></span>
                                                Dibaca
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500" aria-hidden="true"></span>
                                                Baru
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 sm:px-5">
                                        <div class="flex items-center justify-end gap-2">
                                            <a
                                                href="{{ route('admin.messages.show', $message) }}"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-brand/40 hover:bg-brand/5 hover:text-brand-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
                                            >
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                                Buka
                                            </a>

                                            <form method="POST" action="{{ route('admin.messages.toggle-read', $message) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs font-semibold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2 {{ $message->sudah_dibaca ? 'border border-slate-200 bg-white text-slate-500 hover:bg-slate-50' : 'border border-brand/30 bg-brand/5 text-brand-dark hover:bg-brand/10' }}"
                                                    title="{{ $message->sudah_dibaca ? 'Tandai belum dibaca' : 'Tandai sudah dibaca' }}"
                                                >
                                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                                    </svg>
                                                    {{ $message->sudah_dibaca ? 'Belum dibaca' : 'Tandai dibaca' }}
                                                </button>
                                            </form>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.messages.destroy', $message) }}"
                                                onsubmit="return confirm('Hapus pesan dari {{ $message->nama }}? Tindakan ini tidak dapat dibatalkan.');"
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

                @if ($messages->hasPages())
                    <div class="border-t border-slate-100 px-4 py-3 sm:px-5">
                        {{ $messages->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-admin-layout>
