<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peringatan Stok Barang – {{ config('app.name', 'PeduliJiwa') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #f0f0ff; color: #1a1a2e; }
        a { color: #4f46e5; text-decoration: none; font-weight: 600; }
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
                                <td style="background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 14px; width: 48px; height: 48px; text-align: center; vertical-align: middle; font-size: 24px; line-height: 48px;">🧠</td>
                                <td style="padding-left: 12px; font-size: 22px; font-weight: 700; color: #4f46e5;">{{ config('app.name', 'PeduliJiwa') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: linear-gradient(135deg, #b45309 0%, #f59e0b 100%); border-radius: 24px 24px 0 0; overflow: hidden;">
                            <tr>
                                <td align="center" style="padding: 36px 32px;">
                                    <div style="display:inline-block; width:64px; height:64px; background:rgba(255,255,255,0.2); border-radius:50%; text-align:center; line-height:64px; font-size:32px; margin-bottom:16px;">📦</div>
                                    <p style="font-size:12px; color:rgba(255,255,255,0.9); text-transform:uppercase; letter-spacing:0.1em; font-weight:600; margin-bottom:8px;">Peringatan Stok Barang</p>
                                    <h1 style="font-size:22px; font-weight:700; color:#ffffff; line-height:1.3;">Ada barang yang habis atau hampir habis</h1>
                                    <p style="font-size:14px; color:rgba(255,255,255,0.95); margin-top:10px;">Segera cek dan lakukan restock di dashboard.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="background:#ffffff; border-radius:0 0 24px 24px; box-shadow:0 20px 60px rgba(79,70,229,0.12); padding:32px 36px;">

                        <p style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#8a8aaa; margin-bottom:16px;">📋 Daftar Barang</p>

                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
                            <tr style="background:#f8fafc;">
                                <td style="padding:12px 16px; font-weight:700; color:#475569; width:50%;">Nama Barang</td>
                                <td style="padding:12px 16px; font-weight:700; color:#475569; width:25%;">Stok / Min</td>
                                <td style="padding:12px 16px; font-weight:700; color:#475569;">Status</td>
                            </tr>
                            @foreach($alerts as $alert)
                            @php
                                $item = $alert['item'];
                                $status = $alert['status'];
                                $statusLabel = $status === 'habis' ? 'Habis' : 'Hampir habis';
                                $statusBg = $status === 'habis' ? '#fee2e2' : '#fef3c7';
                                $statusColor = $status === 'habis' ? '#b91c1c' : '#b45309';
                            @endphp
                            <tr style="border-top:1px solid #e5e7eb;">
                                <td style="padding:12px 16px; font-weight:600; color:#1a1a2e;">{{ $item->name }}</td>
                                <td style="padding:12px 16px; color:#64748b;">{{ $item->quantity }} {{ $item->unit }} / min {{ $item->min_stock }}</td>
                                <td style="padding:12px 16px;">
                                    <span style="display:inline-block; padding:4px 10px; border-radius:8px; font-size:12px; font-weight:600; background:{{ $statusBg }}; color:{{ $statusColor }};">{{ $statusLabel }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </table>

                        <p style="margin-top:24px; font-size:14px; color:#64748b; line-height:1.5;">
                            Silakan login ke dashboard dan buka <strong>Manajemen Stok</strong> untuk menambah stok atau melakukan restock.
                        </p>

                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:24px;">
                            <tr>
                                <td align="center">
                                    <a href="{{ route('dashboard.stock.index') }}" style="display:inline-block; padding:14px 28px; background:linear-gradient(135deg, #4f46e5, #7c3aed); color:#ffffff !important; font-weight:600; font-size:14px; border-radius:12px; text-decoration:none;">Kelola Stok di Dashboard</a>
                                </td>
                            </tr>
                        </table>

                        <p style="margin-top:24px; font-size:12px; color:#94a3b8;">Email ini dikirim otomatis oleh sistem {{ config('app.name', 'PeduliJiwa') }}.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
