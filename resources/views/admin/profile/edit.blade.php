<x-admin-layout
    title="Profil"
    heading="Profil"
    description="Perbarui informasi diri yang tampil di website portofolio."
>
    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-base font-semibold text-ink">Identitas</h2>
                <p class="mt-1 text-sm text-muted">Nama, headline, dan bio singkat yang tampil di halaman utama.</p>
            </div>

            <div class="mt-5 grid gap-5 lg:grid-cols-[minmax(0,1fr)_260px]">
                <div class="space-y-5">
                    <div>
                        <x-input-label for="nama" value="Nama lengkap" />
                        <input
                            id="nama"
                            name="nama"
                            type="text"
                            value="{{ old('nama', $profile?->nama) }}"
                            maxlength="120"
                            required
                            autofocus
                            placeholder="Nama lengkap Anda"
                            class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand"
                        >
                        <x-input-error :messages="$errors->get('nama')" class="mt-1.5" />
                    </div>

                    <div>
                        <x-input-label for="headline" value="Headline" />
                        <input
                            id="headline"
                            name="headline"
                            type="text"
                            value="{{ old('headline', $profile?->headline) }}"
                            maxlength="180"
                            required
                            placeholder="Web Developer · Pengolahan Data & Administrasi"
                            class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand"
                        >
                        <p class="mt-1.5 text-xs text-muted">Satu baris singkat yang menggambarkan bidang Anda.</p>
                        <x-input-error :messages="$errors->get('headline')" class="mt-1.5" />
                    </div>

                    <div>
                        <x-input-label for="bio" value="Bio" />
                        <textarea
                            id="bio"
                            name="bio"
                            rows="6"
                            required
                            placeholder="Ceritakan singkat tentang diri, minat, dan pengalaman Anda."
                            class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm leading-relaxed text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand"
                        >{{ old('bio', $profile?->bio) }}</textarea>
                        <x-input-error :messages="$errors->get('bio')" class="mt-1.5" />
                    </div>
                </div>

                <div x-data="{ preview: null }">
                    <x-input-label for="foto" value="Foto profil" />
                    <input
                        id="foto"
                        name="foto"
                        type="file"
                        accept="image/jpeg,image/png,image/webp"
                        x-ref="foto"
                        @change="const file = $event.target.files[0]; preview = file ? URL.createObjectURL(file) : null"
                        class="mt-1.5 block w-full cursor-pointer rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-3 file:border-0 file:bg-brand/10 file:px-3 file:py-2.5 file:text-sm file:font-semibold file:text-brand-dark hover:file:bg-brand/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand"
                    >
                    <p class="mt-1.5 text-xs text-muted">JPG, PNG, atau WebP. Maksimal 2 MB.</p>
                    <x-input-error :messages="$errors->get('foto')" class="mt-1.5" />

                    <div class="mt-3">
                        <template x-if="preview">
                            <div>
                                <p class="mb-1.5 text-xs font-medium text-slate-500">Pratinjau foto baru</p>
                                <img :src="preview" alt="Pratinjau foto profil baru" class="aspect-square w-full rounded-2xl border border-slate-200 object-cover">
                            </div>
                        </template>

                        @if ($profile?->fotoUrl())
                            <div x-show="!preview">
                                <p class="mb-1.5 text-xs font-medium text-slate-500">Foto saat ini</p>
                                <img src="{{ $profile->fotoUrl() }}" alt="Foto {{ $profile->nama }}" class="aspect-square w-full rounded-2xl border border-slate-200 object-cover">
                                <p class="mt-1.5 text-xs text-muted">Biarkan kolom file kosong jika tidak ingin mengganti foto.</p>
                            </div>
                        @else
                            <div x-show="!preview" class="flex aspect-square w-full items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-slate-50 text-slate-400">
                                <div class="text-center">
                                    <svg class="mx-auto h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    <p class="mt-2 text-xs">Belum ada foto</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-base font-semibold text-ink">Kontak & tautan</h2>
                <p class="mt-1 text-sm text-muted">Informasi ini dipakai pada tombol kontak dan tautan sosial di website.</p>
            </div>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">
                <div>
                    <x-input-label for="email" value="Email" />
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $profile?->email) }}"
                        maxlength="150"
                        required
                        placeholder="nama@example.com"
                        class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand"
                    >
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="no_wa" value="Nomor WhatsApp" />
                    <input
                        id="no_wa"
                        name="no_wa"
                        type="text"
                        value="{{ old('no_wa', $profile?->no_wa) }}"
                        maxlength="30"
                        required
                        placeholder="6281234567890"
                        class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand"
                    >
                    <p class="mt-1.5 text-xs text-muted">Gunakan format internasional, contoh 6281234567890.</p>
                    <x-input-error :messages="$errors->get('no_wa')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="link_linkedin" value="Tautan LinkedIn" />
                    <input
                        id="link_linkedin"
                        name="link_linkedin"
                        type="url"
                        value="{{ old('link_linkedin', $profile?->link_linkedin) }}"
                        maxlength="255"
                        placeholder="https://www.linkedin.com/in/username"
                        class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand"
                    >
                    <x-input-error :messages="$errors->get('link_linkedin')" class="mt-1.5" />
                </div>

                <div>
                    <x-input-label for="link_github" value="Tautan GitHub" />
                    <input
                        id="link_github"
                        name="link_github"
                        type="url"
                        value="{{ old('link_github', $profile?->link_github) }}"
                        maxlength="255"
                        placeholder="https://github.com/username"
                        class="mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand"
                    >
                    <x-input-error :messages="$errors->get('link_github')" class="mt-1.5" />
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <x-primary-button>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                Simpan profil
            </x-primary-button>
        </div>
    </form>
</x-admin-layout>
