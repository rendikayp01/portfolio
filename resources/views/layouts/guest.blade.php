<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, nofollow">

        <title>{{ config('app.name', 'Portofolio') }} — Admin</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-ink antialiased">
        <div class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden px-4 py-10 sm:px-6">
            {{-- Dekorasi latar --}}
            <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
                <div class="absolute -left-24 -top-24 h-80 w-80 rounded-full bg-brand/10 blur-3xl"></div>
                <div class="absolute -bottom-32 -right-16 h-96 w-96 rounded-full bg-teal-200/40 blur-3xl"></div>
            </div>

            <div class="w-full max-w-md">
                <a href="{{ url('/') }}" class="flex items-center justify-center gap-3" aria-label="Kembali ke beranda">
                    <x-application-logo class="h-11 w-11 text-brand" />
                    <span class="text-lg font-semibold tracking-tight">{{ config('app.name', 'Portofolio') }}</span>
                </a>

                <div class="mt-8 rounded-2xl border border-slate-200/80 bg-white/90 p-6 shadow-xl shadow-slate-900/5 backdrop-blur sm:p-8">
                    {{ $slot }}
                </div>

                <p class="mt-6 text-center text-xs text-muted">
                    Area admin. Registrasi publik dinonaktifkan.
                </p>
            </div>
        </div>
    </body>
</html>
