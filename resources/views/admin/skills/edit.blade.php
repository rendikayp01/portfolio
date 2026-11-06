<x-admin-layout
    title="Edit keahlian"
    heading="Edit keahlian"
    description="Perbarui informasi keahlian yang sudah ada."
>
    <form method="POST" action="{{ route('admin.skills.update', $skill) }}">
        @csrf
        @method('PUT')

        @include('admin.skills.partials.form', [
            'skill' => $skill,
            'submitLabel' => 'Simpan perubahan',
        ])
    </form>
</x-admin-layout>
