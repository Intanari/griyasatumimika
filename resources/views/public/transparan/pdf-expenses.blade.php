<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Pengeluaran Donasi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        h1 { font-size: 16px; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        th { background: #e2e8f0; font-weight: bold; }
        .text-right { text-align: right; }
        .meta { margin-bottom: 12px; color: #666; }
    </style>
</head>
<body>
    <h1>Laporan Pengeluaran Donasi</h1>
    <p class="meta">Dicetak: {{ now()->translatedFormat('d F Y H:i') }} — Yayasan Griya Satu Mimika</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
                <th>Gambar</th>
                <th>Tanggal Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $idx => $e)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $e->keterangan }}</td>
                <td class="text-right">Rp {{ number_format($e->jumlah, 0, ',', '.') }}</td>
                <td>
                    @php
                        $imgSrc = null;
                        if ($e->bukti_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($e->bukti_path)) {
                            $fullPath = storage_path('app/public/' . $e->bukti_path);
                            if (is_file($fullPath)) {
                                $imgData = base64_encode(file_get_contents($fullPath));
                                $mime = mime_content_type($fullPath) ?: 'image/jpeg';
                                $imgSrc = 'data:' . $mime . ';base64,' . $imgData;
                            }
                        }
                    @endphp
                    @if($imgSrc)
                        <img src="{{ $imgSrc }}" alt="Bukti" style="max-width:50px;max-height:50px;object-fit:cover;border:1px solid #ccc;" />
                    @else
                        —
                    @endif
                </td>
                <td>{{ $e->tanggal_pengeluaran?->translatedFormat('d M Y') ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($expenses->isEmpty())
    <p>Belum ada data pengeluaran.</p>
    @endif
</body>
</html>
