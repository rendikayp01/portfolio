<x-admin-layout
    title="Tambah keahlian"
    heading="Tambah keahlian"
    description="Tambahkan keahlian baru ke dalam daftar portofolio."
>
    <form method="POST" action="{{ route('admin.skills.store') }}">
        @csrf

        @include('admin.skills.partials.form', [
            'skill' => null,
            'submitLabel' => 'Simpan keahlian',
        ])
    </form>
</x-admin-layout>
