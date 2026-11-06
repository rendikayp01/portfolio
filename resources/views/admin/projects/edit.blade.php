<x-admin-layout
    title="Edit proyek"
    heading="Edit proyek"
    description="Perbarui informasi proyek yang sudah ada."
>
    <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('admin.projects.partials.form', [
            'project' => $project,
            'submitLabel' => 'Simpan perubahan',
        ])
    </form>
</x-admin-layout>
