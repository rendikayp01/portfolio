<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    /**
     * Simpan pesan dari formulir kontak publik.
     */
    public function store(ContactRequest $request): RedirectResponse
    {
        Message::create($request->validated());

        return to_route('home')
            ->withFragment('kontak')
            ->with('success', 'Pesan Anda berhasil dikirim. Terima kasih sudah menghubungi!');
    }
}
