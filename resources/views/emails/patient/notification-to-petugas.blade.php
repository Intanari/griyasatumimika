<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Data Pasien – {{ config('app.name', 'PeduliJiwa') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #f0f0ff; color: #1a1a2e; }
        a { color: #4f46e5; text-decoration: none; }
    </style>
</head>
<body style="background-color: #f0f0ff; margin: 0; padding: 0;">

@php
    $actionLabels = [
        'created' => ['label' => 'Pasien Baru Ditambahkan', 'icon' => '✅', 'bg' => 'linear-gradient(135deg, #059669 0%, #10b981 100%);'],
        'updated' => ['label' => 'Data Pasien Diperbarui', 'icon' => '📝', 'bg' => 'linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);'],
        'deleted' => ['label' => 'Data Pasien Dihapus', 'icon' => '🗑', 'bg' => 'linear-gradient(135deg, #dc2626 0%, #ef4444 100%);'],
    ];
    $info = $actionLabels[$action] ?? ['label' => 'Perubahan Data Pasien', 'icon' => '👥', 'bg' => 'linear-gradient(135deg, #4f46e5, #7c3aed);'];
@endphp

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f0f0ff; padding: 32px 16px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; width:100%;">

                <tr>
                    <td align="center" style="padding-bottom: 24px;">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 14px; width: 48px; height: 48px; text-align: center; vertical-align: middle; font-size: 24px; line-height: 48px;">🧠</td>
                                <td style="padding-left: 12px; font-size: 22px; font-weight: 700; color: #4f46e5;">{{ config('app.name', 'PeduliJiwa') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: {{ $info['bg'] }}; border-radius: 24px 24px 0 0; overflow: hidden;">
                            <tr>
                                <td align="center" style="padding: 36px 32px;">
                                    <div style="display: inline-block; width: 64px; height: 64px; background: rgba(255,255,255,0.2); border-radius: 50%; text-align: center; line-height: 64px; font-size: 32px; margin-bottom: 16px;">{{ $info['icon'] }}</div>
                                    <p style="font-size: 12px; color: rgba(255,255,255,0.8); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 600; margin-bottom: 8px;">Data Pasien</p>
                                    <h1 style="font-size: 24px; font-weight: 700; color: #ffffff; line-height: 1.25;">
                                        {{ $info['label'] }}
                                    </h1>
                                    <p style="font-size: 14px; color: rgba(255,255,255,0.9); margin-top: 8px;">{{ $patient->nama_lengkap }}</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="background: #ffffff; border-radius: 0 0 24px 24px; box-shadow: 0 20px 60px rgba(79,70,229,0.12); padding: 32px 36px;">

                        <p style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #8a8aaa; margin-bottom: 16px;">📋 Detail Pasien</p>

                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 14px;">
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8; color: #8a8aaa;">Nama Lengkap</td>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8; font-weight: 600; color: #1a1a2e;">{{ $patient->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8; color: #8a8aaa;">Tempat, Tanggal Lahir</td>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8; font-weight: 600; color: #1a1a2e;">{{ $patient->tempat_lahir ?? '-' }}, {{ $patient->tanggal_lahir ? $patient->tanggal_lahir->translatedFormat('d F Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8; color: #8a8aaa;">Jenis Kelamin</td>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8; font-weight: 600; color: #1a1a2e;">{{ $patient->jenis_kelamin_label }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8; color: #8a8aaa;">Tanggal Masuk</td>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8; font-weight: 600; color: #1a1a2e;">{{ $patient->tanggal_masuk->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8; color: #8a8aaa;">Status</td>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8; font-weight: 600; color: #1a1a2e;">{{ $patient->status_label }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; color: #8a8aaa;">Waktu notifikasi</td>
                                <td style="padding: 10px 0; font-weight: 600; color: #1a1a2e;">{{ now()->locale('id')->translatedFormat('d F Y, H:i') }} WIB</td>
                            </tr>
                        </table>

                        @if($action !== 'deleted')
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 28px;">
                            <tr>
                                <td align="center">
                                    <a href="https://{{ config('app.admin_domain') }}/dashboard/patients" style="display: inline-block; padding: 14px 36px; background: linear-gradient(135deg, #3b82f6, #0ea5e9); border-radius: 12px; color: #ffffff; font-size: 15px; font-weight: 700; text-decoration: none; box-shadow: 0 4px 20px rgba(59,130,246,0.35);">👥 Buka Data Pasien</a>
                                </td>
                            </tr>
                        </table>
                        @endif

                    </td>
                </tr>

                <tr>
                    <td style="padding: 24px 0; text-align: center;">
                        <p style="font-size: 12px; color: #aaa;">Email notifikasi otomatis dari sistem {{ config('app.name', 'PeduliJiwa') }} – Data Pasien.</p>
                        <p style="font-size: 11px; color: #ccc; margin-top: 8px;">© {{ date('Y') }} {{ config('app.name', 'PeduliJiwa') }}.</p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
