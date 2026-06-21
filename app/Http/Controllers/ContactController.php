<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('public.pages.kontak');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'subjek'  => ['nullable', 'string', 'max:255'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'pesan'   => ['required', 'string', 'max:5000'],
        ], [
            'nama.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'pesan.required' => 'Pesan wajib diisi.',
        ]);

        $recipient = config('mail.contact_to', 'info@griyasatumimika.web.id');

        Mail::to($recipient)->send(new ContactMessageMail($validated));

        return redirect()
            ->route('pages.kontak')
            ->with('success', 'Pesan Anda berhasil dikirim. Tim kami akan menghubungi Anda secepatnya.');
    }
}
