<?php

namespace Tests\Feature;

use App\Models\CvFile;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_profile_skills_projects_and_experiences(): void
    {
        Profile::factory()->create([
            'nama' => 'Rani Kusuma',
            'headline' => 'Web Developer & Pengelola Data',
            'bio' => 'Saya membangun aplikasi web dan merapikan data administrasi.',
        ]);

        Skill::factory()->create([
            'nama' => 'Pengelolaan Arsip Digital',
            'kategori' => Skill::KATEGORI_ADMINISTRASI,
        ]);

        Skill::factory()->create([
            'nama' => 'Laravel',
            'kategori' => Skill::KATEGORI_WEB,
        ]);

        Project::factory()->create([
            'judul' => 'Sistem Arsip Digital',
            'slug' => 'sistem-arsip-digital',
            'status' => Project::STATUS_TAMPIL,
        ]);

        Project::factory()->create([
            'judul' => 'Proyek Rahasia Draft',
            'slug' => 'proyek-rahasia-draft',
            'status' => Project::STATUS_DRAFT,
        ]);

        Experience::factory()->pendidikan()->create([
            'judul' => 'S1 Sistem Informasi',
            'institusi' => 'Universitas Contoh',
        ]);

        CvFile::factory()->aktif()->create([
            'file_pdf' => 'cv/cv-terbaru.pdf',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Rani Kusuma')
            ->assertSee('Web Developer & Pengelola Data')
            ->assertSee('Pengelolaan Arsip Digital')
            ->assertSee('Laravel')
            ->assertSee('Sistem Arsip Digital')
            ->assertDontSee('Proyek Rahasia Draft')
            ->assertSee('S1 Sistem Informasi')
            ->assertSee('Universitas Contoh')
            ->assertSee('cv-terbaru.pdf');
    }

    public function test_home_page_does_not_show_a_download_button_without_an_active_cv(): void
    {
        CvFile::factory()->create([
            'file_pdf' => 'cv/cv-lama.pdf',
            'aktif' => false,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Unduh CV PDF')
            ->assertDontSee('cv-lama.pdf');
    }

    public function test_project_detail_page_displays_full_content_and_related_projects(): void
    {
        $project = Project::factory()->create([
            'judul' => 'Sistem Arsip Digital',
            'slug' => 'sistem-arsip-digital',
            'ringkasan' => 'Aplikasi pengelolaan arsip sekolah.',
            'deskripsi_masalah' => 'Arsip fisik sulit ditemukan kembali.',
            'deskripsi_solusi' => 'Membangun pencarian arsip berbasis web.',
            'deskripsi_hasil' => 'Waktu pencarian berkurang drastis.',
            'teknologi' => 'Laravel, MySQL, Tailwind CSS',
            'peran' => 'Full-stack Developer',
            'tahun' => 2025,
            'kategori' => 'Web Application',
            'status' => Project::STATUS_TAMPIL,
        ]);

        Project::factory()->create([
            'judul' => 'Aplikasi Kasir',
            'slug' => 'aplikasi-kasir',
            'status' => Project::STATUS_TAMPIL,
        ]);

        Project::factory()->create([
            'judul' => 'Proyek Rahasia Draft',
            'slug' => 'proyek-rahasia-draft',
            'status' => Project::STATUS_DRAFT,
        ]);

        $this->get(route('projects.show', $project))
            ->assertOk()
            ->assertSee('Sistem Arsip Digital')
            ->assertSee('Aplikasi pengelolaan arsip sekolah.')
            ->assertSee('Arsip fisik sulit ditemukan kembali.')
            ->assertSee('Membangun pencarian arsip berbasis web.')
            ->assertSee('Waktu pencarian berkurang drastis.')
            ->assertSee('Full-stack Developer')
            ->assertSee('Web Application')
            ->assertSee('Laravel')
            ->assertSee('Aplikasi Kasir')
            ->assertDontSee('Proyek Rahasia Draft');
    }

    public function test_draft_project_detail_returns_not_found(): void
    {
        $project = Project::factory()->draft()->create([
            'slug' => 'proyek-rahasia-draft',
        ]);

        $this->get(route('projects.show', $project))->assertNotFound();
    }

    public function test_contact_form_stores_a_message_and_redirects_with_success(): void
    {
        $this->post(route('contact.store'), [
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'pesan' => 'Saya ingin mendiskusikan pembuatan website sekolah.',
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('home').'#kontak')
            ->assertSessionHas('success', 'Pesan Anda berhasil dikirim. Terima kasih sudah menghubungi!');

        $message = Message::query()->sole();

        $this->assertSame('Budi Santoso', $message->nama);
        $this->assertSame('budi@example.com', $message->email);
        $this->assertSame('Saya ingin mendiskusikan pembuatan website sekolah.', $message->pesan);
        $this->assertFalse($message->sudah_dibaca);
    }

    public function test_contact_form_validation_uses_indonesian_messages(): void
    {
        $this->post(route('contact.store'), [])
            ->assertSessionHasErrors([
                'nama' => 'Nama wajib diisi.',
                'email' => 'Email wajib diisi.',
                'pesan' => 'Pesan wajib diisi.',
            ]);

        $this->post(route('contact.store'), [
            'nama' => 'Budi',
            'email' => 'bukan-email',
            'pesan' => 'Pendek',
        ])
            ->assertSessionHasErrors([
                'email' => 'Format email tidak valid.',
                'pesan' => 'Pesan minimal 10 karakter.',
            ]);

        $this->assertDatabaseCount('messages', 0);
    }

    public function test_contact_form_is_throttled_after_six_attempts_per_minute(): void
    {
        $payload = [
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'pesan' => 'Saya ingin mendiskusikan pembuatan website sekolah.',
        ];

        for ($attempt = 0; $attempt < 6; $attempt++) {
            $this->post(route('contact.store'), $payload)->assertRedirect();
        }

        $this->post(route('contact.store'), $payload)->assertStatus(429);
        $this->assertDatabaseCount('messages', 6);
    }
}
