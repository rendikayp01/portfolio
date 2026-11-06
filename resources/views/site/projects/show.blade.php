@php
    $teknologi = $project->teknologiList();
    $bagian = array_values(array_filter([
        ['judul' => 'Masalah', 'isi' => $project->deskripsi_masalah, 'icon' => 'masalah'],
        ['judul' => 'Solusi', 'isi' => $project->deskripsi_solusi, 'icon' => 'solusi'],
        ['judul' => 'Hasil', 'isi' => $project->deskripsi_hasil, 'icon' => 'hasil'],
    ], static fn (array $item): bool => filled($item['isi'])));
@endphp

<x-public-layout
    :title="$project->judul"
    :description="$project->ringkasan"
    :cv-file="$cvFile"
>
    <article>
        {{-- Hero --}}
        <section class="relative overflow-hidden border-b border-slate-200 bg-white">
            <div class="pointer-events-none absolute inset-0" aria-hidden="true">
                <div class="absolute -right-24 -top-24 h-80 w-80 rounded-full bg-brand/10 blur-3xl"></div>
                <div class="absolute -bottom-32 -left-24 h-72 w-72 rounded-full bg-teal-200/30 blur-3xl"></div>
            </div>

            <div class="relative mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
                <nav class="flex flex-wrap items-center gap-2 text-sm text-muted" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="transition hover:text-brand-dark">Beranda</a>
                    <span aria-hidden="true">/</span>
                    <a href="{{ route('home') }}#proyek" class="transition hover:text-brand-dark">Proyek</a>
                    <span aria-hidden="true">/</span>
                    <span class="truncate font-medium text-ink" aria-current="page">{{ $project->judul }}</span>
                </nav>

                <div class="mt-6 max-w-3xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-brand/20 bg-brand/5 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-dark">
                        {{ $project->kategori }}
                    </span>

                    <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-ink sm:text-4xl lg:text-5xl">
                        {{ $project->judul }}
                    </h1>

                    <p class="mt-4 text-base leading-relaxed text-slate-600 sm:text-lg">
                        {{ $project->ringkasan }}
                    </p>

                    <dl class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3">
                        <div class="rounded-xl border border-slate-200 bg-canvas px-4 py-3">
                            <dt class="text-xs font-medium uppercase tracking-wide text-muted">Tahun</dt>
                            <dd class="mt-1 text-sm font-semibold text-ink">{{ $project->tahun }}</dd>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-canvas px-4 py-3">
                            <dt class="text-xs font-medium uppercase tracking-wide text-muted">Peran</dt>
                            <dd class="mt-1 text-sm font-semibold text-ink">{{ $project->peran }}</dd>
                        </div>
                        <div class="col-span-2 rounded-xl border border-slate-200 bg-canvas px-4 py-3 sm:col-span-1">
                            <dt class="text-xs font-medium uppercase tracking-wide text-muted">Kategori</dt>
                            <dd class="mt-1 text-sm font-semibold text-ink">{{ $project->kategori }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>

        {{-- Gambar utama --}}
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="-mt-2 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm sm:-mt-8">
                @if ($project->gambarUrl())
                    <img
                        src="{{ $project->gambarUrl() }}"
                        alt="Gambar {{ $project->judul }}"
                        class="aspect-[16/9] w-full object-cover"
                    >
                @else
                    <div class="flex aspect-[16/9] w-full items-center justify-center bg-gradient-to-br from-brand/15 via-canvas to-teal-100">
                        <x-application-logo class="h-20 w-20 text-brand/40" />
                    </div>
                @endif
            </div>
        </div>

        {{-- Isi --}}
        <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
            <div class="grid gap-10 lg:grid-cols-[1.6fr_0.9fr] lg:items-start">
                <div class="space-y-8">
                    @if ($bagian === [])
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-canvas px-6 py-12 text-center">
                            <p class="text-sm text-muted">Detail proyek belum dilengkapi.</p>
                        </div>
                    @else
                        @foreach ($bagian as $item)
                            <section>
                                <div class="flex items-center gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand/10 text-brand-dark">
                                        @switch($item['icon'])
                                            @case('masalah')
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                @break
                                            @case('solusi')
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                                                </svg>
                                                @break
                                            @default
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                                </svg>
                                        @endswitch
                                    </span>
                                    <h2 class="text-xl font-bold tracking-tight text-ink">{{ $item['judul'] }}</h2>
                                </div>

                                <div class="mt-3 whitespace-pre-line text-base leading-relaxed text-slate-600">{{ $item['isi'] }}</div>
                            </section>
                        @endforeach
                    @endif
                </div>

                <aside class="space-y-5 lg:sticky lg:top-24">
                    @if ($teknologi !== [])
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                            <h2 class="text-sm font-semibold uppercase tracking-wide text-muted">Teknologi</h2>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ($teknologi as $tech)
                                    <span class="rounded-md bg-brand/10 px-2.5 py-1 text-xs font-semibold text-brand-dark">{{ $tech }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="rounded-2xl border border-brand/20 bg-brand/5 p-6">
                        <h2 class="text-base font-semibold text-ink">Tertarik dengan proyek serupa?</h2>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">
                            Ceritakan kebutuhan Anda, saya siap membantu merancang solusinya.
                        </p>
                        <a
                            href="{{ route('home') }}#kontak"
                            class="mt-4 inline-flex items-center justify-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
                        >
                            Hubungi saya
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>

                    <a
                        href="{{ route('home') }}#proyek"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 transition hover:text-brand-dark"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Kembali ke semua proyek
                    </a>
                </aside>
            </div>
        </section>

        {{-- Proyek terkait --}}
        @if ($related->isNotEmpty())
            <section class="border-t border-slate-200 bg-white">
                <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
                    <div class="flex flex-wrap items-end justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-brand">Proyek lain</p>
                            <h2 class="mt-2 text-2xl font-bold tracking-tight sm:text-3xl">Jelajahi proyek lainnya</h2>
                        </div>

                        <a href="{{ route('home') }}#proyek" class="text-sm font-semibold text-brand-dark transition hover:text-brand">
                            Lihat semua
                        </a>
                    </div>

                    <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($related as $item)
                            <article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-brand/30 hover:shadow-md">
                                <a href="{{ route('projects.show', $item) }}" class="relative block aspect-[16/10] overflow-hidden bg-slate-100" aria-label="Lihat detail {{ $item->judul }}">
                                    @if ($item->gambarUrl())
                                        <img
                                            src="{{ $item->gambarUrl() }}"
                                            alt="Gambar {{ $item->judul }}"
                                            class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
                                            loading="lazy"
                                        >
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand/15 via-canvas to-teal-100">
                                            <x-application-logo class="h-12 w-12 text-brand/50" />
                                        </div>
                                    @endif

                                    <span class="absolute left-3 top-3 rounded-full bg-white/95 px-2.5 py-1 text-[11px] font-semibold text-slate-700 shadow-sm backdrop-blur">
                                        {{ $item->kategori }}
                                    </span>
                                </a>

                                <div class="flex flex-1 flex-col p-5">
                                    <div class="flex items-center gap-2 text-xs font-medium text-muted">
                                        <span>{{ $item->tahun }}</span>
                                        <span aria-hidden="true">·</span>
                                        <span>{{ $item->peran }}</span>
                                    </div>

                                    <h3 class="mt-2 text-lg font-bold leading-snug tracking-tight text-ink">
                                        <a href="{{ route('projects.show', $item) }}" class="transition group-hover:text-brand-dark">
                                            {{ $item->judul }}
                                        </a>
                                    </h3>

                                    <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-600">
                                        {{ \Illuminate\Support\Str::limit($item->ringkasan, 110) }}
                                    </p>

                                    <a
                                        href="{{ route('projects.show', $item) }}"
                                        class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-dark transition hover:gap-2.5"
                                    >
                                        Lihat detail
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </article>
</x-public-layout>
