@props([
    'title' => null,
    'description' => null,
    'cvFile' => null,
])

@php
    $home = route('home');
    $navItems = [
        ['label' => 'Beranda', 'href' => $home.'#beranda'],
        ['label' => 'Tentang', 'href' => $home.'#tentang'],
        ['label' => 'Keahlian', 'href' => $home.'#keahlian'],
        ['label' => 'Proyek', 'href' => $home.'#proyek'],
        ['label' => 'Pengalaman', 'href' => $home.'#pengalaman'],
        ['label' => 'Kontak', 'href' => $home.'#kontak'],
    ];

    $metaDescription = $description ?? 'Portofolio pribadi web developer yang juga berpengalaman dalam administrasi dan pengolahan data.';
    $appName = config('app.name', 'Portofolio');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ? $title.' — '.$appName : $appName }}</title>
        <meta name="description" content="{{ $metaDescription }}">
        <meta property="og:type" content="website">
        <meta property="og:title" content="{{ $title ? $title.' — '.$appName : $appName }}">
        <meta property="og:description" content="{{ $metaDescription }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta name="twitter:card" content="summary_large_image">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-full bg-canvas font-sans text-ink antialiased">
        <a
            href="#konten-utama"
            class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:rounded-lg focus:bg-brand focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-white"
        >
            Lewati ke konten utama
        </a>

        <header
            x-data="{ open: false, scrolled: false }"
            @scroll.window="scrolled = window.scrollY > 8"
            class="sticky top-0 z-50 border-b transition-colors duration-200"
            :class="scrolled ? 'border-slate-200/80 bg-canvas/90 backdrop-blur' : 'border-transparent bg-canvas'"
        >
            <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                <a href="{{ $home }}" class="flex shrink-0 items-center gap-2.5" aria-label="{{ $appName }} — beranda">
                    <x-application-logo class="h-9 w-9 text-brand" />
                    <span class="text-base font-bold tracking-tight">{{ $appName }}</span>
                </a>

                <nav class="hidden items-center gap-1 lg:flex" aria-label="Navigasi utama">
                    @foreach ($navItems as $item)
                        <a
                            href="{{ $item['href'] }}"
                            class="rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-brand/5 hover:text-brand-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-brand"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="flex items-center gap-2">
                    @if ($cvFile)
                        <a
                            href="{{ $cvFile->url() }}"
                            target="_blank"
                            rel="noopener"
                            class="hidden items-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2 sm:inline-flex"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Unduh CV
                        </a>
                    @endif

                    <button
                        type="button"
                        class="rounded-lg p-2 text-slate-600 transition hover:bg-slate-100 hover:text-ink focus:outline-none focus-visible:ring-2 focus-visible:ring-brand lg:hidden"
                        @click="open = !open"
                        :aria-expanded="open"
                        aria-controls="menu-mobile"
                        aria-label="Buka menu"
                    >
                        <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                        </svg>
                        <svg x-show="open" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="menu-mobile" x-show="open" x-cloak x-transition.opacity class="border-t border-slate-200 bg-canvas lg:hidden">
                <nav class="mx-auto max-w-6xl space-y-1 px-4 py-4 sm:px-6" aria-label="Navigasi mobile">
                    @foreach ($navItems as $item)
                        <a
                            href="{{ $item['href'] }}"
                            @click="open = false"
                            class="block rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-brand/5 hover:text-brand-dark"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach

                    @if ($cvFile)
                        <a
                            href="{{ $cvFile->url() }}"
                            target="_blank"
                            rel="noopener"
                            @click="open = false"
                            class="mt-2 flex items-center justify-center gap-2 rounded-lg bg-brand px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-dark"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Unduh CV
                        </a>
                    @endif
                </nav>
            </div>
        </header>

        <main id="konten-utama">
            {{ $slot }}
        </main>

        <footer class="border-t border-slate-200 bg-white">
            <div class="mx-auto flex max-w-6xl flex-col gap-6 px-4 py-10 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                <div class="flex items-center gap-3">
                    <x-application-logo class="h-9 w-9 text-brand" />
                    <div>
                        <p class="text-sm font-bold">{{ $appName }}</p>
                        <p class="text-xs text-muted">Portofolio pribadi · Web &amp; Pengolahan Data</p>
                    </div>
                </div>

                <nav class="flex flex-wrap gap-x-5 gap-y-2 text-sm text-slate-600" aria-label="Navigasi footer">
                    @foreach ($navItems as $item)
                        <a href="{{ $item['href'] }}" class="transition hover:text-brand-dark">{{ $item['label'] }}</a>
                    @endforeach
                </nav>

                <p class="text-xs text-muted">&copy; {{ now()->year }} {{ $appName }}. Dibuat dengan Laravel.</p>
            </div>
        </footer>
    </body>
</html>
