<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Laporan – PeduliJiwa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #eff6ff; color: #1a1a2e; }
        a { color: #2563eb; text-decoration: none; }
    </style>
</head>
<body style="background-color: #eff6ff; margin: 0; padding: 0;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #eff6ff; padding: 32px 16px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; width:100%;">
                <tr>
                    <td align="center" style="padding-bottom: 24px;">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="background: linear-gradient(135deg, #3b82f6, #0ea5e9); border-radius: 14px; width: 48px; height: 48px; text-align: center; vertical-align: middle; font-size: 24px; line-height: 48px;">🧠</td>
                                <td style="padding-left: 12px; font-size: 22px; font-weight: 700; color: #2563eb;">PeduliJiwa</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: linear-gradient(135deg, #64748b 0%, #475569 100%); border-radius: 24px 24px 0 0; overflow: hidden;">
                            <tr>
                                <td align="center" style="padding: 36px 32px;">
                                    <div style="display: inline-block; width: 64px; height: 64px; background: rgba(255,255,255,0.2); border-radius: 50%; text-align: center; line-height: 64px; font-size: 32px; margin-bottom: 16px;">📋</div>
                                    <p style="font-size: 12px; color: rgba(255,255,255,0.9); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 600; margin-bottom: 8px;">Update Laporan</p>
                                    <h1 style="font-size: 24px; font-weight: 700; color: #ffffff; line-height: 1.25;">
                                        Laporan Tidak Dapat Ditindaklanjuti
                                    </h1>
                                    <p style="font-size: 14px; color: rgba(255,255,255,0.9); margin-top: 8px;">No. Laporan: <strong>{{ $report->nomor_laporan }}</strong></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="background: #ffffff; border-radius: 0 0 24px 24px; box-shadow: 0 20px 60px rgba(59,130,246,0.12); padding: 32px 36px;">
                        <p style="font-size: 15px; color: #1a1a2e; line-height: 1.7; margin-bottom: 20px;">
                            Terima kasih telah melaporkan kasus ODGJ kepada kami. Setelah ditinjau, kami informasikan bahwa <strong>laporan ini tidak dapat kami tindaklanjuti</strong> pada saat ini karena berbagai pertimbangan.
                        </p>
                        <p style="font-size: 15px; color: #1a1a2e; line-height: 1.7; margin-bottom: 20px;">
                            Jika Anda membutuhkan bantuan lain atau memiliki pertanyaan, silakan hubungi kami kembali. Kami tetap menghargai kepedulian Anda.
                        </p>
                        <p style="font-size: 14px; color: #64748b; line-height: 1.6;">
                            Salam hangat dari tim PeduliJiwa.
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 24px 0; text-align: center;">
                        <p style="font-size: 12px; color: #94a3b8;">© {{ date('Y') }} PeduliJiwa</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
