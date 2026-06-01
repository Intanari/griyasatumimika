<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi – {{ config('app.name', 'PeduliJiwa') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #f0f0ff; color: #1a1a2e; }
    </style>
</head>
<body style="background-color: #f0f0ff; margin: 0; padding: 0;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f0f0ff; padding: 32px 16px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; width:100%;">
                <tr>
                    <td align="center" style="padding-bottom: 24px;">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="background: linear-gradient(135deg, #3b82f6, #0ea5e9); border-radius: 14px; width: 48px; height: 48px; text-align: center; vertical-align: middle; font-size: 24px; line-height: 48px;">🧠</td>
                                <td style="padding-left: 12px; font-size: 22px; font-weight: 700; color: #2563eb;">{{ config('app.name', 'PeduliJiwa') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); border-radius: 24px 24px 0 0; overflow: hidden;">
                            <tr>
                                <td style="padding: 32px 28px; text-align: center;">
                                    <div style="font-size: 40px; margin-bottom: 12px;">🔑</div>
                                    <h1 style="color: #ffffff; font-size: 22px; font-weight: 700; margin: 0;">Reset Kata Sandi</h1>
                                </td>
                            </tr>
                        </table>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #ffffff; border-radius: 0 0 24px 24px; box-shadow: 0 4px 24px rgba(0,0,0,0.08);">
                            <tr>
                                <td style="padding: 32px 28px;">
                                    <p style="font-size: 15px; line-height: 1.6; color: #4a4a6a; margin-bottom: 16px;">
                                        Halo <strong>{{ $user->name }}</strong>,
                                    </p>
                                    <p style="font-size: 15px; line-height: 1.6; color: #4a4a6a; margin-bottom: 24px;">
                                        Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda di area petugas PeduliJiwa. Klik tombol di bawah untuk membuat kata sandi baru.
                                    </p>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td align="center" style="padding-bottom: 24px;">
                                                <a href="{{ $resetUrl }}" style="display: inline-block; padding: 14px 36px; background: linear-gradient(135deg, #3b82f6, #0ea5e9); border-radius: 12px; color: #ffffff; font-size: 15px; font-weight: 700; text-decoration: none; box-shadow: 0 4px 20px rgba(59,130,246,0.35);">Atur Ulang Kata Sandi</a>
                                            </td>
                                        </tr>
                                    </table>
                                    <p style="font-size: 13px; line-height: 1.6; color: #9ca3af; margin-bottom: 8px;">
                                        Tautan ini berlaku selama 60 menit. Jika Anda tidak meminta reset kata sandi, abaikan email ini.
                                    </p>
                                    <p style="font-size: 12px; line-height: 1.5; color: #9ca3af; word-break: break-all;">
                                        Jika tombol tidak berfungsi, salin tautan ini ke browser:<br>
                                        <a href="{{ $resetUrl }}" style="color: #2563eb;">{{ $resetUrl }}</a>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding-top: 24px; font-size: 12px; color: #9ca3af;">
                        &copy; {{ date('Y') }} {{ config('app.name', 'PeduliJiwa') }} — Akses Terbatas untuk Petugas Rehabilitasi
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
