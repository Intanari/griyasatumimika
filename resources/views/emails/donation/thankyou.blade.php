<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih – PeduliJiwa</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f0f0ff;
            color: #1a1a2e;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }
        img { border: 0; display: block; max-width: 100%; }
    </style>
</head>
<body style="background-color: #f0f0ff; margin: 0; padding: 0;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f0f0ff; padding: 32px 16px;">
    <tr>
        <td align="center">
            <!-- OUTER CONTAINER -->
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; width:100%;">

                <!-- ===== HEADER LOGO ===== -->
                <tr>
                    <td align="center" style="padding-bottom: 24px;">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="
                                    background: linear-gradient(135deg, #4f46e5, #7c3aed);
                                    border-radius: 14px;
                                    width: 48px;
                                    height: 48px;
                                    text-align: center;
                                    vertical-align: middle;
                                    font-size: 24px;
                                    line-height: 48px;
                                    padding: 0 12px;
                                ">🧠</td>
                                <td style="padding-left: 12px; font-size: 22px; font-weight: 700; color: #4f46e5;">PeduliJiwa</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- ===== HERO CARD ===== -->
                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="
                            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #9333ea 100%);
                            border-radius: 24px 24px 0 0;
                            overflow: hidden;
                        ">
                            <tr>
                                <td align="center" style="padding: 48px 32px 36px;">
                                    <!-- SUCCESS ICON -->
                                    <div style="
                                        display: inline-block;
                                        width: 80px;
                                        height: 80px;
                                        background: rgba(255,255,255,0.2);
                                        border-radius: 50%;
                                        text-align: center;
                                        line-height: 80px;
                                        font-size: 40px;
                                        margin-bottom: 20px;
                                    ">✅</div>
                                    <p style="font-size: 13px; color: rgba(255,255,255,0.75); text-transform: uppercase; letter-spacing: 0.1em; font-weight: 600; margin-bottom: 10px;">Donasi Berhasil Diterima</p>
                                    <h1 style="font-size: 28px; font-weight: 700; color: #ffffff; line-height: 1.25; margin-bottom: 10px;">
                                        Terima Kasih,<br>{{ $donation->donor_name }}! 🙏
                                    </h1>
                                    <p style="font-size: 15px; color: rgba(255,255,255,0.85); line-height: 1.65; max-width: 420px; margin: 0 auto;">
                                        Kebaikan hatimu telah kami terima dengan penuh syukur. Donasi sebesar <strong style="color:#ffffff;">{{ $donation->formatted_amount }}</strong> akan segera disalurkan untuk program rehabilitasi ODGJ.
                                    </p>
                                </td>
                            </tr>
                            <!-- AMOUNT BADGE -->
                            <tr>
                                <td align="center" style="padding-bottom: 0;">
                                    <table cellpadding="0" cellspacing="0" border="0" style="
                                        background: rgba(255,255,255,0.15);
                                        border-radius: 16px 16px 0 0;
                                        backdrop-filter: blur(10px);
                                        padding: 20px 40px;
                                        margin: 0 32px;
                                        width: calc(100% - 64px);
                                    ">
                                        <tr>
                                            <td align="center">
                                                <p style="font-size: 13px; color: rgba(255,255,255,0.7); margin-bottom: 4px;">Total Donasi</p>
                                                <p style="font-size: 36px; font-weight: 700; color: #ffffff; letter-spacing: -0.5px;">{{ $donation->formatted_amount }}</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- ===== MAIN BODY CARD ===== -->
                <tr>
                    <td style="
                        background: #ffffff;
                        border-radius: 0 0 24px 24px;
                        box-shadow: 0 20px 60px rgba(79,70,229,0.12);
                        overflow: hidden;
                    ">

                        <!-- RECEIPT TABLE -->
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 32px 36px 0;">
                            <tr>
                                <td>
                                    <p style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #8a8aaa; margin-bottom: 16px;">📋 Detail Donasi</p>
                                </td>
                            </tr>
                            @php
                                $programs = [
                                    'rawat-inap'       => 'Biaya Rawat Inap & Obat ODGJ',
                                    'pelatihan-vokasi' => 'Pelatihan Vokasi Pasca-Rehabilitasi',
                                    'rumah-singgah'    => 'Rumah Singgah ODGJ Terlantar',
                                    'umum'             => 'Donasi Umum PeduliJiwa',
                                ];
                                $programLabel = $programs[$donation->program] ?? $donation->program;
                            @endphp

                            <!-- Row: Program -->
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td style="font-size: 13px; color: #8a8aaa; width: 40%;">Program</td>
                                            <td style="font-size: 13px; font-weight: 600; color: #1a1a2e; text-align: right;">{{ $programLabel }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!-- Row: Nama -->
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td style="font-size: 13px; color: #8a8aaa; width: 40%;">Nama Donatur</td>
                                            <td style="font-size: 13px; font-weight: 600; color: #1a1a2e; text-align: right;">{{ $donation->donor_name }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!-- Row: Email -->
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td style="font-size: 13px; color: #8a8aaa; width: 40%;">Email</td>
                                            <td style="font-size: 13px; font-weight: 600; color: #1a1a2e; text-align: right;">{{ $donation->donor_email }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!-- Row: Metode -->
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td style="font-size: 13px; color: #8a8aaa; width: 40%;">Metode Pembayaran</td>
                                            <td style="font-size: 13px; font-weight: 600; color: #1a1a2e; text-align: right;">QRIS</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!-- Row: Tanggal -->
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td style="font-size: 13px; color: #8a8aaa; width: 40%;">Tanggal</td>
                                            <td style="font-size: 13px; font-weight: 600; color: #1a1a2e; text-align: right;">{{ ($donation->paid_at ?? $donation->created_at)->format('d F Y, H:i') }} WIB</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!-- Row: Status -->
                            <tr>
                                <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f8;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td style="font-size: 13px; color: #8a8aaa; width: 40%;">Status</td>
                                            <td style="text-align: right;">
                                                <span style="
                                                    display: inline-block;
                                                    background: #dcfce7;
                                                    color: #16a34a;
                                                    font-size: 12px;
                                                    font-weight: 700;
                                                    padding: 3px 10px;
                                                    border-radius: 100px;
                                                ">✅ Lunas</span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!-- Row: Order ID -->
                            <tr>
                                <td style="padding: 10px 0;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td style="font-size: 13px; color: #8a8aaa; width: 40%;">No. Transaksi</td>
                                            <td style="font-size: 12px; font-weight: 600; color: #4f46e5; text-align: right; font-family: monospace;">{{ $donation->order_id }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        @if($donation->message)
                        <!-- DONOR MESSAGE -->
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 0 36px;">
                            <tr>
                                <td style="
                                    background: linear-gradient(135deg, #fffbf0, #fff7e6);
                                    border: 1.5px solid #fde68a;
                                    border-radius: 14px;
                                    padding: 18px 20px;
                                    margin-top: 24px;
                                ">
                                    <p style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #d97706; margin-bottom: 8px;">💬 Pesan & Doa Kamu</p>
                                    <p style="font-size: 14px; color: #78350f; line-height: 1.7; font-style: italic;">"{{ $donation->message }}"</p>
                                </td>
                            </tr>
                        </table>
                        @endif

                        <!-- IMPACT SECTION -->
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 28px 36px 0;">
                            <tr>
                                <td>
                                    <p style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #8a8aaa; margin-bottom: 16px;">💜 Dampak Donasimu</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <!-- Impact 1 -->
                                            <td width="33%" style="padding-right: 8px;">
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="
                                                    background: linear-gradient(135deg, #f0f0ff, #f5f0ff);
                                                    border-radius: 14px;
                                                    padding: 16px 12px;
                                                    text-align: center;
                                                ">
                                                    <tr><td style="font-size: 24px; padding-bottom: 6px;">🧑‍⚕️</td></tr>
                                                    <tr><td style="font-size: 18px; font-weight: 700; color: #4f46e5;">2.400+</td></tr>
                                                    <tr><td style="font-size: 11px; color: #8a8aaa; margin-top: 2px;">ODGJ Terbantu</td></tr>
                                                </table>
                                            </td>
                                            <!-- Impact 2 -->
                                            <td width="33%" style="padding: 0 4px;">
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="
                                                    background: linear-gradient(135deg, #f0fff4, #e6fff0);
                                                    border-radius: 14px;
                                                    padding: 16px 12px;
                                                    text-align: center;
                                                ">
                                                    <tr><td style="font-size: 24px; padding-bottom: 6px;">🏥</td></tr>
                                                    <tr><td style="font-size: 18px; font-weight: 700; color: #10b981;">48 RSJ</td></tr>
                                                    <tr><td style="font-size: 11px; color: #8a8aaa; margin-top: 2px;">Mitra RS</td></tr>
                                                </table>
                                            </td>
                                            <!-- Impact 3 -->
                                            <td width="33%" style="padding-left: 8px;">
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="
                                                    background: linear-gradient(135deg, #fff7f0, #fff0e6);
                                                    border-radius: 14px;
                                                    padding: 16px 12px;
                                                    text-align: center;
                                                ">
                                                    <tr><td style="font-size: 24px; padding-bottom: 6px;">🌍</td></tr>
                                                    <tr><td style="font-size: 18px; font-weight: 700; color: #f59e0b;">18 Kota</td></tr>
                                                    <tr><td style="font-size: 11px; color: #8a8aaa; margin-top: 2px;">Jangkauan</td></tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- MOTIVATIONAL QUOTE -->
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 28px 36px 0;">
                            <tr>
                                <td style="
                                    background: linear-gradient(135deg, #4f46e5, #7c3aed);
                                    border-radius: 16px;
                                    padding: 24px 28px;
                                    text-align: center;
                                ">
                                    <p style="font-size: 20px; margin-bottom: 10px;">💜</p>
                                    <p style="font-size: 15px; color: rgba(255,255,255,0.9); line-height: 1.7; font-style: italic; margin-bottom: 10px;">
                                        "Setiap tetes kebaikanmu adalah cahaya harapan bagi jiwa-jiwa yang sedang berjuang kembali ke dunia mereka."
                                    </p>
                                    <p style="font-size: 12px; color: rgba(255,255,255,0.6); font-weight: 600;">— Tim PeduliJiwa</p>
                                </td>
                            </tr>
                        </table>

                        <!-- CTA BUTTON -->
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 28px 36px;">
                            <tr>
                                <td align="center">
                                    <a href="{{ config('app.url') }}" style="
                                        display: inline-block;
                                        padding: 14px 36px;
                                        background: linear-gradient(135deg, #4f46e5, #7c3aed);
                                        border-radius: 12px;
                                        color: #ffffff;
                                        font-size: 15px;
                                        font-weight: 700;
                                        text-decoration: none;
                                        box-shadow: 0 4px 20px rgba(79,70,229,0.35);
                                    ">🏠 Kembali ke PeduliJiwa</a>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>

                <!-- ===== DIVIDER ===== -->
                <tr><td style="height: 24px;"></td></tr>

                <!-- ===== SOCIAL / SHARE ===== -->
                <tr>
                    <td style="
                        background: #ffffff;
                        border-radius: 16px;
                        padding: 20px 36px;
                        text-align: center;
                        box-shadow: 0 4px 20px rgba(79,70,229,0.06);
                    ">
                        <p style="font-size: 13px; color: #6a6a8a; margin-bottom: 14px;">Bagikan kebaikanmu dan ajak teman untuk ikut berdonasi 💪</p>
                        <table align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="padding: 0 6px;">
                                    <a href="https://wa.me/?text=Saya+baru+berdonasi+untuk+PeduliJiwa%21+Yuk+ikut+berdonasi+di+{{ urlencode(config('app.url')) }}" style="
                                        display: inline-block;
                                        background: #dcfce7;
                                        color: #16a34a;
                                        font-size: 12px;
                                        font-weight: 600;
                                        padding: 8px 16px;
                                        border-radius: 100px;
                                        text-decoration: none;
                                    ">📱 WhatsApp</a>
                                </td>
                                <td style="padding: 0 6px;">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(config('app.url')) }}" style="
                                        display: inline-block;
                                        background: #dbeafe;
                                        color: #1d4ed8;
                                        font-size: 12px;
                                        font-weight: 600;
                                        padding: 8px 16px;
                                        border-radius: 100px;
                                        text-decoration: none;
                                    ">📘 Facebook</a>
                                </td>
                                <td style="padding: 0 6px;">
                                    <a href="https://twitter.com/intent/tweet?text=Saya+baru+berdonasi+untuk+PeduliJiwa%21&url={{ urlencode(config('app.url')) }}" style="
                                        display: inline-block;
                                        background: #e0f2fe;
                                        color: #0369a1;
                                        font-size: 12px;
                                        font-weight: 600;
                                        padding: 8px 16px;
                                        border-radius: 100px;
                                        text-decoration: none;
                                    ">🐦 Twitter</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- ===== FOOTER ===== -->
                <tr>
                    <td style="padding: 24px 0; text-align: center;">
                        <p style="font-size: 12px; color: #aaa; margin-bottom: 6px;">
                            Email ini dikirim otomatis oleh sistem PeduliJiwa. Harap tidak membalas email ini.
                        </p>
                        <p style="font-size: 12px; color: #aaa; margin-bottom: 6px;">
                            📧 info@griyasatumimika.web.id &nbsp;|&nbsp; 🌐 <a href="{{ config('app.url') }}" style="color: #4f46e5;">griyasatumimika.web.id</a>
                        </p>
                        <p style="font-size: 11px; color: #ccc; margin-top: 8px;">
                            © {{ date('Y') }} PeduliJiwa. Semua hak dilindungi.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
