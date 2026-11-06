<x-admin-layout
    title="Tambah proyek"
    heading="Tambah proyek"
    description="Lengkapi informasi proyek yang akan ditampilkan di portofolio."
>
    <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
        @csrf

        @include('admin.projects.partials.form', [
            'project' => null,
            'submitLabel' => 'Simpan proyek',
        ])
    </form>
</x-admin-layout>
