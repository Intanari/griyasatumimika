<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat Jadwal Pasien – {{ config('app.name', 'PeduliJiwa') }}</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color:#f3f4ff; margin:0; padding:24px;">
@php
    $jam = '';
    if ($schedule->jam_mulai) {
        $jam = \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i');
        if ($schedule->jam_selesai) {
            $jam .= ' – ' . \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i');
        }
    } else {
        $jam = '–';
    }
@endphp

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; width:100%; background:#ffffff; border-radius:18px; box-shadow:0 14px 40px rgba(79,70,229,0.15); overflow:hidden;">
                <tr>
                    <td style="background:linear-gradient(135deg,#4f46e5,#6366f1); padding:26px 32px; color:#fff;">
                        <div style="font-size:14px; text-transform:uppercase; letter-spacing:0.12em; opacity:0.85; margin-bottom:6px;">
                            Pengingat Jadwal Pasien
                        </div>
                        <div style="font-size:22px; font-weight:700; line-height:1.3; margin-bottom:4px;">
                            Jadwal akan dimulai sekitar 30 menit lagi
                        </div>
                        <div style="font-size:14px; opacity:0.9;">
                            Pasien: <strong>{{ $schedule->patient->nama_lengkap ?? '-' }}</strong>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding:24px 30px 10px 30px;">
                        <p style="font-size:14px; color:#111827; margin:0 0 12px 0;">
                            Yth. Pembimbing,
                        </p>
                        <p style="font-size:14px; color:#4b5563; margin:0 0 18px 0; line-height:1.5;">
                            Ini adalah pengingat otomatis bahwa Anda terjadwal untuk mendampingi pasien berikut:
                        </p>

                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px; color:#111827; margin-bottom:16px;">
                            <tr>
                                <td style="padding:8px 0; color:#6b7280; width:150px;">Nama Pasien</td>
                                <td style="padding:8px 0; font-weight:600;">{{ $schedule->patient->nama_lengkap ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:8px 0; color:#6b7280;">Tanggal</td>
                                <td style="padding:8px 0; font-weight:600;">
                                    {{ optional($schedule->tanggal)->locale('id')->translatedFormat('d F Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:8px 0; color:#6b7280;">Waktu</td>
                                <td style="padding:8px 0; font-weight:600;">{{ $jam }}</td>
                            </tr>
                            <tr>
                                <td style="padding:8px 0; color:#6b7280;">Tempat</td>
                                <td style="padding:8px 0; font-weight:600;">{{ $schedule->tempat ?: '–' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:8px 0; color:#6b7280;">Kegiatan</td>
                                <td style="padding:8px 0; font-weight:600;">{{ $schedule->jenis ?: '–' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:8px 0; color:#6b7280; vertical-align:top;">Catatan</td>
                                <td style="padding:8px 0; color:#111827; line-height:1.5;">{{ $schedule->catatan ?: '–' }}</td>
                            </tr>
                        </table>

                        <p style="font-size:13px; color:#6b7280; margin:0 0 8px 0;">
                            Mohon menyiapkan diri sebelum jadwal dimulai dan pastikan pasien menerima pendampingan sesuai kebutuhan.
                        </p>
                        <p style="font-size:12px; color:#9ca3af; margin:0;">
                            Email ini dikirim otomatis oleh sistem {{ config('app.name', 'PeduliJiwa') }} sebagai pengingat 30 menit sebelum jadwal.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>

