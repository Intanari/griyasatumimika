<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal Rehabilitasi Mingguan - {{ config('app.name') }}</title>
    <style>
        @page { size: A4 landscape; margin: 10mm; }
        * { box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; font-size: 9px; color: #1e293b; padding: 16px; margin: 0; }
        h1 { font-size: 16px; margin: 0 0 4px 0; color: #0f172a; font-weight: 800; }
        .meta { color: #64748b; margin-bottom: 12px; font-size: 9px; }
        @media print { body { padding: 0; } .cal-day { break-inside: avoid; } }

        .header-row { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 2px solid #e2e8f0; }
        .header-logo { width: 44px; height: 44px; background: linear-gradient(135deg, #2563eb, #0ea5e9); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
        .header-title { flex: 1; }
        .header-title h1 { margin: 0 0 2px 0; }
        .header-title .meta { margin: 0; }

        .cal-week { display: table; width: 100%; border-collapse: collapse; table-layout: fixed; }
        .cal-row { display: table-row; }
        .cal-day { display: table-cell; width: 14.28%; vertical-align: top; border: 1px solid #e2e8f0; padding: 0; }
        .cal-day-header { background: linear-gradient(135deg, #2563eb, #0ea5e9); color: #fff; padding: 10px 8px; text-align: center; font-weight: 700; font-size: 10px; }
        .cal-day-body { padding: 8px; min-height: 60px; }
        .cal-item { display: block; padding: 8px 10px; margin-bottom: 6px; border-radius: 8px; font-size: 8px; line-height: 1.35; background: #f8fafc; border: 1px solid #e2e8f0; }
        .cal-item:last-child { margin-bottom: 0; }
        .cal-item-name { font-weight: 700; color: #0f172a; display: block; font-size: 9px; margin-bottom: 2px; }
        .cal-item-time { font-size: 8px; color: #2563eb; font-weight: 600; margin-bottom: 1px; }
        .cal-item-place { font-size: 7px; color: #64748b; }
        .cal-item-pembimbing { font-size: 7px; color: #475569; margin-top: 2px; font-style: italic; }
        .cal-empty { font-size: 8px; color: #94a3b8; font-style: italic; text-align: center; padding: 16px 0; }
    </style>
</head>
<body>
    <div class="header-row">
        <div class="header-logo">🧠</div>
        <div class="header-title">
            <h1>Jadwal Rehabilitasi Mingguan</h1>
            <p class="meta">{{ config('app.name') }} — Dicetak: {{ now()->locale('id')->translatedFormat('d F Y H:i') }} — Total {{ $jadwals->count() }} kegiatan</p>
        </div>
    </div>

    <div class="cal-week">
        <div class="cal-row">
            @foreach(\App\Models\RehabilitationSchedule::HARI_LIST as $key => $label)
                @php $items = $byHari[$key] ?? collect(); @endphp
                <div class="cal-day">
                    <div class="cal-day-header">{{ $label }}</div>
                    <div class="cal-day-body">
                        @forelse($items as $j)
                            @php
                                $jam = \Carbon\Carbon::parse($j->jam_mulai)->format('H:i');
                                if ($j->jam_selesai) $jam .= '–' . \Carbon\Carbon::parse($j->jam_selesai)->format('H:i');
                            @endphp
                            <div class="cal-item">
                                <span class="cal-item-name">{{ $j->nama_kegiatan }}</span>
                                <span class="cal-item-time">{{ $jam }}</span>
                                @if($j->tempat)<span class="cal-item-place">{{ $j->tempat }}</span>@endif
                                @if($j->pembimbingUser)<span class="cal-item-pembimbing">{{ $j->pembimbingUser->name }}</span>@endif
                            </div>
                        @empty
                            <span class="cal-empty">—</span>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if($jadwals->isEmpty())
        <p style="color: #94a3b8; font-style: italic; margin-top: 24px;">Tidak ada jadwal rehabilitasi aktif.</p>
    @endif
</body>
</html>
