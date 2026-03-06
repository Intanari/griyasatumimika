<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Petugas - {{ config('app.name') }}</title>
    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; font-size: 12px; color: #1e293b; padding: 24px; }
        h1 { font-size: 18px; margin-bottom: 8px; color: #0f172a; }
        .meta { color: #64748b; margin-bottom: 20px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #e2e8f0; padding: 8px 10px; text-align: left; }
        th { background: #f1f5f9; font-weight: 600; font-size: 11px; text-transform: uppercase; }
        tr:nth-child(even) { background: #f8fafc; }
        .no-print { margin-bottom: 16px; }
        .btn-print { padding: 8px 16px; background: #3b82f6; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 13px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print">
        <button type="button" class="btn-print" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
    </div>
    <h1>Data Petugas — Yayasan Rehabilitasi</h1>
    <p class="meta">Dicetak: {{ now()->translatedFormat('d F Y H:i') }} — Total: {{ $petugas->count() }} petugas</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No. HP</th>
                <th>Alamat</th>
                <th>Tanggal Bergabung</th>
                <th>Status Kerja</th>
                <th>Shift</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($petugas as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->email }}</td>
                    <td>{{ $p->no_hp ?? '-' }}</td>
                    <td>{{ Str::limit($p->alamat ?? '-', 40) }}</td>
                    <td>{{ $p->tanggal_bergabung?->translatedFormat('d M Y') ?? '-' }}</td>
                    <td>{{ $p->status_kerja_label }}</td>
                    <td>{{ $p->shift_jaga_label }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
