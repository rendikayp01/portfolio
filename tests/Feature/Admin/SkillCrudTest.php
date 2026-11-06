<?php

namespace Tests\Feature\Admin;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SkillCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login_from_skill_routes(): void
    {
        $skill = Skill::factory()->create();

        $this->get(route('admin.skills.index'))->assertRedirect(route('login'));
        $this->get(route('admin.skills.create'))->assertRedirect(route('login'));
        $this->get(route('admin.skills.edit', $skill))->assertRedirect(route('login'));
        $this->post(route('admin.skills.store'), $this->validPayload())->assertRedirect(route('login'));
        $this->put(route('admin.skills.update', $skill), $this->validPayload())->assertRedirect(route('login'));
        $this->delete(route('admin.skills.destroy', $skill))->assertRedirect(route('login'));

        $this->assertDatabaseCount('skills', 1);
    }

    public function test_authenticated_user_can_view_the_skill_index(): void
    {
        $user = User::factory()->create();
        Skill::factory()->create([
            'nama' => 'Microsoft Excel',
            'kategori' => Skill::KATEGORI_ADMINISTRASI,
        ]);

        $this->actingAs($user)
            ->get(route('admin.skills.index'))
            ->assertOk()
            ->assertSee('Microsoft Excel');
    }

    public function test_skill_index_can_be_filtered_by_search_and_category(): void
    {
        $user = User::factory()->create();

        Skill::factory()->create([
            'nama' => 'Microsoft Excel',
            'kategori' => Skill::KATEGORI_ADMINISTRASI,
        ]);
        Skill::factory()->create([
            'nama' => 'Laravel',
            'kategori' => Skill::KATEGORI_WEB,
        ]);

        $this->actingAs($user)
            ->get(route('admin.skills.index', ['q' => 'Excel']))
            ->assertOk()
            ->assertSee('Microsoft Excel')
            ->assertDontSee('Laravel');

        $this->actingAs($user)
            ->get(route('admin.skills.index', ['kategori' => Skill::KATEGORI_WEB]))
            ->assertOk()
            ->assertSee('Laravel')
            ->assertDontSee('Microsoft Excel');
    }

    public function test_authenticated_user_can_create_a_skill(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.skills.store'), array_merge($this->validPayload(), [
                'nama' => 'Power Query',
                'kategori' => Skill::KATEGORI_ADMINISTRASI,
            ]))
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.skills.index'))
            ->assertSessionHas('success', 'Keahlian berhasil ditambahkan.');

        $this->assertDatabaseHas('skills', [
            'nama' => 'Power Query',
            'kategori' => Skill::KATEGORI_ADMINISTRASI,
            'urutan' => 3,
        ]);
    }

    public function test_authenticated_user_can_update_a_skill(): void
    {
        $user = User::factory()->create();
        $skill = Skill::factory()->create([
            'nama' => 'Excel',
            'kategori' => Skill::KATEGORI_ADMINISTRASI,
        ]);

        $this->actingAs($user)
            ->put(route('admin.skills.update', $skill), array_merge($this->validPayload(), [
                'nama' => 'Excel Lanjutan',
                'kategori' => Skill::KATEGORI_WEB,
                'urutan' => 5,
            ]))
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.skills.index'))
            ->assertSessionHas('success', 'Keahlian berhasil diperbarui.');

        $skill->refresh();

        $this->assertSame('Excel Lanjutan', $skill->nama);
        $this->assertSame(Skill::KATEGORI_WEB, $skill->kategori);
        $this->assertSame(5, $skill->urutan);
    }

    public function test_authenticated_user_can_delete_a_skill(): void
    {
        $user = User::factory()->create();
        $skill = Skill::factory()->create();

        $this->actingAs($user)
            ->delete(route('admin.skills.destroy', $skill))
            ->assertRedirect(route('admin.skills.index'))
            ->assertSessionHas('success', 'Keahlian berhasil dihapus.');

        $this->assertDatabaseMissing('skills', ['id' => $skill->id]);
    }

    public function test_skill_validation_uses_indonesian_messages(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.skills.store'), [])
            ->assertSessionHasErrors([
                'nama' => 'Nama keahlian wajib diisi.',
                'deskripsi' => 'Deskripsi keahlian wajib diisi.',
                'kategori' => 'Kategori keahlian wajib dipilih.',
                'urutan' => 'Urutan tampil wajib diisi.',
            ]);

        $this->assertDatabaseCount('skills', 0);
    }

    /**
     * @return array<string, mixed>
     */
    private function validPayload(): array
    {
        return [
            'nama' => 'Microsoft Word',
            'deskripsi' => 'Menyusun dokumen dan laporan dengan format rapi.',
            'kategori' => Skill::KATEGORI_ADMINISTRASI,
            'urutan' => 3,
        ];
    }
}
