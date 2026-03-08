<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Jadwal Rehabilitasi – {{ config('app.name', 'PeduliJiwa') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #f0f0ff; color: #1a1a2e; }
        a { color: #4f46e5; text-decoration: none; }
    </style>
</head>
<body style="background-color: #f0f0ff; margin: 0; padding: 0;">

@php
    $actionLabels = [
        'created' => ['label' => 'Jadwal Rehabilitasi Ditambahkan', 'icon' => '✅', 'bg' => 'linear-gradient(135deg, #059669 0%, #10b981 100%);'],
        'updated' => ['label' => 'Jadwal Rehabilitasi Diperbarui',  'icon' => '📝', 'bg' => 'linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);'],
        'deleted' => ['label' => 'Jadwal Rehabilitasi Dihapus',     'icon' => '🗑',  'bg' => 'linear-gradient(135deg, #dc2626 0%, #ef4444 100%);'],
    ];
    $info = $actionLabels[$action] ?? ['label' => 'Perubahan Jadwal Rehabilitasi', 'icon' => '🔄', 'bg' => 'linear-gradient(135deg, #4f46e5, #7c3aed);'];
    $jam = \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i');
    if ($schedule->jam_selesai) {
        $jam .= ' – ' . \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i');
    }
    $pembimbing = $schedule->pembimbingUser->name ?? '–';
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
                                    <div style="display:inline-block; width:64px; height:64px; background:rgba(255,255,255,0.2); border-radius:50%; text-align:center; line-height:64px; font-size:32px; margin-bottom:16px;">{{ $info['icon'] }}</div>
                                    <p style="font-size:12px; color:rgba(255,255,255,0.8); text-transform:uppercase; letter-spacing:0.1em; font-weight:600; margin-bottom:8px;">Jadwal Rehabilitasi</p>
                                    <h1 style="font-size:22px; font-weight:700; color:#ffffff; line-height:1.3;">{{ $info['label'] }}</h1>
                                    <p style="font-size:14px; color:rgba(255,255,255,0.9); margin-top:10px;">
                                        Kegiatan: <strong>{{ $schedule->nama_kegiatan }}</strong>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="background:#ffffff; border-radius:0 0 24px 24px; box-shadow:0 20px 60px rgba(79,70,229,0.12); padding:32px 36px;">

                        <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#8a8aaa; margin-bottom:16px;">🔄 Detail Jadwal Rehabilitasi</p>

                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px;">
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #f0f0f8; color:#8a8aaa; width:160px;">Nama Kegiatan</td>
                                <td style="padding:10px 0; border-bottom:1px solid #f0f0f8; font-weight:600; color:#1a1a2e;">{{ $schedule->nama_kegiatan }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #f0f0f8; color:#8a8aaa;">Hari</td>
                                <td style="padding:10px 0; border-bottom:1px solid #f0f0f8; font-weight:600; color:#1a1a2e;">{{ $schedule->hari_label }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #f0f0f8; color:#8a8aaa;">Jam</td>
                                <td style="padding:10px 0; border-bottom:1px solid #f0f0f8; font-weight:600; color:#1a1a2e;">{{ $jam }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #f0f0f8; color:#8a8aaa;">Tempat</td>
                                <td style="padding:10px 0; border-bottom:1px solid #f0f0f8; font-weight:600; color:#1a1a2e;">{{ $schedule->tempat ?: '–' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #f0f0f8; color:#8a8aaa;">Pembimbing</td>
                                <td style="padding:10px 0; border-bottom:1px solid #f0f0f8; font-weight:600; color:#1a1a2e;">{{ $pembimbing }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #f0f0f8; color:#8a8aaa;">Status</td>
                                <td style="padding:10px 0; border-bottom:1px solid #f0f0f8; font-weight:600; color:#1a1a2e;">{{ $schedule->is_aktif ? 'Aktif' : 'Nonaktif' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #f0f0f8; color:#8a8aaa; vertical-align:top;">Deskripsi</td>
                                <td style="padding:10px 0; border-bottom:1px solid #f0f0f8; color:#1a1a2e; line-height:1.5;">{{ $schedule->deskripsi ?: '–' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; color:#8a8aaa;">Waktu Notifikasi</td>
                                <td style="padding:10px 0; font-weight:600; color:#1a1a2e;">{{ now()->locale('id')->translatedFormat('d F Y, H:i') }} WIB</td>
                            </tr>
                        </table>

                        @if($action !== 'deleted')
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:28px;">
                            <tr>
                                <td align="center">
                                    <a href="https://{{ config('app.admin_domain') }}/dashboard/jadwal-rehabilitasi"
                                        style="display:inline-block; padding:14px 36px; background:linear-gradient(135deg,#3b82f6,#0ea5e9); border-radius:12px; color:#ffffff; font-size:15px; font-weight:700; text-decoration:none; box-shadow:0 4px 20px rgba(59,130,246,0.35);">
                                        🔄 Buka Jadwal Rehabilitasi
                                    </a>
                                </td>
                            </tr>
                        </table>
                        @endif

                    </td>
                </tr>

                <tr>
                    <td style="padding:24px 0; text-align:center;">
                        <p style="font-size:12px; color:#aaa;">Email notifikasi otomatis dari sistem {{ config('app.name', 'PeduliJiwa') }} – Jadwal Rehabilitasi.</p>
                        <p style="font-size:11px; color:#ccc; margin-top:8px;">© {{ date('Y') }} {{ config('app.name', 'PeduliJiwa') }}.</p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
