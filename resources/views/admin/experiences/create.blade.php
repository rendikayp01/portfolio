<x-admin-layout
    title="Tambah riwayat"
    heading="Tambah riwayat"
    description="Tambahkan pendidikan, pengalaman kerja, atau sertifikat baru."
>
    <form method="POST" action="{{ route('admin.experiences.store') }}">
        @csrf

        @include('admin.experiences.partials.form', [
            'experience' => null,
            'submitLabel' => 'Simpan riwayat',
        ])
    </form>
</x-admin-layout>
