<?php

namespace Tests\Feature\Admin;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageInboxTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login_from_admin_message_routes(): void
    {
        $message = Message::factory()->create();

        $this->get(route('admin.messages.index'))->assertRedirect(route('login'));
        $this->get(route('admin.messages.show', $message))->assertRedirect(route('login'));
        $this->patch(route('admin.messages.toggle-read', $message))->assertRedirect(route('login'));
        $this->delete(route('admin.messages.destroy', $message))->assertRedirect(route('login'));

        $this->assertDatabaseCount('messages', 1);
        $this->assertFalse($message->refresh()->sudah_dibaca);
    }

    public function test_authenticated_user_can_view_the_message_inbox(): void
    {
        $user = User::factory()->create();

        Message::factory()->create([
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'pesan' => 'Saya ingin membuat website sekolah.',
            'sudah_dibaca' => false,
        ]);

        Message::factory()->create([
            'nama' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'pesan' => 'Terima kasih atas informasi yang diberikan.',
            'sudah_dibaca' => true,
        ]);

        $this->actingAs($user)
            ->get(route('admin.messages.index'))
            ->assertOk()
            ->assertSee('Pesan masuk')
            ->assertSee('Budi Santoso')
            ->assertSee('budi@example.com')
            ->assertSee('Saya ingin membuat website sekolah.')
            ->assertSee('Siti Aminah')
            ->assertSee('siti@example.com')
            ->assertSee('Baru')
            ->assertSee('Dibaca')
            ->assertSee('1 pesan belum dibaca');
    }

    public function test_viewing_the_inbox_does_not_mark_messages_as_read(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create(['sudah_dibaca' => false]);

        $this->actingAs($user)
            ->get(route('admin.messages.index'))
            ->assertOk();

        $this->assertFalse($message->refresh()->sudah_dibaca);
    }

    public function test_message_inbox_can_be_filtered_by_search_and_status(): void
    {
        $user = User::factory()->create();

        Message::factory()->create([
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'pesan' => 'Permintaan penawaran website.',
            'sudah_dibaca' => false,
        ]);

        Message::factory()->create([
            'nama' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'pesan' => 'Pertanyaan tentang layanan.',
            'sudah_dibaca' => true,
        ]);

        $this->actingAs($user)
            ->get(route('admin.messages.index', ['q' => 'Budi']))
            ->assertOk()
            ->assertSee('Budi Santoso')
            ->assertDontSee('Siti Aminah');

        $this->actingAs($user)
            ->get(route('admin.messages.index', ['q' => 'siti@example.com']))
            ->assertOk()
            ->assertSee('Siti Aminah')
            ->assertDontSee('Budi Santoso');

        $this->actingAs($user)
            ->get(route('admin.messages.index', ['status' => 'belum']))
            ->assertOk()
            ->assertSee('Budi Santoso')
            ->assertDontSee('Siti Aminah');

        $this->actingAs($user)
            ->get(route('admin.messages.index', ['status' => 'sudah']))
            ->assertOk()
            ->assertSee('Siti Aminah')
            ->assertDontSee('Budi Santoso');
    }

    public function test_opening_a_message_marks_it_as_read_and_shows_its_details(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create([
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'pesan' => "Saya ingin membuat website sekolah.\nMohon informasi harga dan waktu pengerjaan.",
            'sudah_dibaca' => false,
        ]);

        $this->actingAs($user)
            ->get(route('admin.messages.show', $message))
            ->assertOk()
            ->assertSee('Budi Santoso')
            ->assertSee('budi@example.com')
            ->assertSee('Saya ingin membuat website sekolah.')
            ->assertSee('Mohon informasi harga dan waktu pengerjaan.')
            ->assertSee('Sudah dibaca')
            ->assertSee('Balas via email')
            ->assertSee('mailto:budi@example.com', false);

        $this->assertTrue($message->refresh()->sudah_dibaca);
    }

    public function test_message_read_status_can_be_toggled_both_ways(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create(['sudah_dibaca' => true]);

        $this->actingAs($user)
            ->from(route('admin.messages.show', $message))
            ->patch(route('admin.messages.toggle-read', $message))
            ->assertRedirect(route('admin.messages.show', $message))
            ->assertSessionHas('success', 'Pesan ditandai belum dibaca.');

        $this->assertFalse($message->refresh()->sudah_dibaca);

        $this->actingAs($user)
            ->from(route('admin.messages.index'))
            ->patch(route('admin.messages.toggle-read', $message))
            ->assertRedirect(route('admin.messages.index'))
            ->assertSessionHas('success', 'Pesan ditandai sudah dibaca.');

        $this->assertTrue($message->refresh()->sudah_dibaca);
    }

    public function test_authenticated_user_can_delete_a_message(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create();

        $this->actingAs($user)
            ->delete(route('admin.messages.destroy', $message))
            ->assertRedirect(route('admin.messages.index'))
            ->assertSessionHas('success', 'Pesan berhasil dihapus.');

        $this->assertDatabaseMissing('messages', ['id' => $message->id]);
    }

    public function test_unread_badge_disappears_after_all_messages_are_read(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create(['sudah_dibaca' => false]);

        $this->actingAs($user)
            ->get(route('admin.messages.index'))
            ->assertSee('1 pesan belum dibaca');

        $this->actingAs($user)
            ->get(route('admin.messages.show', $message))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('admin.messages.index'))
            ->assertOk()
            ->assertDontSee('1 pesan belum dibaca');
    }
}
