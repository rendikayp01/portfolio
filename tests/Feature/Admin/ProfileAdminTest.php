<?php

namespace Tests\Feature\Admin;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_guests_are_redirected_to_login_from_profile_routes(): void
    {
        $this->get(route('admin.profile.edit'))->assertRedirect(route('login'));
        $this->put(route('admin.profile.update'), $this->validPayload())->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_the_profile_form(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'nama' => 'Nama Pemilik',
            'headline' => 'Web Developer',
        ]);

        $this->actingAs($user)
            ->get(route('admin.profile.edit'))
            ->assertOk()
            ->assertSee('Nama Pemilik')
            ->assertSee('Web Developer');
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create();

        $response = $this->actingAs($user)->put(route('admin.profile.update'), array_merge(
            $this->validPayload(),
            [
                'nama' => 'Budi Santoso',
                'headline' => 'Web Developer & Data Analyst',
                'email' => 'budi@example.com',
            ],
        ));

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.profile.edit'))
            ->assertSessionHas('success', 'Profil berhasil diperbarui.');

        $profile->refresh();

        $this->assertSame('Budi Santoso', $profile->nama);
        $this->assertSame('Web Developer & Data Analyst', $profile->headline);
        $this->assertSame('budi@example.com', $profile->email);
    }

    public function test_profile_is_created_when_none_exists(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseCount('profiles', 0);

        $this->actingAs($user)
            ->put(route('admin.profile.update'), $this->validPayload())
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('profiles', 1);
        $this->assertSame('Nama Pemilik', Profile::query()->sole()->nama);
    }

    public function test_profile_photo_is_uploaded_and_old_photo_is_removed(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'foto' => 'profile/foto-lama.jpg',
        ]);

        Storage::disk('public')->put('profile/foto-lama.jpg', 'foto lama');

        $this->actingAs($user)
            ->put(route('admin.profile.update'), array_merge(
                $this->validPayload(),
                ['foto' => UploadedFile::fake()->image('foto-baru.png', 600, 600)],
            ))
            ->assertSessionHasNoErrors();

        $profile->refresh();

        $this->assertNotSame('profile/foto-lama.jpg', $profile->foto);
        Storage::disk('public')->assertMissing('profile/foto-lama.jpg');
        Storage::disk('public')->assertExists($profile->foto);
    }

    public function test_existing_photo_is_kept_when_no_new_file_is_sent(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'foto' => 'profile/foto-lama.jpg',
        ]);

        Storage::disk('public')->put('profile/foto-lama.jpg', 'foto lama');

        $this->actingAs($user)
            ->put(route('admin.profile.update'), $this->validPayload())
            ->assertSessionHasNoErrors();

        $this->assertSame('profile/foto-lama.jpg', $profile->refresh()->foto);
        Storage::disk('public')->assertExists('profile/foto-lama.jpg');
    }

    public function test_profile_validation_uses_indonesian_messages(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.profile.update'), [])
            ->assertSessionHasErrors([
                'nama' => 'Nama lengkap wajib diisi.',
                'headline' => 'Headline wajib diisi.',
                'bio' => 'Bio wajib diisi.',
                'email' => 'Email wajib diisi.',
                'no_wa' => 'Nomor WhatsApp wajib diisi.',
            ]);
    }

    public function test_profile_email_must_be_unique(): void
    {
        $user = User::factory()->create();
        Profile::factory()->create(['email' => 'milik-saya@example.com']);
        Profile::factory()->create(['email' => 'dipakai@example.com']);

        $this->actingAs($user)
            ->put(route('admin.profile.update'), array_merge(
                $this->validPayload(),
                ['email' => 'dipakai@example.com'],
            ))
            ->assertSessionHasErrors(['email' => 'Email tersebut sudah dipakai.']);
    }

    public function test_profile_photo_rejects_files_larger_than_two_megabytes(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.profile.update'), array_merge(
                $this->validPayload(),
                ['foto' => UploadedFile::fake()->image('besar.png')->size(2049)],
            ))
            ->assertSessionHasErrors(['foto' => 'Ukuran foto maksimal 2 MB.']);
    }

    /**
     * @return array<string, mixed>
     */
    private function validPayload(): array
    {
        return [
            'nama' => 'Nama Pemilik',
            'headline' => 'Web Developer · Pengolahan Data',
            'bio' => 'Saya adalah web developer yang juga terbiasa mengolah data.',
            'email' => 'pemilik@example.com',
            'no_wa' => '6281234567890',
            'link_linkedin' => 'https://www.linkedin.com/in/pemilik',
            'link_github' => 'https://github.com/pemilik',
        ];
    }
}
