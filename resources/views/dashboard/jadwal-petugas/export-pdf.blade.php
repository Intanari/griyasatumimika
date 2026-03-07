<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal Petugas - {{ config('app.name') }}</title>
    <style>
        @page { size: A4; margin: 12mm; }
        * { box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; font-size: 9px; color: #1e293b; padding: 12px; margin: 0; }
        h1 { font-size: 14px; margin: 0 0 2px 0; color: #0f172a; }
        .meta { color: #64748b; margin-bottom: 8px; font-size: 9px; }
        @media print {
            body { padding: 0; font-size: 8px; }
            .cal-container { page-break-inside: avoid; break-inside: avoid; }
        }

        .cal-container { width: 100%; margin-top: 4px; }
        .cal-week { display: table; width: 100%; border-collapse: collapse; table-layout: fixed; }
        .cal-row { display: table-row; }
        .cal-day { display: table-cell; width: 14.28%; vertical-align: top; border: 1px solid #e2e8f0; padding: 0; }
        .cal-day-header { background: #f8fafc; padding: 4px 3px; text-align: center; border-bottom: 1px solid #e2e8f0; font-weight: 700; font-size: 8px; }
        .cal-day-name { display: block; color: #64748b; font-size: 7px; text-transform: uppercase; letter-spacing: 0.03em; }
        .cal-day-num { display: block; font-size: 10px; color: #1e293b; margin-top: 1px; }
        .cal-day-body { padding: 3px; min-height: 42px; }
        .cal-day-out { background: #f8fafc; }
        .cal-day-out .cal-day-body { min-height: 28px; }
        .cal-item { display: block; padding: 3px 4px; margin-bottom: 2px; border-radius: 3px; font-size: 7px; line-height: 1.2; border: 1px solid rgba(0,0,0,0.06); }
        .cal-item:last-child { margin-bottom: 0; }
        .cal-item-name { font-weight: 700; color: #1e293b; display: block; font-size: 7px; }
        .cal-item-shift { font-size: 6px; font-weight: 600; margin-top: 1px; }
        .cal-item-time { font-size: 6px; color: #64748b; margin-top: 0; font-variant-numeric: tabular-nums; }
        .cal-empty { font-size: 6px; color: #94a3b8; font-style: italic; padding: 4px 0; text-align: center; }
        .cal-pagi { background: #fffbeb; color: #b45309; border-color: #fde68a; }
        .cal-siang { background: #ecfdf5; color: #047857; border-color: #a7f3d0; }
        .cal-malam { background: #eef2ff; color: #4338ca; border-color: #c7d2fe; }
        .cal-default { background: #f1f5f9; color: #475569; border-color: #e2e8f0; }
    </style>
</head>
<body>
    <h1>Jadwal Petugas — Yayasan Rehabilitasi</h1>
    <p class="meta">Periode: {{ $monthStart->translatedFormat('F Y') }} (1 – {{ $monthEnd->format('d') }}) — Dicetak: {{ now()->translatedFormat('d F Y H:i') }} — Total: {{ $jadwals->count() }} jadwal</p>

    <div class="cal-container">
        @foreach ($weeks as $weekDates)
            <div class="cal-week">
                <div class="cal-row">
                    @foreach ($weekDates as $date)
                        @php
                            $isCurrentMonth = $date !== null;
                            $dateKey = $isCurrentMonth ? $date->format('Y-m-d') : '';
                            $items = $isCurrentMonth ? $jadwalsByDate->get($dateKey, collect()) : collect();
                        @endphp
                        <div class="cal-day {{ !$isCurrentMonth ? 'cal-day-out' : '' }}">
                            <div class="cal-day-header">
                                @if($isCurrentMonth)
                                    <span class="cal-day-name">{{ $date->translatedFormat('D') }}</span>
                                    <span class="cal-day-num">{{ $date->format('d') }}</span>
                                @else
                                    <span class="cal-day-num">—</span>
                                @endif
                            </div>
                            <div class="cal-day-body">
                                @forelse($items as $j)
                                    @php $slug = in_array(strtolower($j->shift_label ?? ''), ['pagi','siang','malam']) ? strtolower($j->shift_label) : 'default'; @endphp
                                    <div class="cal-item cal-{{ $slug }}">
                                        <span class="cal-item-name">{{ $j->user->name ?? '–' }}</span>
                                        <span class="cal-item-shift">{{ $j->shift_label }} {{ $j->jam_display }}</span>
                                    </div>
                                @empty
                                    @if($isCurrentMonth)
                                        <span class="cal-empty">—</span>
                                    @endif
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    @if (empty($weeks))
        <p style="color: #94a3b8; font-style: italic;">Tidak ada jadwal dalam periode yang dipilih.</p>
    @endif
</body>
</html>
