<?php

namespace Tests\Feature\Admin;

use App\Models\Experience;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExperienceCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login_from_experience_routes(): void
    {
        $experience = Experience::factory()->create();

        $this->get(route('admin.experiences.index'))->assertRedirect(route('login'));
        $this->get(route('admin.experiences.create'))->assertRedirect(route('login'));
        $this->get(route('admin.experiences.edit', $experience))->assertRedirect(route('login'));
        $this->post(route('admin.experiences.store'), $this->validPayload())->assertRedirect(route('login'));
        $this->put(route('admin.experiences.update', $experience), $this->validPayload())->assertRedirect(route('login'));
        $this->delete(route('admin.experiences.destroy', $experience))->assertRedirect(route('login'));

        $this->assertDatabaseCount('experiences', 1);
    }

    public function test_authenticated_user_can_view_the_experience_index(): void
    {
        $user = User::factory()->create();
        Experience::factory()->pengalaman()->create([
            'judul' => 'Web Developer Freelance',
            'institusi' => 'Mandiri',
            'tahun_mulai' => 2023,
            'tahun_selesai' => null,
        ]);

        $this->actingAs($user)
            ->get(route('admin.experiences.index'))
            ->assertOk()
            ->assertSee('Web Developer Freelance')
            ->assertSee('Mandiri')
            ->assertSee('2023 – Sekarang');
    }

    public function test_experience_index_can_be_filtered_by_search_and_type(): void
    {
        $user = User::factory()->create();

        Experience::factory()->pendidikan()->create([
            'judul' => 'S1 Teknik Informatika',
            'institusi' => 'Universitas Nusantara',
        ]);
        Experience::factory()->sertifikat()->create([
            'judul' => 'Junior Web Developer',
            'institusi' => 'BNSP',
        ]);

        $this->actingAs($user)
            ->get(route('admin.experiences.index', ['q' => 'Universitas']))
            ->assertOk()
            ->assertSee('S1 Teknik Informatika')
            ->assertDontSee('Junior Web Developer');

        $this->actingAs($user)
            ->get(route('admin.experiences.index', ['tipe' => Experience::TIPE_SERTIFIKAT]))
            ->assertOk()
            ->assertSee('Junior Web Developer')
            ->assertDontSee('S1 Teknik Informatika');
    }

    public function test_authenticated_user_can_create_an_experience(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.experiences.store'), array_merge($this->validPayload(), [
                'tipe' => Experience::TIPE_PENGALAMAN,
                'judul' => 'Web Developer Freelance',
                'tahun_mulai' => 2023,
                'tahun_selesai' => 2024,
            ]))
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.experiences.index'))
            ->assertSessionHas('success', 'Riwayat berhasil ditambahkan.');

        $this->assertDatabaseHas('experiences', [
            'tipe' => Experience::TIPE_PENGALAMAN,
            'judul' => 'Web Developer Freelance',
            'tahun_mulai' => 2023,
            'tahun_selesai' => 2024,
        ]);
    }

    public function test_certificate_always_stores_an_empty_end_year(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.experiences.store'), array_merge($this->validPayload(), [
                'tipe' => Experience::TIPE_SERTIFIKAT,
                'judul' => 'Junior Web Developer',
                'tahun_mulai' => 2023,
                'tahun_selesai' => 2023,
            ]))
            ->assertSessionHasNoErrors();

        $experience = Experience::query()->sole();

        $this->assertSame(Experience::TIPE_SERTIFIKAT, $experience->tipe);
        $this->assertNull($experience->tahun_selesai);
    }

    public function test_authenticated_user_can_update_an_experience(): void
    {
        $user = User::factory()->create();
        $experience = Experience::factory()->pendidikan()->create([
            'judul' => 'D3 Teknik Informatika',
            'tahun_mulai' => 2019,
            'tahun_selesai' => 2022,
        ]);

        $this->actingAs($user)
            ->put(route('admin.experiences.update', $experience), array_merge($this->validPayload(), [
                'tipe' => Experience::TIPE_PENDIDIKAN,
                'judul' => 'S1 Teknik Informatika',
                'institusi' => 'Universitas Nusantara',
                'tahun_mulai' => 2019,
                'tahun_selesai' => 2023,
            ]))
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.experiences.index'))
            ->assertSessionHas('success', 'Riwayat berhasil diperbarui.');

        $experience->refresh();

        $this->assertSame('S1 Teknik Informatika', $experience->judul);
        $this->assertSame(2023, $experience->tahun_selesai);
    }

    public function test_authenticated_user_can_delete_an_experience(): void
    {
        $user = User::factory()->create();
        $experience = Experience::factory()->create();

        $this->actingAs($user)
            ->delete(route('admin.experiences.destroy', $experience))
            ->assertRedirect(route('admin.experiences.index'))
            ->assertSessionHas('success', 'Riwayat berhasil dihapus.');

        $this->assertDatabaseMissing('experiences', ['id' => $experience->id]);
    }

    public function test_experience_validation_uses_indonesian_messages(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.experiences.store'), [])
            ->assertSessionHasErrors([
                'tipe' => 'Tipe riwayat wajib dipilih.',
                'judul' => 'Judul wajib diisi.',
                'institusi' => 'Nama institusi wajib diisi.',
                'tahun_mulai' => 'Tahun mulai wajib diisi.',
            ]);
    }

    public function test_end_year_is_required_for_non_certificate_entries(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.experiences.store'), array_merge($this->validPayload(), [
                'tipe' => Experience::TIPE_PENGALAMAN,
                'tahun_mulai' => 2023,
                'tahun_selesai' => null,
            ]))
            ->assertSessionHasErrors([
                'tahun_selesai' => 'Tahun selesai wajib diisi untuk pendidikan dan pengalaman.',
            ]);
    }

    public function test_end_year_cannot_be_before_start_year(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.experiences.store'), array_merge($this->validPayload(), [
                'tipe' => Experience::TIPE_PENGALAMAN,
                'tahun_mulai' => 2023,
                'tahun_selesai' => 2020,
            ]))
            ->assertSessionHasErrors([
                'tahun_selesai' => 'Tahun selesai tidak boleh lebih awal dari tahun mulai.',
            ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function validPayload(): array
    {
        return [
            'tipe' => Experience::TIPE_PENGALAMAN,
            'judul' => 'Admin Data & Administrasi',
            'institusi' => 'PT Contoh Digital',
            'tahun_mulai' => 2022,
            'tahun_selesai' => 2023,
            'deskripsi' => 'Mengelola rekap data operasional dan menyusun laporan.',
        ];
    }
}
