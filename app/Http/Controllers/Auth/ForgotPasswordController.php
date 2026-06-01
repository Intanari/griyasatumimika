<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT || $status === Password::INVALID_USER) {
            return back()->with(
                'status',
                'Jika email terdaftar di sistem, tautan reset kata sandi akan dikirim ke kotak masuk Anda.'
            );
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => $this->statusMessage($status)]);
    }

    private function statusMessage(string $status): string
    {
        return match ($status) {
            Password::RESET_THROTTLED => 'Terlalu banyak permintaan. Silakan coba lagi beberapa menit lagi.',
            default => 'Gagal mengirim tautan reset. Silakan coba lagi.',
        };
    }
}
