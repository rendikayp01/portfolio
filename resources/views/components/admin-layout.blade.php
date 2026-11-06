@props([
    'title' => 'Panel Admin',
    'heading' => null,
    'description' => null,
])

@php
    $navItems = [
        [
            'label' => 'Profil',
            'route' => 'admin.profile.edit',
            'active' => 'admin.profile.*',
            'icon' => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z',
        ],
        [
            'label' => 'Keahlian',
            'route' => 'admin.skills.index',
            'active' => 'admin.skills.*',
            'icon' => 'M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z',
        ],
        [
            'label' => 'Proyek',
            'route' => 'admin.projects.index',
            'active' => 'admin.projects.*',
            'icon' => 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z',
        ],
        [
            'label' => 'Pengalaman / CV',
            'route' => 'admin.experiences.index',
            'active' => 'admin.experiences.*',
            'icon' => 'M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5',
        ],
        [
            'label' => 'File CV',
            'route' => 'admin.cv-files.index',
            'active' => 'admin.cv-files.*',
            'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z',
        ],
        [
            'label' => 'Pesan masuk',
            'route' => 'admin.messages.index',
            'active' => 'admin.messages.*',
            'icon' => 'M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155',
        ],
    ];

    $unreadMessages = auth()->check()
        ? \App\Models\Message::query()->belumDibaca()->count()
        : 0;

    $unreadBadge = $unreadMessages > 99 ? '99+' : (string) $unreadMessages;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, nofollow">

        <title>{{ $title }} — {{ config('app.name', 'Portofolio') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body
        class="min-h-full bg-canvas font-sans text-ink antialiased"
        x-data="{ sidebarOpen: false }"
        @keydown.escape.window="sidebarOpen = false"
    >
        <div class="min-h-screen lg:flex">
            {{-- Overlay sidebar mobile --}}
            <div
                x-cloak
                x-show="sidebarOpen"
                x-transition.opacity
                class="fixed inset-0 z-30 bg-slate-900/40 backdrop-blur-sm lg:hidden"
                @click="sidebarOpen = false"
                aria-hidden="true"
            ></div>

            <aside
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
                class="fixed inset-y-0 left-0 z-40 flex w-72 flex-col border-r border-slate-200 bg-white transition-transform duration-200 ease-out lg:translate-x-0"
                aria-label="Sidebar admin"
            >
                <div class="flex h-16 items-center gap-3 border-b border-slate-100 px-5">
                    <a href="{{ url('/admin') }}" class="flex items-center gap-3" aria-label="Kembali ke panel admin">
                        <x-application-logo class="h-9 w-9 shrink-0 text-brand" />
                        <span class="flex min-w-0 flex-col leading-tight">
                            <span class="truncate text-sm font-semibold">{{ config('app.name', 'Portofolio') }}</span>
                            <span class="text-[11px] font-semibold uppercase tracking-wider text-muted">Panel Admin</span>
                        </span>
                    </a>

                    <button
                        type="button"
                        class="ml-auto rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand lg:hidden"
                        @click="sidebarOpen = false"
                        aria-label="Tutup menu"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="flex-1 overflow-y-auto px-3 py-4" aria-label="Navigasi panel admin">
                    <p class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Konten</p>

                    <ul class="space-y-1">
                        @foreach ($navItems as $item)
                            <li>
                                @if (Route::has($item['route']))
                                    <a
                                        href="{{ route($item['route']) }}"
                                        @class([
                                            'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition',
                                            'bg-brand/10 font-semibold text-brand-dark' => request()->routeIs($item['active']),
                                            'font-medium text-slate-600 hover:bg-slate-100 hover:text-ink' => ! request()->routeIs($item['active']),
                                        ])
                                        @if (request()->routeIs($item['active'])) aria-current="page" @endif
                                    >
                                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                        </svg>
                                        <span>{{ $item['label'] }}</span>

                                        @if ($item['route'] === 'admin.messages.index' && $unreadMessages > 0)
                                            <span
                                                class="ml-auto inline-flex min-w-[1.35rem] items-center justify-center rounded-full bg-amber-500 px-1.5 py-0.5 text-[10px] font-bold leading-none text-white shadow-sm"
                                                aria-label="{{ $unreadMessages }} pesan belum dibaca"
                                                title="{{ $unreadMessages }} pesan belum dibaca"
                                            >
                                                {{ $unreadBadge }}
                                            </span>
                                        @endif
                                    </a>
                                @else
                                    <span
                                        class="flex cursor-not-allowed items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-400"
                                        aria-disabled="true"
                                        title="Tersedia pada tahap berikutnya"
                                    >
                                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                        </svg>
                                        <span>{{ $item['label'] }}</span>
                                        <span class="ml-auto rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-slate-400">Segera</span>
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </nav>

                <div class="border-t border-slate-100 p-4">
                    <div class="rounded-xl bg-slate-50 p-3">
                        <p class="truncate text-sm font-semibold text-ink">{{ auth()->user()->name }}</p>
                        <p class="mt-0.5 truncate text-xs text-muted">{{ auth()->user()->email }}</p>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button
                            type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </aside>

            <div class="flex min-h-screen min-w-0 flex-1 flex-col lg:pl-72">
                <header class="sticky top-0 z-20 border-b border-slate-200/80 bg-canvas/90 backdrop-blur">
                    <div class="flex min-h-16 items-center gap-3 px-4 py-3 sm:px-6 lg:px-8">
                        <button
                            type="button"
                            class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-ink focus:outline-none focus-visible:ring-2 focus-visible:ring-brand lg:hidden"
                            @click="sidebarOpen = true"
                            aria-label="Buka menu"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                            </svg>
                        </button>

                        <div class="min-w-0 flex-1">
                            <h1 class="truncate text-lg font-semibold tracking-tight sm:text-xl">{{ $heading ?? $title }}</h1>
                            @if ($description)
                                <p class="mt-0.5 hidden truncate text-sm text-muted sm:block">{{ $description }}</p>
                            @endif
                        </div>

                        <div class="flex shrink-0 items-center gap-2">
                            @isset($actions)
                                {{ $actions }}
                            @endisset

                            <a
                                href="{{ url('/') }}"
                                target="_blank"
                                rel="noopener"
                                class="hidden items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 shadow-sm transition hover:border-slate-300 hover:text-ink focus:outline-none focus-visible:ring-2 focus-visible:ring-brand sm:inline-flex"
                            >
                                Lihat website
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </header>

                <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                    @if (session('success'))
                        <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800" role="status">
                            <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
                            <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
