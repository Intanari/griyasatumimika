<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Donasi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        h1 { font-size: 16px; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        th { background: #e2e8f0; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .meta { margin-bottom: 12px; color: #666; }
    </style>
</head>
<body>
    <h1>Laporan Semua Donasi</h1>
    <p class="meta">Dicetak: {{ now()->translatedFormat('d F Y H:i') }} — Yayasan Griya Satu Mimika</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Order ID</th>
                <th>Nama Donatur</th>
                <th>Email</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($donations as $idx => $d)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $d->order_id }}</td>
                <td>{{ $d->donor_name }}</td>
                <td>{{ $d->donor_email }}</td>
                <td class="text-right">Rp {{ number_format($d->amount, 0, ',', '.') }}</td>
                <td>{{ $d->status }}</td>
                <td>{{ $d->created_at->translatedFormat('d M Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($donations->isEmpty())
    <p>Belum ada data donasi.</p>
    @endif
</body>
</html>
