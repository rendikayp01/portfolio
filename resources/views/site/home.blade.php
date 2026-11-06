@php
    $skillsAdmin = $skills->get(\App\Models\Skill::KATEGORI_ADMINISTRASI, collect());
    $skillsWeb = $skills->get(\App\Models\Skill::KATEGORI_WEB, collect());
    $pendidikan = $experiences->get(\App\Models\Experience::TIPE_PENDIDIKAN, collect());
    $pengalaman = $experiences->get(\App\Models\Experience::TIPE_PENGALAMAN, collect());
    $sertifikat = $experiences->get(\App\Models\Experience::TIPE_SERTIFIKAT, collect());
    $totalSkills = $skills->flatten(1)->count();
    $nama = $profile?->nama ?? 'Portofolio';
    $headline = $profile?->headline ?? 'Web Developer · Pengolahan Data & Administrasi';
    $bio = $profile?->bio;
@endphp

<x-public-layout
    :title="null"
    :description="$profile?->headline"
    :cv-file="$cvFile"
>
    {{-- Hero --}}
    <section id="beranda" class="relative overflow-hidden scroll-mt-20">
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="absolute -right-24 -top-24 h-80 w-80 rounded-full bg-brand/10 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-24 h-80 w-80 rounded-full bg-teal-200/30 blur-3xl"></div>
        </div>

        <div class="relative mx-auto grid max-w-6xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:items-center lg:gap-16 lg:px-8 lg:py-24">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-brand/20 bg-brand/5 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-dark">
                    <span class="h-1.5 w-1.5 rounded-full bg-brand" aria-hidden="true"></span>
                    Portofolio Pribadi
                </span>

                <h1 class="mt-5 text-4xl font-extrabold tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    {{ $nama }}
                </h1>

                <p class="mt-3 text-lg font-semibold text-brand-dark sm:text-xl">
                    {{ $headline }}
                </p>

                @if ($bio)
                    <p class="mt-5 max-w-xl text-base leading-relaxed text-slate-600">
                        {{ \Illuminate\Support\Str::limit($bio, 240) }}
                    </p>
                @endif

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                    <a
                        href="#proyek"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
                    >
                        Lihat proyek
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>

                    @if ($cvFile)
                        <a
                            href="{{ $cvFile->url() }}"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Unduh CV
                        </a>
                    @else
                        <a
                            href="#kontak"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
                        >
                            Hubungi saya
                        </a>
                    @endif
                </div>

                @if ($profile)
                    <x-social-links :profile="$profile" class="mt-6" />
                @endif
            </div>

            <div class="relative mx-auto w-full max-w-sm lg:max-w-none">
                <div class="absolute -inset-3 -rotate-3 rounded-[2rem] bg-brand/10" aria-hidden="true"></div>

                <div class="relative overflow-hidden rounded-[2rem] border border-white/60 bg-white p-2 shadow-xl shadow-slate-900/5">
                    @if ($profile?->fotoUrl())
                        <img
                            src="{{ $profile->fotoUrl() }}"
                            alt="Foto {{ $profile->nama }}"
                            class="aspect-[4/5] w-full rounded-[1.6rem] object-cover"
                        >
                    @else
                        <div class="relative flex aspect-[4/5] w-full items-center justify-center overflow-hidden rounded-[1.6rem] bg-gradient-to-br from-brand via-brand-dark to-slate-900">
                            <div class="absolute inset-0 opacity-20" aria-hidden="true">
                                <div class="absolute -right-10 top-10 h-40 w-40 rounded-full border border-white/40"></div>
                                <div class="absolute -bottom-8 -left-8 h-52 w-52 rounded-full border border-white/30"></div>
                            </div>
                            <span class="relative text-7xl font-extrabold tracking-tight text-white/90">{{ $profile?->inisial() ?? 'P' }}</span>
                        </div>
                    @endif
                </div>

                <div class="absolute -bottom-6 left-4 right-4 rounded-2xl border border-slate-200 bg-white/95 p-4 shadow-lg shadow-slate-900/5 backdrop-blur sm:left-6 sm:right-auto sm:w-64">
                    <div class="grid grid-cols-2 divide-x divide-slate-100">
                        <div class="pr-3">
                            <p class="text-2xl font-extrabold tracking-tight text-brand-dark">{{ $projects->count() }}</p>
                            <p class="mt-0.5 text-xs font-medium text-muted">Proyek tampil</p>
                        </div>
                        <div class="pl-3">
                            <p class="text-2xl font-extrabold tracking-tight text-brand-dark">{{ $totalSkills }}</p>
                            <p class="mt-0.5 text-xs font-medium text-muted">Keahlian</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Tentang --}}
    <section id="tentang" class="scroll-mt-20 border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-brand">Tentang</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">Sedikit tentang saya</h2>
                <p class="mt-3 text-base leading-relaxed text-slate-600">
                    Perpaduan kemampuan teknis dan administrasi untuk membantu pekerjaan menjadi lebih rapi, cepat, dan terukur.
                </p>
            </div>

            <div class="mt-10 grid gap-8 lg:grid-cols-[1.15fr_0.85fr] lg:items-start">
                <div class="rounded-2xl border border-slate-200 bg-canvas p-6 sm:p-8">
                    @if ($bio)
                        <div class="whitespace-pre-line text-base leading-relaxed text-slate-700">{{ $bio }}</div>
                    @else
                        <p class="text-base leading-relaxed text-slate-600">
                            Profil belum diisi. Silakan perbarui melalui panel admin.
                        </p>
                    @endif
                </div>

                <div class="rounded-2xl border border-slate-200 bg-canvas p-6 sm:p-8">
                    <h3 class="text-base font-semibold text-ink">Informasi kontak</h3>
                    <p class="mt-1 text-sm text-muted">Cara termudah untuk menghubungi saya.</p>

                    <dl class="mt-5 space-y-4 text-sm">
                        @if ($profile?->email)
                            <div class="flex items-start gap-3">
                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand/10 text-brand-dark">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <dt class="text-xs font-medium uppercase tracking-wide text-muted">Email</dt>
                                    <dd class="mt-0.5 break-all font-medium text-ink">
                                        <a href="mailto:{{ $profile->email }}" class="hover:text-brand-dark">{{ $profile->email }}</a>
                                    </dd>
                                </div>
                            </div>
                        @endif

                        @if ($profile?->no_wa)
                            <div class="flex items-start gap-3">
                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand/10 text-brand-dark">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                    </svg>
                                </span>
                                <div>
                                    <dt class="text-xs font-medium uppercase tracking-wide text-muted">WhatsApp</dt>
                                    <dd class="mt-0.5 font-medium text-ink">
                                        @if ($profile->whatsappUrl())
                                            <a href="{{ $profile->whatsappUrl() }}" target="_blank" rel="noopener" class="hover:text-brand-dark">{{ $profile->no_wa }}</a>
                                        @else
                                            {{ $profile->no_wa }}
                                        @endif
                                    </dd>
                                </div>
                            </div>
                        @endif

                        @if ($profile?->link_linkedin)
                            <div class="flex items-start gap-3">
                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand/10 text-brand-dark">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M4.98 3.5C4.98 4.88 3.87 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM.5 8h4V24h-4V8zm7.5 0h3.8v2.2h.05c.53-1 1.83-2.2 3.77-2.2 4.03 0 4.78 2.65 4.78 6.1V24h-4v-8.5c0-2.03-.04-4.64-2.83-4.64-2.83 0-3.27 2.2-3.27 4.5V24h-4V8z" />
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <dt class="text-xs font-medium uppercase tracking-wide text-muted">LinkedIn</dt>
                                    <dd class="mt-0.5 truncate font-medium text-ink">
                                        <a href="{{ $profile->link_linkedin }}" target="_blank" rel="noopener" class="hover:text-brand-dark">{{ parse_url($profile->link_linkedin, PHP_URL_HOST) ?? 'LinkedIn' }}</a>
                                    </dd>
                                </div>
                            </div>
                        @endif

                        @if ($profile?->link_github)
                            <div class="flex items-start gap-3">
                                <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand/10 text-brand-dark">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 .5C5.73.5.5 5.73.5 12c0 5.08 3.29 9.39 7.86 10.91.58.11.79-.25.79-.55 0-.27-.01-1.17-.02-2.12-3.2.7-3.88-1.36-3.88-1.36-.52-1.33-1.28-1.68-1.28-1.68-1.05-.72.08-.71.08-.71 1.16.08 1.77 1.19 1.77 1.19 1.03 1.77 2.7 1.26 3.36.96.1-.75.4-1.26.73-1.55-2.55-.29-5.23-1.28-5.23-5.68 0-1.25.45-2.28 1.19-3.08-.12-.29-.51-1.46.11-3.04 0 0 .96-.31 3.15 1.18a10.9 10.9 0 0 1 2.87-.39c.97 0 1.95.13 2.87.39 2.19-1.49 3.15-1.18 3.15-1.18.62 1.58.23 2.75.11 3.04.74.8 1.19 1.83 1.19 3.08 0 4.41-2.69 5.38-5.25 5.67.41.35.77 1.04.77 2.1 0 1.52-.01 2.74-.01 3.11 0 .3.21.66.8.55A11.5 11.5 0 0 0 23.5 12C23.5 5.73 18.27.5 12 .5z" />
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <dt class="text-xs font-medium uppercase tracking-wide text-muted">GitHub</dt>
                                    <dd class="mt-0.5 truncate font-medium text-ink">
                                        <a href="{{ $profile->link_github }}" target="_blank" rel="noopener" class="hover:text-brand-dark">{{ parse_url($profile->link_github, PHP_URL_HOST) ?? 'GitHub' }}</a>
                                    </dd>
                                </div>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </section>

    {{-- Keahlian --}}
    <section id="keahlian" class="scroll-mt-20 border-t border-slate-200 bg-canvas">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-brand">Keahlian</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">Yang saya kerjakan</h2>
                <p class="mt-3 text-base leading-relaxed text-slate-600">
                    Dua bidang yang saling melengkapi: pengembangan web dan pengelolaan data serta administrasi.
                </p>
            </div>

            <div class="mt-10 grid gap-6 lg:grid-cols-2">
                @foreach ([
                    ['judul' => \App\Models\Skill::kategoriLabels()[\App\Models\Skill::KATEGORI_ADMINISTRASI], 'items' => $skillsAdmin, 'icon' => 'data'],
                    ['judul' => \App\Models\Skill::kategoriLabels()[\App\Models\Skill::KATEGORI_WEB], 'items' => $skillsWeb, 'icon' => 'code'],
                ] as $group)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand/10 text-brand-dark">
                                @if ($group['icon'] === 'code')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                                    </svg>
                                @endif
                            </span>

                            <div>
                                <h3 class="text-base font-semibold text-ink">{{ $group['judul'] }}</h3>
                                <p class="text-xs text-muted">{{ $group['items']->count() }} keahlian</p>
                            </div>
                        </div>

                        @if ($group['items']->isEmpty())
                            <p class="mt-5 rounded-xl border border-dashed border-slate-200 bg-slate-50 p-4 text-sm text-muted">
                                Belum ada keahlian pada kategori ini.
                            </p>
                        @else
                            <ul class="mt-5 divide-y divide-slate-100">
                                @foreach ($group['items'] as $index => $skill)
                                    <li class="flex gap-3 py-3.5 first:pt-0 last:pb-0">
                                        <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-slate-100 text-[11px] font-bold text-slate-500">
                                            {{ $index + 1 }}
                                        </span>
                                        <div>
                                            <p class="text-sm font-semibold text-ink">{{ $skill->nama }}</p>
                                            <p class="mt-0.5 text-sm leading-relaxed text-slate-600">{{ $skill->deskripsi }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Proyek --}}
    <section id="proyek" class="scroll-mt-20 border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div class="max-w-2xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-brand">Proyek</p>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">Proyek pilihan</h2>
                    <p class="mt-3 text-base leading-relaxed text-slate-600">
                        Beberapa pekerjaan yang menggabungkan pengembangan web dengan kebutuhan nyata.
                    </p>
                </div>

                <p class="text-sm text-muted">{{ $projects->count() }} proyek ditampilkan</p>
            </div>

            @if ($projects->isEmpty())
                <div class="mt-10 rounded-2xl border border-dashed border-slate-300 bg-canvas px-6 py-16 text-center">
                    <h3 class="text-sm font-semibold text-ink">Belum ada proyek yang ditampilkan</h3>
                    <p class="mt-1 text-sm text-muted">Silakan tambahkan proyek melalui panel admin.</p>
                </div>
            @else
                <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($projects as $project)
                        @php
                            $teknologi = $project->teknologiList();
                            $tampilTeknologi = array_slice($teknologi, 0, 3);
                            $sisaTeknologi = count($teknologi) - count($tampilTeknologi);
                        @endphp

                        <article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-brand/30 hover:shadow-md">
                            <a href="{{ route('projects.show', $project) }}" class="relative block aspect-[16/10] overflow-hidden bg-slate-100" aria-label="Lihat detail {{ $project->judul }}">
                                @if ($project->gambarUrl())
                                    <img
                                        src="{{ $project->gambarUrl() }}"
                                        alt="Gambar {{ $project->judul }}"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand/15 via-canvas to-teal-100">
                                        <x-application-logo class="h-14 w-14 text-brand/50" />
                                    </div>
                                @endif

                                <span class="absolute left-3 top-3 rounded-full bg-white/95 px-2.5 py-1 text-[11px] font-semibold text-slate-700 shadow-sm backdrop-blur">
                                    {{ $project->kategori }}
                                </span>
                            </a>

                            <div class="flex flex-1 flex-col p-5">
                                <div class="flex items-center gap-2 text-xs font-medium text-muted">
                                    <span>{{ $project->tahun }}</span>
                                    <span aria-hidden="true">·</span>
                                    <span>{{ $project->peran }}</span>
                                </div>

                                <h3 class="mt-2 text-lg font-bold leading-snug tracking-tight text-ink">
                                    <a href="{{ route('projects.show', $project) }}" class="transition group-hover:text-brand-dark">
                                        {{ $project->judul }}
                                    </a>
                                </h3>

                                <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-600">
                                    {{ \Illuminate\Support\Str::limit($project->ringkasan, 120) }}
                                </p>

                                @if ($teknologi !== [])
                                    <div class="mt-4 flex flex-wrap gap-1.5">
                                        @foreach ($tampilTeknologi as $tech)
                                            <span class="rounded-md bg-slate-100 px-2 py-1 text-[11px] font-medium text-slate-600">{{ $tech }}</span>
                                        @endforeach
                                        @if ($sisaTeknologi > 0)
                                            <span class="rounded-md bg-slate-100 px-2 py-1 text-[11px] font-medium text-slate-600">+{{ $sisaTeknologi }}</span>
                                        @endif
                                    </div>
                                @endif

                                <a
                                    href="{{ route('projects.show', $project) }}"
                                    class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-dark transition hover:gap-2.5"
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
            @endif
        </div>
    </section>

    {{-- Pengalaman --}}
    <section id="pengalaman" class="scroll-mt-20 border-t border-slate-200 bg-canvas">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-brand">Pengalaman</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">Latar belakang &amp; pencapaian</h2>
                <p class="mt-3 text-base leading-relaxed text-slate-600">
                    Riwayat pendidikan, pengalaman kerja, dan sertifikasi yang mendukung pekerjaan saya.
                </p>
            </div>

            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                @foreach ([
                    ['judul' => 'Pendidikan', 'items' => $pendidikan, 'icon' => 'academic'],
                    ['judul' => 'Pengalaman', 'items' => $pengalaman, 'icon' => 'briefcase'],
                    ['judul' => 'Sertifikat', 'items' => $sertifikat, 'icon' => 'badge'],
                ] as $group)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand/10 text-brand-dark">
                                @switch($group['icon'])
                                    @case('academic')
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                        </svg>
                                        @break
                                    @case('briefcase')
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                                        </svg>
                                        @break
                                    @default
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                        </svg>
                                @endswitch
                            </span>
                            <h3 class="text-base font-semibold text-ink">{{ $group['judul'] }}</h3>
                        </div>

                        @if ($group['items']->isEmpty())
                            <p class="mt-5 rounded-xl border border-dashed border-slate-200 bg-slate-50 p-4 text-sm text-muted">
                                Belum ada data.
                            </p>
                        @else
                            <ol class="mt-6 space-y-5 border-l border-slate-200 pl-5">
                                @foreach ($group['items'] as $item)
                                    <li class="relative">
                                        <span class="absolute -left-[1.6rem] top-1 h-2.5 w-2.5 rounded-full border-2 border-white bg-brand shadow" aria-hidden="true"></span>
                                        <p class="text-xs font-semibold uppercase tracking-wide text-brand-dark">{{ $item->periodeLabel() }}</p>
                                        <p class="mt-1 text-sm font-semibold leading-snug text-ink">{{ $item->judul }}</p>
                                        <p class="mt-0.5 text-xs text-muted">{{ $item->institusi }}</p>
                                        @if ($item->deskripsi)
                                            <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $item->deskripsi }}</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Ajakan unduh CV --}}
    <section class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-dark via-brand to-teal-700 px-6 py-10 shadow-xl sm:px-10 sm:py-12">
                <div class="pointer-events-none absolute inset-0 opacity-20" aria-hidden="true">
                    <div class="absolute -right-16 -top-16 h-56 w-56 rounded-full border border-white/40"></div>
                    <div class="absolute -bottom-20 -left-10 h-64 w-64 rounded-full border border-white/30"></div>
                </div>

                <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                    <div class="max-w-xl">
                        <h2 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">Ingin melihat riwayat lengkap?</h2>
                        <p class="mt-2 text-sm leading-relaxed text-teal-50">
                            @if ($cvFile)
                                Unduh CV dalam format PDF untuk informasi pendidikan, pengalaman, dan keahlian secara ringkas.
                            @else
                                CV belum tersedia saat ini. Silakan hubungi saya untuk informasi lebih lanjut.
                            @endif
                        </p>
                    </div>

                    @if ($cvFile)
                        <a
                            href="{{ $cvFile->url() }}"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-brand-dark shadow-sm transition hover:bg-teal-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-brand-dark"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Unduh CV PDF
                        </a>
                    @else
                        <a
                            href="#kontak"
                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-brand-dark shadow-sm transition hover:bg-teal-50"
                        >
                            Hubungi saya
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Kontak --}}
    <section id="kontak" class="scroll-mt-20 border-t border-slate-200 bg-canvas">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-brand">Kontak</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">Mari bekerja sama</h2>
                <p class="mt-3 text-base leading-relaxed text-slate-600">
                    Punya proyek, peluang kerja, atau pertanyaan? Kirim pesan melalui formulir berikut.
                </p>
            </div>

            <div class="mt-10 grid gap-6 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
                <div class="space-y-4">
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h3 class="text-base font-semibold text-ink">Hubungi langsung</h3>

                        <div class="mt-4 space-y-3 text-sm">
                            @if ($profile?->email)
                                <a href="mailto:{{ $profile->email }}" class="flex items-center gap-3 rounded-xl border border-slate-200 px-3.5 py-3 transition hover:border-brand/40 hover:bg-brand/5">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand/10 text-brand-dark">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                        </svg>
                                    </span>
                                    <span class="min-w-0">
                                        <span class="block text-xs text-muted">Email</span>
                                        <span class="block break-all font-medium text-ink">{{ $profile->email }}</span>
                                    </span>
                                </a>
                            @endif

                            @if ($profile?->whatsappUrl())
                                <a href="{{ $profile->whatsappUrl() }}" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-xl border border-slate-200 px-3.5 py-3 transition hover:border-brand/40 hover:bg-brand/5">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand/10 text-brand-dark">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.297-.497.1-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.71.306 1.263.489 1.694.625.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z" />
                                        </svg>
                                    </span>
                                    <span>
                                        <span class="block text-xs text-muted">WhatsApp</span>
                                        <span class="block font-medium text-ink">{{ $profile->no_wa }}</span>
                                    </span>
                                </a>
                            @endif
                        </div>

                        @if ($profile)
                            <x-social-links :profile="$profile" :show-labels="true" class="mt-4" />
                        @endif
                    </div>

                    <div class="rounded-2xl border border-brand/20 bg-brand/5 p-5">
                        <p class="text-sm leading-relaxed text-brand-dark">
                            <span class="font-semibold">Waktu respons:</span> biasanya dalam 1–2 hari kerja. Untuk kebutuhan mendesak, silakan hubungi WhatsApp.
                        </p>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    @if (session('success'))
                        <div class="mb-5 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800" role="status">
                            <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <h3 class="text-base font-semibold text-ink">Kirim pesan</h3>
                    <p class="mt-1 text-sm text-muted">Isi formulir di bawah, saya akan membalas melalui email.</p>

                    <form method="POST" action="{{ route('contact.store') }}" class="mt-5 space-y-5">
                        @csrf

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <x-input-label for="nama" value="Nama" />
                                <input
                                    id="nama"
                                    name="nama"
                                    type="text"
                                    value="{{ old('nama') }}"
                                    maxlength="100"
                                    required
                                    placeholder="Nama Anda"
                                    class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand"
                                >
                                <x-input-error :messages="$errors->get('nama')" class="mt-1.5" />
                            </div>

                            <div>
                                <x-input-label for="email" value="Email" />
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    maxlength="150"
                                    required
                                    placeholder="nama@example.com"
                                    class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand"
                                >
                                <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="pesan" value="Pesan" />
                            <textarea
                                id="pesan"
                                name="pesan"
                                rows="6"
                                maxlength="2000"
                                required
                                placeholder="Ceritakan kebutuhan atau pertanyaan Anda…"
                                class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm leading-relaxed text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand"
                            >{{ old('pesan') }}</textarea>
                            <x-input-error :messages="$errors->get('pesan')" class="mt-1.5" />
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <p class="text-xs leading-relaxed text-muted">
                                Data Anda hanya dipakai untuk membalas pesan ini.
                            </p>

                            <x-primary-button class="justify-center">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                </svg>
                                Kirim pesan
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
