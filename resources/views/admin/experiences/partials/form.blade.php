@php
    $experience = $experience ?? null;
    $inputClass = 'mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand';
    $maxTahun = now()->year + 1;
@endphp

<div
    class="space-y-5"
    x-data="{ tipe: '{{ old('tipe', $experience?->tipe ?? \App\Models\Experience::TIPE_PENGALAMAN) }}' }"
>
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <div class="border-b border-slate-100 pb-4">
            <h2 class="text-base font-semibold text-ink">Detail riwayat</h2>
            <p class="mt-1 text-sm text-muted">Pilih tipe riwayat, lalu lengkapi informasi dan periodenya.</p>
        </div>

        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <x-input-label for="tipe" value="Tipe riwayat" />
                <select
                    id="tipe"
                    name="tipe"
                    required
                    x-model="tipe"
                    class="{{ $inputClass }}"
                >
                    @foreach ($tipeLabels as $value => $label)
                        <option value="{{ $value }}" @selected(old('tipe', $experience?->tipe ?? \App\Models\Experience::TIPE_PENGALAMAN) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('tipe')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="judul" value="Judul" />
                <input
                    id="judul"
                    name="judul"
                    type="text"
                    value="{{ old('judul', $experience?->judul) }}"
                    maxlength="150"
                    required
                    autofocus
                    placeholder="Contoh: S1 Teknik Informatika"
                    class="{{ $inputClass }}"
                >
                <p class="mt-1.5 text-xs text-muted">Untuk sertifikat, isi nama sertifikasinya.</p>
                <x-input-error :messages="$errors->get('judul')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="institusi" value="Institusi / Penerbit" />
                <input
                    id="institusi"
                    name="institusi"
                    type="text"
                    value="{{ old('institusi', $experience?->institusi) }}"
                    maxlength="150"
                    required
                    placeholder="Contoh: Universitas Nusantara"
                    class="{{ $inputClass }}"
                >
                <x-input-error :messages="$errors->get('institusi')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="tahun_mulai" value="Tahun mulai" />
                <input
                    id="tahun_mulai"
                    name="tahun_mulai"
                    type="number"
                    value="{{ old('tahun_mulai', $experience?->tahun_mulai) }}"
                    min="1950"
                    max="{{ $maxTahun }}"
                    required
                    placeholder="{{ now()->year }}"
                    class="{{ $inputClass }}"
                >
                <x-input-error :messages="$errors->get('tahun_mulai')" class="mt-1.5" />
            </div>

            <div x-show="tipe !== '{{ \App\Models\Experience::TIPE_SERTIFIKAT }}'" x-cloak>
                <x-input-label for="tahun_selesai" value="Tahun selesai" />
                <input
                    id="tahun_selesai"
                    name="tahun_selesai"
                    type="number"
                    value="{{ old('tahun_selesai', $experience?->tahun_selesai) }}"
                    min="1950"
                    max="{{ $maxTahun }}"
                    :disabled="tipe === '{{ \App\Models\Experience::TIPE_SERTIFIKAT }}'"
                    placeholder="{{ now()->year }}"
                    class="{{ $inputClass }}"
                >
                <p class="mt-1.5 text-xs text-muted">Kosongkan jika masih berlangsung.</p>
                <x-input-error :messages="$errors->get('tahun_selesai')" class="mt-1.5" />
            </div>

            <div class="sm:col-span-2">
                <x-input-label for="deskripsi" value="Deskripsi" />
                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="4"
                    placeholder="Jelaskan peran, kegiatan, atau pencapaian (opsional)."
                    class="{{ $inputClass }} leading-relaxed"
                >{{ old('deskripsi', $experience?->deskripsi) }}</textarea>
                <x-input-error :messages="$errors->get('deskripsi')" class="mt-1.5" />
            </div>
        </div>
    </div>

    <div class="flex flex-col-reverse items-stretch gap-3 sm:flex-row sm:items-center sm:justify-end">
        <a
            href="{{ route('admin.experiences.index') }}"
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
