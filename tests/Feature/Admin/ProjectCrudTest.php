<?php

namespace Tests\Feature\Admin;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_guests_are_redirected_to_login_from_admin_project_routes(): void
    {
        $project = Project::factory()->create();

        $this->get(route('admin.projects.index'))->assertRedirect(route('login'));
        $this->get(route('admin.projects.create'))->assertRedirect(route('login'));
        $this->get(route('admin.projects.edit', $project))->assertRedirect(route('login'));
        $this->post(route('admin.projects.store'), $this->validPayload())->assertRedirect(route('login'));
        $this->put(route('admin.projects.update', $project), $this->validPayload())->assertRedirect(route('login'));
        $this->delete(route('admin.projects.destroy', $project))->assertRedirect(route('login'));

        $this->assertDatabaseCount('projects', 1);
    }

    public function test_authenticated_user_can_view_project_index(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'judul' => 'Website Profil Sekolah',
            'status' => Project::STATUS_TAMPIL,
        ]);

        $this->actingAs($user)
            ->get(route('admin.projects.index'))
            ->assertOk()
            ->assertSee('Website Profil Sekolah')
            ->assertSee('/'.$project->slug);
    }

    public function test_authenticated_user_can_view_create_and_edit_forms(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'judul' => 'Website Profil Sekolah',
        ]);

        $this->actingAs($user)
            ->get(route('admin.projects.create'))
            ->assertOk()
            ->assertSee('Tambah proyek')
            ->assertSee('enctype="multipart/form-data"', false);

        $this->actingAs($user)
            ->get(route('admin.projects.edit', $project))
            ->assertOk()
            ->assertSee('Edit proyek')
            ->assertSee('Website Profil Sekolah');
    }

    public function test_project_index_can_be_filtered_by_search_and_status(): void
    {
        $user = User::factory()->create();

        Project::factory()->create([
            'judul' => 'Website Sekolah',
            'slug' => 'website-sekolah',
            'status' => Project::STATUS_TAMPIL,
        ]);

        Project::factory()->create([
            'judul' => 'Aplikasi Arsip',
            'slug' => 'aplikasi-arsip',
            'status' => Project::STATUS_DRAFT,
        ]);

        $this->actingAs($user)
            ->get(route('admin.projects.index', ['q' => 'Website']))
            ->assertOk()
            ->assertSee('Website Sekolah')
            ->assertDontSee('Aplikasi Arsip');

        $this->actingAs($user)
            ->get(route('admin.projects.index', ['status' => Project::STATUS_DRAFT]))
            ->assertOk()
            ->assertSee('Aplikasi Arsip')
            ->assertDontSee('Website Sekolah');
    }

    public function test_authenticated_user_can_create_a_project_with_an_automatic_slug(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.projects.store'), array_merge(
            $this->validPayload(),
            ['judul' => 'Website Profil Sekolah'],
        ));

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.projects.index'))
            ->assertSessionHas('success', 'Proyek berhasil ditambahkan.');

        $project = Project::query()->sole();

        $this->assertSame('website-profil-sekolah', $project->slug);
        $this->assertSame('Website Profil Sekolah', $project->judul);
        $this->assertSame(Project::STATUS_TAMPIL, $project->status);
    }

    public function test_duplicate_titles_receive_a_unique_slug_suffix(): void
    {
        $user = User::factory()->create();

        Project::factory()->create([
            'judul' => 'Website Sekolah',
            'slug' => 'website-sekolah',
        ]);

        $this->actingAs($user)
            ->post(route('admin.projects.store'), array_merge(
                $this->validPayload(),
                ['judul' => 'Website Sekolah'],
            ))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('projects', [
            'judul' => 'Website Sekolah',
            'slug' => 'website-sekolah-2',
        ]);
    }

    public function test_project_image_is_uploaded_on_create(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.projects.store'), array_merge(
                $this->validPayload(),
                ['gambar' => UploadedFile::fake()->image('proyek.png', 1200, 675)],
            ))
            ->assertSessionHasNoErrors();

        $project = Project::query()->sole();

        $this->assertNotNull($project->gambar);
        $this->assertStringStartsWith('projects/', $project->gambar);
        Storage::disk('public')->assertExists($project->gambar);
    }

    public function test_authenticated_user_can_update_a_project_and_replace_its_image(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'judul' => 'Judul Lama',
            'slug' => 'judul-lama',
            'gambar' => 'projects/gambar-lama.jpg',
        ]);

        Storage::disk('public')->put('projects/gambar-lama.jpg', 'gambar lama');

        $response = $this->actingAs($user)->put(route('admin.projects.update', $project), array_merge(
            $this->validPayload(),
            [
                'judul' => 'Judul Baru',
                'gambar' => UploadedFile::fake()->image('gambar-baru.png', 1200, 675),
            ],
        ));

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.projects.index'))
            ->assertSessionHas('success', 'Proyek berhasil diperbarui.');

        $project->refresh();

        $this->assertSame('Judul Baru', $project->judul);
        $this->assertSame('judul-baru', $project->slug);
        $this->assertNotSame('projects/gambar-lama.jpg', $project->gambar);
        Storage::disk('public')->assertMissing('projects/gambar-lama.jpg');
        Storage::disk('public')->assertExists($project->gambar);
    }

    public function test_existing_image_is_kept_when_update_does_not_send_a_new_file(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'gambar' => 'projects/gambar-lama.jpg',
        ]);

        Storage::disk('public')->put('projects/gambar-lama.jpg', 'gambar lama');

        $this->actingAs($user)
            ->put(route('admin.projects.update', $project), $this->validPayload())
            ->assertSessionHasNoErrors();

        $project->refresh();

        $this->assertSame('projects/gambar-lama.jpg', $project->gambar);
        Storage::disk('public')->assertExists('projects/gambar-lama.jpg');
    }

    public function test_slug_stays_the_same_when_title_is_not_changed(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'judul' => 'Website Sekolah',
            'slug' => 'website-sekolah',
        ]);

        $this->actingAs($user)
            ->put(route('admin.projects.update', $project), array_merge(
                $this->validPayload(),
                ['judul' => 'Website Sekolah', 'ringkasan' => 'Ringkasan yang diperbarui.'],
            ))
            ->assertSessionHasNoErrors();

        $this->assertSame('website-sekolah', $project->refresh()->slug);
    }

    public function test_authenticated_user_can_delete_a_project_and_its_image(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'gambar' => 'projects/gambar.jpg',
        ]);

        Storage::disk('public')->put('projects/gambar.jpg', 'gambar');

        $this->actingAs($user)
            ->delete(route('admin.projects.destroy', $project))
            ->assertRedirect(route('admin.projects.index'))
            ->assertSessionHas('success', 'Proyek berhasil dihapus.');

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
        Storage::disk('public')->assertMissing('projects/gambar.jpg');
    }

    public function test_project_validation_uses_indonesian_messages(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.projects.store'), []);

        $response->assertSessionHasErrors([
            'judul' => 'Judul proyek wajib diisi.',
            'ringkasan' => 'Ringkasan proyek wajib diisi.',
            'deskripsi_masalah' => 'Bagian masalah wajib diisi.',
            'deskripsi_solusi' => 'Bagian solusi wajib diisi.',
            'deskripsi_hasil' => 'Bagian hasil wajib diisi.',
            'kategori' => 'Kategori proyek wajib diisi.',
            'teknologi' => 'Teknologi yang digunakan wajib diisi.',
            'peran' => 'Peran Anda dalam proyek wajib diisi.',
            'tahun' => 'Tahun proyek wajib diisi.',
            'urutan' => 'Urutan tampil wajib diisi.',
            'status' => 'Status proyek wajib dipilih.',
        ]);

        $this->assertDatabaseCount('projects', 0);
    }

    public function test_image_upload_rejects_files_larger_than_two_megabytes(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.projects.store'), array_merge(
                $this->validPayload(),
                ['gambar' => UploadedFile::fake()->image('besar.png')->size(2049)],
            ))
            ->assertSessionHasErrors(['gambar' => 'Ukuran gambar maksimal 2 MB.']);

        $this->assertDatabaseCount('projects', 0);
    }

    public function test_image_upload_rejects_non_image_files(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.projects.store'), array_merge(
                $this->validPayload(),
                ['gambar' => UploadedFile::fake()->create('dokumen.pdf', 200, 'application/pdf')],
            ))
            ->assertSessionHasErrors('gambar');

        $this->assertDatabaseCount('projects', 0);
    }

    /**
     * Payload valid untuk formulir proyek.
     *
     * @return array<string, mixed>
     */
    private function validPayload(): array
    {
        return [
            'judul' => 'Sistem Informasi Arsip',
            'ringkasan' => 'Aplikasi web untuk mengelola arsip sekolah secara digital.',
            'deskripsi_masalah' => 'Arsip masih disimpan dalam lemari fisik dan sulit dicari.',
            'deskripsi_solusi' => 'Membangun aplikasi Laravel dengan pencarian dan unggah PDF.',
            'deskripsi_hasil' => 'Pencarian dokumen menjadi lebih cepat dan rapi.',
            'kategori' => 'Web Application',
            'teknologi' => 'Laravel, MySQL, Tailwind CSS',
            'peran' => 'Full-stack Developer',
            'tahun' => 2024,
            'urutan' => 1,
            'status' => Project::STATUS_TAMPIL,
        ];
    }
}
