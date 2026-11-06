<x-admin-layout
    title="Edit riwayat"
    heading="Edit riwayat"
    description="Perbarui informasi riwayat yang sudah ada."
>
    <form method="POST" action="{{ route('admin.experiences.update', $experience) }}">
        @csrf
        @method('PUT')

        @include('admin.experiences.partials.form', [
            'experience' => $experience,
            'submitLabel' => 'Simpan perubahan',
        ])
    </form>
</x-admin-layout>
