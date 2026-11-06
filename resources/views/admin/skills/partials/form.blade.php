@php
    $skill = $skill ?? null;
    $inputClass = 'mt-1.5 block w-full rounded-lg border-slate-300 bg-white text-sm text-ink shadow-sm transition placeholder:text-slate-400 focus:border-brand focus:ring-brand';
@endphp

<div class="space-y-5">
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <div class="border-b border-slate-100 pb-4">
            <h2 class="text-base font-semibold text-ink">Detail keahlian</h2>
            <p class="mt-1 text-sm text-muted">Nama, kategori, dan penjelasan singkat keahlian.</p>
        </div>

        <div class="mt-5 grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <x-input-label for="nama" value="Nama keahlian" />
                <input
                    id="nama"
                    name="nama"
                    type="text"
                    value="{{ old('nama', $skill?->nama) }}"
                    maxlength="100"
                    required
                    autofocus
                    placeholder="Contoh: Microsoft Excel"
                    class="{{ $inputClass }}"
                >
                <x-input-error :messages="$errors->get('nama')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="kategori" value="Kategori" />
                <select id="kategori" name="kategori" required class="{{ $inputClass }}">
                    <option value="" disabled @selected(old('kategori', $skill?->kategori) === null)>Pilih kategori</option>
                    @foreach ($kategoriLabels as $value => $label)
                        <option value="{{ $value }}" @selected(old('kategori', $skill?->kategori) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('kategori')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="urutan" value="Urutan tampil" />
                <input
                    id="urutan"
                    name="urutan"
                    type="number"
                    value="{{ old('urutan', $skill?->urutan ?? 0) }}"
                    min="0"
                    max="9999"
                    required
                    class="{{ $inputClass }}"
                >
                <p class="mt-1.5 text-xs text-muted">Angka kecil tampil lebih dulu.</p>
                <x-input-error :messages="$errors->get('urutan')" class="mt-1.5" />
            </div>

            <div class="sm:col-span-2">
                <x-input-label for="deskripsi" value="Deskripsi" />
                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="4"
                    maxlength="255"
                    required
                    placeholder="Jelaskan secara singkat kemampuan pada keahlian ini."
                    class="{{ $inputClass }} leading-relaxed"
                >{{ old('deskripsi', $skill?->deskripsi) }}</textarea>
                <x-input-error :messages="$errors->get('deskripsi')" class="mt-1.5" />
            </div>
        </div>
    </div>

    <div class="flex flex-col-reverse items-stretch gap-3 sm:flex-row sm:items-center sm:justify-end">
        <a
            href="{{ route('admin.skills.index') }}"
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
