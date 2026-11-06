<?php

namespace Tests\Feature\Admin;

use App\Models\CvFile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CvFileAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_guests_are_redirected_to_login_from_cv_file_routes(): void
    {
        $cvFile = CvFile::factory()->create();

        $this->get(route('admin.cv-files.index'))->assertRedirect(route('login'));
        $this->post(route('admin.cv-files.store'), [
            'file_pdf' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
        ])->assertRedirect(route('login'));
        $this->patch(route('admin.cv-files.activate', $cvFile))->assertRedirect(route('login'));
        $this->delete(route('admin.cv-files.destroy', $cvFile))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_the_cv_file_index(): void
    {
        $user = User::factory()->create();
        $cvFile = CvFile::factory()->aktif()->create([
            'file_pdf' => 'cv/cv-aktif.pdf',
        ]);

        $this->actingAs($user)
            ->get(route('admin.cv-files.index'))
            ->assertOk()
            ->assertSee('cv-aktif.pdf')
            ->assertSee('Aktif');
    }

    public function test_first_uploaded_cv_file_is_activated_automatically(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.cv-files.store'), [
                'file_pdf' => UploadedFile::fake()->create('cv-baru.pdf', 300, 'application/pdf'),
            ])
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success', 'File CV berhasil diunggah dan langsung diaktifkan.');

        $cvFile = CvFile::query()->sole();

        $this->assertTrue($cvFile->aktif);
        $this->assertStringStartsWith('cv/', $cvFile->file_pdf);
        Storage::disk('public')->assertExists($cvFile->file_pdf);
    }

    public function test_second_uploaded_cv_file_is_not_activated_automatically(): void
    {
        $user = User::factory()->create();
        CvFile::factory()->aktif()->create(['file_pdf' => 'cv/cv-lama.pdf']);

        $this->actingAs($user)
            ->post(route('admin.cv-files.store'), [
                'file_pdf' => UploadedFile::fake()->create('cv-baru.pdf', 300, 'application/pdf'),
            ])
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success', 'File CV berhasil diunggah. Aktifkan jika ingin dipakai di website.');

        $newFile = CvFile::query()->latest('id')->first();

        $this->assertFalse($newFile->aktif);
        $this->assertSame(1, CvFile::query()->where('aktif', true)->count());
    }

    public function test_activating_a_cv_file_deactivates_the_previous_one(): void
    {
        $user = User::factory()->create();
        $oldFile = CvFile::factory()->aktif()->create(['file_pdf' => 'cv/cv-lama.pdf']);
        $newFile = CvFile::factory()->create(['file_pdf' => 'cv/cv-baru.pdf']);

        $this->actingAs($user)
            ->patch(route('admin.cv-files.activate', $newFile))
            ->assertSessionHas('success', 'File CV berhasil diaktifkan.');

        $this->assertFalse($oldFile->refresh()->aktif);
        $this->assertTrue($newFile->refresh()->aktif);
    }

    public function test_deleting_an_active_cv_file_removes_the_file_and_activates_another(): void
    {
        $user = User::factory()->create();
        $activeFile = CvFile::factory()->aktif()->create(['file_pdf' => 'cv/cv-lama.pdf']);
        $otherFile = CvFile::factory()->create(['file_pdf' => 'cv/cv-cadangan.pdf']);

        Storage::disk('public')->put('cv/cv-lama.pdf', 'pdf lama');
        Storage::disk('public')->put('cv/cv-cadangan.pdf', 'pdf cadangan');

        $this->actingAs($user)
            ->delete(route('admin.cv-files.destroy', $activeFile))
            ->assertSessionHas('success', 'File CV berhasil dihapus.');

        $this->assertDatabaseMissing('cv_files', ['id' => $activeFile->id]);
        Storage::disk('public')->assertMissing('cv/cv-lama.pdf');
        $this->assertTrue($otherFile->refresh()->aktif);
    }

    public function test_cv_upload_rejects_non_pdf_files(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.cv-files.store'), [
                'file_pdf' => UploadedFile::fake()->create('cv.docx', 100, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
            ])
            ->assertSessionHasErrors(['file_pdf' => 'File CV harus berformat PDF.']);

        $this->assertDatabaseCount('cv_files', 0);
    }

    public function test_cv_upload_rejects_files_larger_than_five_megabytes(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.cv-files.store'), [
                'file_pdf' => UploadedFile::fake()->create('cv-besar.pdf', 5121, 'application/pdf'),
            ])
            ->assertSessionHasErrors(['file_pdf' => 'Ukuran file CV maksimal 5 MB.']);

        $this->assertDatabaseCount('cv_files', 0);
    }
}
