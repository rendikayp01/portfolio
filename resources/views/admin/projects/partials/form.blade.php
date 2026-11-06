@php
    $project = $project ?? null;
    $inputClass = 'mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand';
    $textareaClass = $inputClass.' leading-relaxed';
    $maxTahun = now()->year + 1;
@endphp

<div class="space-y-5">
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <div class="border-b border-slate-100 pb-4">
            <h2 class="text-base font-semibold text-ink">Informasi dasar</h2>
            <p class="mt-1 text-sm text-muted">Judul, ringkasan singkat, dan klasifikasi proyek.</p>
        </div>

        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <x-input-label for="judul" value="Judul proyek" />
                <input
                    id="judul"
                    name="judul"
                    type="text"
                    value="{{ old('judul', $project?->judul) }}"
                    maxlength="150"
                    required
                    autofocus
                    placeholder="Contoh: Sistem Informasi Arsip Sekolah"
                    class="{{ $inputClass }}"
                >
                <p class="mt-1.5 text-xs text-muted">Slug URL dibuat otomatis dari judul dan diperbarui saat judul berubah.</p>
                <x-input-error :messages="$errors->get('judul')" class="mt-1.5" />
            </div>

            <div class="sm:col-span-2" x-data="{ length: $refs.ringkasan?.value.length ?? 0 }">
                <div class="flex items-center justify-between gap-2">
                    <x-input-label for="ringkasan" value="Ringkasan" />
                    <span class="text-xs text-muted"><span x-text="length"></span>/300</span>
                </div>
                <textarea
                    id="ringkasan"
                    name="ringkasan"
                    rows="3"
                    maxlength="300"
                    required
                    x-ref="ringkasan"
                    @input="length = $event.target.value.length"
                    placeholder="Ringkasan satu atau dua kalimat yang tampil pada kartu proyek."
                    class="{{ $textareaClass }}"
                >{{ old('ringkasan', $project?->ringkasan) }}</textarea>
                <x-input-error :messages="$errors->get('ringkasan')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="kategori" value="Kategori" />
                <input
                    id="kategori"
                    name="kategori"
                    type="text"
                    list="daftar-kategori"
                    value="{{ old('kategori', $project?->kategori) }}"
                    maxlength="100"
                    required
                    placeholder="Contoh: Web Application"
                    class="{{ $inputClass }}"
                >
                <datalist id="daftar-kategori">
                    <option value="Web Application"></option>
                    <option value="Company Profile"></option>
                    <option value="Pengolahan Data"></option>
                    <option value="Administrasi"></option>
                </datalist>
                <x-input-error :messages="$errors->get('kategori')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="peran" value="Peran Anda" />
                <input
                    id="peran"
                    name="peran"
                    type="text"
                    value="{{ old('peran', $project?->peran) }}"
                    maxlength="100"
                    required
                    placeholder="Contoh: Full-stack Developer"
                    class="{{ $inputClass }}"
                >
                <x-input-error :messages="$errors->get('peran')" class="mt-1.5" />
            </div>

            <div class="sm:col-span-2">
                <x-input-label for="teknologi" value="Teknologi yang digunakan" />
                <input
                    id="teknologi"
                    name="teknologi"
                    type="text"
                    value="{{ old('teknologi', $project?->teknologi) }}"
                    maxlength="200"
                    required
                    placeholder="Laravel, MySQL, Tailwind CSS"
                    class="{{ $inputClass }}"
                >
                <p class="mt-1.5 text-xs text-muted">Pisahkan setiap teknologi dengan koma.</p>
                <x-input-error :messages="$errors->get('teknologi')" class="mt-1.5" />
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <div class="border-b border-slate-100 pb-4">
            <h2 class="text-base font-semibold text-ink">Detail proyek</h2>
            <p class="mt-1 text-sm text-muted">Jelaskan masalah, solusi, dan hasil dari proyek.</p>
        </div>

        <div class="mt-5 space-y-5">
            <div>
                <x-input-label for="deskripsi_masalah" value="Masalah" />
                <textarea
                    id="deskripsi_masalah"
                    name="deskripsi_masalah"
                    rows="4"
                    required
                    placeholder="Masalah apa yang ingin diselesaikan?"
                    class="{{ $textareaClass }}"
                >{{ old('deskripsi_masalah', $project?->deskripsi_masalah) }}</textarea>
                <x-input-error :messages="$errors->get('deskripsi_masalah')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="deskripsi_solusi" value="Solusi" />
                <textarea
                    id="deskripsi_solusi"
                    name="deskripsi_solusi"
                    rows="4"
                    required
                    placeholder="Bagaimana Anda menyelesaikannya?"
                    class="{{ $textareaClass }}"
                >{{ old('deskripsi_solusi', $project?->deskripsi_solusi) }}</textarea>
                <x-input-error :messages="$errors->get('deskripsi_solusi')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="deskripsi_hasil" value="Hasil" />
                <textarea
                    id="deskripsi_hasil"
                    name="deskripsi_hasil"
                    rows="4"
                    required
                    placeholder="Apa dampak atau hasil yang dicapai?"
                    class="{{ $textareaClass }}"
                >{{ old('deskripsi_hasil', $project?->deskripsi_hasil) }}</textarea>
                <x-input-error :messages="$errors->get('deskripsi_hasil')" class="mt-1.5" />
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <div class="border-b border-slate-100 pb-4">
            <h2 class="text-base font-semibold text-ink">Gambar & publikasi</h2>
            <p class="mt-1 text-sm text-muted">Unggah gambar utama, atur urutan tampil, dan tentukan status proyek.</p>
        </div>

        <div class="mt-5 grid gap-5 lg:grid-cols-2">
            <div x-data="{ preview: null }">
                <x-input-label for="gambar" value="Gambar proyek" />
                <input
                    id="gambar"
                    name="gambar"
                    type="file"
                    accept="image/jpeg,image/png,image/webp"
                    x-ref="gambar"
                    @change="const file = $event.target.files[0]; preview = file ? URL.createObjectURL(file) : null"
                    class="mt-1.5 block w-full cursor-pointer rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-brand/10 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-brand-dark hover:file:bg-brand/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand"
                >
                <p class="mt-1.5 text-xs text-muted">JPG, PNG, atau WebP. Maksimal 2 MB. Rasio yang disarankan 16:9.</p>
                <x-input-error :messages="$errors->get('gambar')" class="mt-1.5" />

                <div class="mt-3">
                    <template x-if="preview">
                        <div>
                            <p class="mb-1.5 text-xs font-medium text-slate-500">Pratinjau gambar baru</p>
                            <img :src="preview" alt="Pratinjau gambar baru" class="h-44 w-full rounded-xl border border-slate-200 object-cover">
                        </div>
                    </template>

                    @if ($project?->gambarUrl())
                        <div x-show="!preview">
                            <p class="mb-1.5 text-xs font-medium text-slate-500">Gambar saat ini</p>
                            <img src="{{ $project->gambarUrl() }}" alt="Gambar {{ $project->judul }}" class="h-44 w-full rounded-xl border border-slate-200 object-cover">
                            <p class="mt-1.5 text-xs text-muted">Biarkan kolom file kosong jika tidak ingin mengganti gambar.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-5">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <x-input-label for="tahun" value="Tahun" />
                        <input
                            id="tahun"
                            name="tahun"
                            type="number"
                            value="{{ old('tahun', $project?->tahun) }}"
                            min="2000"
                            max="{{ $maxTahun }}"
                            required
                            placeholder="{{ now()->year }}"
                            class="{{ $inputClass }}"
                        >
                        <x-input-error :messages="$errors->get('tahun')" class="mt-1.5" />
                    </div>

                    <div>
                        <x-input-label for="urutan" value="Urutan tampil" />
                        <input
                            id="urutan"
                            name="urutan"
                            type="number"
                            value="{{ old('urutan', $project?->urutan ?? 0) }}"
                            min="0"
                            max="9999"
                            required
                            class="{{ $inputClass }}"
                        >
                        <p class="mt-1.5 text-xs text-muted">Angka kecil tampil lebih dulu.</p>
                        <x-input-error :messages="$errors->get('urutan')" class="mt-1.5" />
                    </div>
                </div>

                <fieldset>
                    <legend class="block text-sm font-medium text-slate-700">Status</legend>
                    <div class="mt-2 grid gap-2">
                        @foreach (\App\Models\Project::statusLabels() as $value => $label)
                            <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 p-3 transition hover:border-brand/40 hover:bg-brand/5 has-[:checked]:border-brand has-[:checked]:bg-brand/5">
                                <input
                                    type="radio"
                                    name="status"
                                    value="{{ $value }}"
                                    @checked(old('status', $project?->status ?? \App\Models\Project::STATUS_DRAFT) === $value)
                                    class="mt-0.5 border-slate-300 text-brand focus:ring-brand"
                                >
                                <span>
                                    <span class="block text-sm font-semibold text-ink">{{ $label }}</span>
                                    <span class="block text-xs text-muted">
                                        {{ $value === \App\Models\Project::STATUS_TAMPIL ? 'Tampil di halaman publik portofolio.' : 'Disimpan sebagai draf dan tidak tampil di publik.' }}
                                    </span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('status')" class="mt-1.5" />
                </fieldset>
            </div>
        </div>
    </div>

    <div class="flex flex-col-reverse items-stretch gap-3 sm:flex-row sm:items-center sm:justify-end">
        <a
            href="{{ route('admin.projects.index') }}"
            class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand focus-visible:ring-offset-2"
        >
            Batal
        </a>

        <x-primary-button>
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
            {{ $submitLabel }}
        </x-primary-button>
    </div>
</div>
