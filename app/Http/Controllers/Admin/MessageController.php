<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Daftar pesan masuk dengan pencarian, filter status, dan pagination.
     */
    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();
        $status = $request->string('status')->toString();

        if (! array_key_exists($status, $this->statusLabels())) {
            $status = '';
        }

        $messages = Message::query()
            ->when($search !== '', fn (Builder $query): Builder => $query->where(
                fn (Builder $query): Builder => $query
                    ->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('pesan', 'like', "%{$search}%"),
            ))
            ->when($status !== '', fn (Builder $query): Builder => $query->where('sudah_dibaca', $status === 'sudah'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.messages.index', [
            'messages' => $messages,
            'search' => $search,
            'status' => $status,
            'statusLabels' => $this->statusLabels(),
            'unreadCount' => Message::query()->belumDibaca()->count(),
            'totalCount' => Message::query()->count(),
        ]);
    }

    /**
     * Tampilkan detail pesan dan tandai sudah dibaca.
     */
    public function show(Message $message): View
    {
        if (! $message->sudah_dibaca) {
            $message->update(['sudah_dibaca' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    /**
     * Balikkan status baca pesan.
     */
    public function toggleRead(Message $message): RedirectResponse
    {
        $message->update(['sudah_dibaca' => ! $message->sudah_dibaca]);

        return back()->with(
            'success',
            $message->sudah_dibaca
                ? 'Pesan ditandai sudah dibaca.'
                : 'Pesan ditandai belum dibaca.',
        );
    }

    /**
     * Hapus pesan dari kotak masuk.
     */
    public function destroy(Message $message): RedirectResponse
    {
        $message->delete();

        return to_route('admin.messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }

    /**
     * @return array<string, string>
     */
    private function statusLabels(): array
    {
        return [
            'belum' => 'Belum dibaca',
            'sudah' => 'Sudah dibaca',
        ];
    }
}
