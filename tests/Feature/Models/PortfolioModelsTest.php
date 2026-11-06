<?php

namespace Tests\Feature\Models;

use App\Models\CvFile;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioModelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_tampil_scope_only_returns_published_projects(): void
    {
        Project::factory()->tampil()->count(2)->create();
        Project::factory()->draft()->create();

        $this->assertSame(2, Project::query()->tampil()->count());
    }

    public function test_project_uses_slug_as_route_key(): void
    {
        $project = Project::factory()->create([
            'judul' => 'Website Sekolah',
            'slug' => 'website-sekolah',
        ]);

        $this->assertSame('slug', $project->getRouteKeyName());
        $this->assertSame('website-sekolah', $project->getRouteKey());
    }

    public function test_only_one_cv_file_can_be_active(): void
    {
        $first = CvFile::factory()->aktif()->create();
        $second = CvFile::factory()->aktif()->create();

        $this->assertFalse($first->fresh()->aktif);
        $this->assertTrue($second->fresh()->aktif);
        $this->assertTrue(CvFile::current()->is($second));
    }

    public function test_experience_period_label_handles_ongoing_and_certificate(): void
    {
        $ongoing = Experience::factory()->create([
            'tipe' => Experience::TIPE_PENGALAMAN,
            'tahun_mulai' => 2023,
            'tahun_selesai' => null,
        ]);

        $certificate = Experience::factory()->sertifikat()->create([
            'tahun_mulai' => 2022,
        ]);

        $this->assertSame('2023 – Sekarang', $ongoing->periodeLabel());
        $this->assertSame('2022', $certificate->periodeLabel());
    }

    public function test_skill_scope_filters_by_category_and_orders_items(): void
    {
        Skill::factory()->create([
            'nama' => 'Excel Lanjutan',
            'kategori' => Skill::KATEGORI_ADMINISTRASI,
            'urutan' => 2,
        ]);
        Skill::factory()->create([
            'nama' => 'Administrasi Dokumen',
            'kategori' => Skill::KATEGORI_ADMINISTRASI,
            'urutan' => 1,
        ]);
        Skill::factory()->create([
            'nama' => 'Laravel',
            'kategori' => Skill::KATEGORI_WEB,
            'urutan' => 1,
        ]);

        $skills = Skill::query()
            ->kategori(Skill::KATEGORI_ADMINISTRASI)
            ->ordered()
            ->pluck('nama')
            ->all();

        $this->assertSame(['Administrasi Dokumen', 'Excel Lanjutan'], $skills);
    }

    public function test_unread_messages_scope_only_returns_unread_messages(): void
    {
        Message::factory()->count(2)->create();
        Message::factory()->sudahDibaca()->create();

        $this->assertSame(2, Message::query()->belumDibaca()->count());
    }
}
