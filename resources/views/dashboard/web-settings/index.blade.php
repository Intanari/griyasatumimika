@extends('layouts.dashboard')

@section('title', 'Pengaturan Web')
@section('topbar-title', 'Pengaturan Web')

@section('content')
<a href="{{ route('dashboard') }}" class="page-back-link">Kembali</a>

<div class="card admin-account-card" style="margin-bottom: 1.5rem;">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <h2 class="admin-account-title">Warna Teks Heading (H1–H6)</h2>
            <p class="admin-account-desc">Atur warna teks untuk heading H1 sampai H6 pada halaman publik.</p>
        </div>
    </div>
    <form action="{{ route('dashboard.web-settings.save-colors') }}" method="POST" style="padding-top: 0;">
        @csrf
        <div class="form-row" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
            <div class="form-group">
                <label for="h1_color">Warna H1</label>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="color" id="h1_color" name="h1_color" value="{{ ($settings['h1_color'] ?? '') ?: '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="{{ $settings['h1_color'] ?? '#ffffff' }}" id="h1_color_text" style="flex: 1; padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px;" placeholder="#ffffff">
                </div>
            </div>
            <div class="form-group">
                <label for="h2_color">Warna H2</label>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="color" id="h2_color" name="h2_color" value="{{ ($settings['h2_color'] ?? '') ?: '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="{{ $settings['h2_color'] ?? '#ffffff' }}" id="h2_color_text" style="flex: 1; padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px;" placeholder="#ffffff">
                </div>
            </div>
            <div class="form-group">
                <label for="h3_color">Warna H3</label>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="color" id="h3_color" name="h3_color" value="{{ ($settings['h3_color'] ?? '') ?: '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="{{ $settings['h3_color'] ?? '#ffffff' }}" id="h3_color_text" style="flex: 1; padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px;" placeholder="#ffffff">
                </div>
            </div>
            <div class="form-group">
                <label for="h4_color">Warna H4</label>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="color" id="h4_color" name="h4_color" value="{{ ($settings['h4_color'] ?? '') ?: '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="{{ $settings['h4_color'] ?? '#ffffff' }}" id="h4_color_text" style="flex: 1; padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px;" placeholder="#ffffff">
                </div>
            </div>
            <div class="form-group">
                <label for="h5_color">Warna H5</label>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="color" id="h5_color" name="h5_color" value="{{ ($settings['h5_color'] ?? '') ?: '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="{{ $settings['h5_color'] ?? '#ffffff' }}" id="h5_color_text" style="flex: 1; padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px;" placeholder="#ffffff">
                </div>
            </div>
            <div class="form-group">
                <label for="h6_color">Warna H6</label>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="color" id="h6_color" name="h6_color" value="{{ ($settings['h6_color'] ?? '') ?: '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="{{ $settings['h6_color'] ?? '#ffffff' }}" id="h6_color_text" style="flex: 1; padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px;" placeholder="#ffffff">
                </div>
            </div>
        </div>
        <div class="form-actions" style="margin-top: 1.25rem; border-top: 1px solid var(--border); padding-top: 1.25rem;">
            <button type="submit" class="btn btn-primary">Simpan Warna Heading</button>
        </div>
    </form>
</div>

{{-- Card Paragraf (p): tanpa class + per class --}}
<div class="card admin-account-card" style="margin-bottom: 1.5rem;">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <h2 class="admin-account-title">Warna Paragraf (p)</h2>
            <p class="admin-account-desc">Atur warna teks untuk <code>&lt;p&gt;</code> tanpa class dan per class.</p>
        </div>
    </div>
    <form action="{{ route('dashboard.web-settings.save-p-colors') }}" method="POST" style="padding-top: 0;">
        @csrf
        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label for="p_color">p tanpa class</label>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="color" id="p_color" name="p_color" value="{{ ($settings['p_color'] ?? '') ?: '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                <input type="text" value="{{ $settings['p_color'] ?? '#ffffff' }}" id="p_color_text" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 100px;" placeholder="#ffffff">
            </div>
        </div>
        <div style="margin-bottom: 0.75rem; font-weight: 600;">p per class</div>
        <div id="p-colors-container">
            @foreach(($settings['p_colors'] ?? []) as $idx => $item)
            <div class="p-color-row" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <div style="min-width: 160px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label>
                    <input type="text" name="p_colors[{{ $idx }}][class]" value="{{ $item['class'] ?? '' }}" placeholder="contoh: intro" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; min-width: 160px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna</label>
                    <input type="color" name="p_colors[{{ $idx }}][color]" value="{{ $item['color'] ?? '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="{{ $item['color'] ?? '#ffffff' }}" class="p-color-hex" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 90px;">
                </div>
                <button type="button" class="p-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>
            </div>
            @endforeach
            @if(empty($settings['p_colors']))
            <div class="p-color-row" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <div style="min-width: 160px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label>
                    <input type="text" name="p_colors[0][class]" placeholder="contoh: intro" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; min-width: 160px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna</label>
                    <input type="color" name="p_colors[0][color]" value="#ffffff" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="#ffffff" class="p-color-hex" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 90px;">
                </div>
                <button type="button" class="p-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>
            </div>
            @endif
        </div>
        <div style="margin-bottom: 1rem;">
            <button type="button" id="btn-tambah-p" class="btn btn-outline btn-sm">+ Tambah p per class</button>
        </div>
        <div class="form-actions" style="margin-top: 1.25rem; border-top: 1px solid var(--border); padding-top: 1.25rem;">
            <button type="submit" class="btn btn-primary">Simpan Warna Paragraf</button>
        </div>
    </form>
</div>

{{-- Card Span: tanpa class + per class --}}
<div class="card admin-account-card" style="margin-bottom: 1.5rem;">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <h2 class="admin-account-title">Warna Span</h2>
            <p class="admin-account-desc">Atur warna untuk <code>&lt;span&gt;</code> tanpa class dan per class.</p>
        </div>
    </div>
    <form action="{{ route('dashboard.web-settings.save-span-colors') }}" method="POST" style="padding-top: 0;">
        @csrf
        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label for="span_color">span tanpa class</label>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="color" id="span_color" name="span_color" value="{{ ($settings['span_color'] ?? '') ?: '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                <input type="text" value="{{ $settings['span_color'] ?? '#ffffff' }}" id="span_color_text" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 100px;" placeholder="#ffffff">
            </div>
        </div>
        <div style="margin-bottom: 0.75rem; font-weight: 600;">span per class</div>
        <div id="span-colors-container">
            @foreach(($settings['span_colors'] ?? []) as $idx => $item)
            <div class="span-color-row" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <div style="min-width: 180px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label>
                    <input type="text" name="span_colors[{{ $idx }}][class]" value="{{ $item['class'] ?? '' }}" placeholder="contoh: highlight" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; min-width: 180px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna</label>
                    <input type="color" name="span_colors[{{ $idx }}][color]" value="{{ $item['color'] ?? '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="{{ $item['color'] ?? '#ffffff' }}" class="span-color-hex" placeholder="#ffffff" style="flex: 1; padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; max-width: 100px;">
                </div>
                <button type="button" class="span-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>
            </div>
            @endforeach
            @if(empty($settings['span_colors']))
            <div class="span-color-row" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <div style="min-width: 180px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label>
                    <input type="text" name="span_colors[0][class]" placeholder="contoh: highlight" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; min-width: 180px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna</label>
                    <input type="color" name="span_colors[0][color]" value="#ffffff" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="#ffffff" class="span-color-hex" placeholder="#ffffff" style="flex: 1; padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; max-width: 100px;">
                </div>
                <button type="button" class="span-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>
            </div>
            @endif
        </div>
        <div style="margin-bottom: 1rem;">
            <button type="button" id="btn-tambah-span" class="btn btn-outline btn-sm">+ Tambah Warna Span</button>
        </div>
        <div class="form-actions" style="margin-top: 1.25rem; border-top: 1px solid var(--border); padding-top: 1.25rem;">
            <button type="submit" class="btn btn-primary">Simpan Warna Span</button>
        </div>
    </form>
</div>

{{-- Card Div: tanpa class + per class --}}
<div class="card admin-account-card" style="margin-bottom: 1.5rem;">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <h2 class="admin-account-title">Warna Div</h2>
            <p class="admin-account-desc">Atur warna teks untuk <code>&lt;div&gt;</code> tanpa class dan per class.</p>
        </div>
    </div>
    <form action="{{ route('dashboard.web-settings.save-div-colors') }}" method="POST" style="padding-top: 0;">
        @csrf
        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label for="div_color">div tanpa class</label>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="color" id="div_color" name="div_color" value="{{ ($settings['div_color'] ?? '') ?: '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                <input type="text" value="{{ $settings['div_color'] ?? '#ffffff' }}" id="div_color_text" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 100px;" placeholder="#ffffff">
            </div>
        </div>
        <div style="margin-bottom: 0.75rem; font-weight: 600;">div per class</div>
        <div id="div-colors-container">
            @foreach(($settings['div_colors'] ?? []) as $idx => $item)
            <div class="div-color-row" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <div style="min-width: 160px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label>
                    <input type="text" name="div_colors[{{ $idx }}][class]" value="{{ $item['class'] ?? '' }}" placeholder="contoh: section-label" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; min-width: 160px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna</label>
                    <input type="color" name="div_colors[{{ $idx }}][color]" value="{{ $item['color'] ?? '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="{{ $item['color'] ?? '#ffffff' }}" class="div-color-hex" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 90px;">
                </div>
                <button type="button" class="div-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>
            </div>
            @endforeach
            @if(empty($settings['div_colors']))
            <div class="div-color-row" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <div style="min-width: 160px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label>
                    <input type="text" name="div_colors[0][class]" placeholder="contoh: section-label" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; min-width: 160px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna</label>
                    <input type="color" name="div_colors[0][color]" value="#ffffff" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="#ffffff" class="div-color-hex" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 90px;">
                </div>
                <button type="button" class="div-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>
            </div>
            @endif
        </div>
        <div style="margin-bottom: 1rem;">
            <button type="button" id="btn-tambah-div" class="btn btn-outline btn-sm">+ Tambah div per class</button>
        </div>
        <div class="form-actions" style="margin-top: 1.25rem; border-top: 1px solid var(--border); padding-top: 1.25rem;">
            <button type="submit" class="btn btn-primary">Simpan Warna Div</button>
        </div>
    </form>
</div>

{{-- Card Link (a): tanpa class + per class --}}
<div class="card admin-account-card" style="margin-bottom: 1.5rem;">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <h2 class="admin-account-title">Warna Link (a)</h2>
            <p class="admin-account-desc">Atur warna teks untuk <code>&lt;a&gt;</code> tanpa class dan per class.</p>
        </div>
    </div>
    <form action="{{ route('dashboard.web-settings.save-link-colors') }}" method="POST" style="padding-top: 0;">
        @csrf
        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label for="a_color">a tanpa class</label>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="color" id="a_color" name="a_color" value="{{ ($settings['a_color'] ?? '') ?: '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                <input type="text" value="{{ $settings['a_color'] ?? '#ffffff' }}" id="a_color_text" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 100px;" placeholder="#ffffff">
            </div>
        </div>
        <div style="margin-bottom: 0.75rem; font-weight: 600;">a per class</div>
        <div id="a-colors-container">
            @foreach(($settings['a_colors'] ?? []) as $idx => $item)
            <div class="a-color-row" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <div style="min-width: 160px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label>
                    <input type="text" name="a_colors[{{ $idx }}][class]" value="{{ $item['class'] ?? '' }}" placeholder="contoh: link-primary" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; min-width: 160px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna</label>
                    <input type="color" name="a_colors[{{ $idx }}][color]" value="{{ $item['color'] ?? '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="{{ $item['color'] ?? '#ffffff' }}" class="a-color-hex" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 90px;">
                </div>
                <button type="button" class="a-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>
            </div>
            @endforeach
            @if(empty($settings['a_colors']))
            <div class="a-color-row" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <div style="min-width: 160px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label>
                    <input type="text" name="a_colors[0][class]" placeholder="contoh: link-primary" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; min-width: 160px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna</label>
                    <input type="color" name="a_colors[0][color]" value="#ffffff" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="#ffffff" class="a-color-hex" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 90px;">
                </div>
                <button type="button" class="a-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>
            </div>
            @endif
        </div>
        <div style="margin-bottom: 1rem;">
            <button type="button" id="btn-tambah-a" class="btn btn-outline btn-sm">+ Tambah a per class</button>
        </div>
        <div class="form-actions" style="margin-top: 1.25rem; border-top: 1px solid var(--border); padding-top: 1.25rem;">
            <button type="submit" class="btn btn-primary">Simpan Warna Link</button>
        </div>
    </form>
</div>

{{-- Card Tombol: tanpa class (warna + text) + per class (warna + text) --}}
<div class="card admin-account-card" style="margin-bottom: 1.5rem;">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <h2 class="admin-account-title">Warna Tombol</h2>
            <p class="admin-account-desc">Atur warna background dan teks tombol. Tombol tanpa class untuk <code>&lt;button&gt;</code> tanpa class; per class untuk <code>&lt;a class="btn-hero-primary"&gt;</code> dll.</p>
        </div>
    </div>
    <form action="{{ route('dashboard.web-settings.save-button-colors') }}" method="POST" style="padding-top: 0;">
        @csrf
        <div class="form-group" style="margin-bottom: 1.5rem; padding: 1rem; background: var(--card-bg-secondary, #f8fafc); border-radius: 8px;">
            <label style="display: block; margin-bottom: 0.75rem; font-weight: 600;">Tombol tanpa class</label>
            <div style="display: flex; flex-wrap: wrap; gap: 1.5rem;">
                <div>
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna Tombol</label>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="color" id="button_color" name="button_color" value="{{ ($settings['button_color'] ?? '') ?: '#2563eb' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                        <input type="text" value="{{ $settings['button_color'] ?? '#2563eb' }}" id="button_color_text" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 100px;">
                    </div>
                </div>
                <div>
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna Teks Tombol</label>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="color" id="button_text_color" name="button_text_color" value="{{ ($settings['button_text_color'] ?? '') ?: '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                        <input type="text" value="{{ $settings['button_text_color'] ?? '#ffffff' }}" id="button_text_color_text" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 100px;">
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-bottom: 0.75rem; font-weight: 600;">Tombol per class</div>
        <div id="button-colors-container">
            @foreach(($settings['button_colors'] ?? []) as $idx => $item)
            <div class="button-color-row" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <div style="min-width: 140px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label>
                    <input type="text" name="button_colors[{{ $idx }}][class]" value="{{ $item['class'] ?? '' }}" placeholder="contoh: btn-hero-primary" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <div>
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna Tombol</label>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="color" name="button_colors[{{ $idx }}][color]" value="{{ $item['color'] ?? '#2563eb' }}" style="width: 40px; height: 36px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                        <input type="text" value="{{ $item['color'] ?? '#2563eb' }}" class="button-color-hex" style="width: 80px; padding: 0.4rem 0.5rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px;">
                    </div>
                </div>
                <div>
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna Teks</label>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="color" name="button_colors[{{ $idx }}][text_color]" value="{{ $item['text_color'] ?? '#ffffff' }}" class="button-text-color-picker" style="width: 40px; height: 36px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                        <input type="text" value="{{ $item['text_color'] ?? '#ffffff' }}" class="button-text-color-hex" style="width: 80px; padding: 0.4rem 0.5rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px;">
                    </div>
                </div>
                <button type="button" class="button-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>
            </div>
            @endforeach
            @if(empty($settings['button_colors']))
            <div class="button-color-row" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <div style="min-width: 140px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label>
                    <input type="text" name="button_colors[0][class]" placeholder="contoh: btn-hero-primary" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <div>
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna Tombol</label>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="color" name="button_colors[0][color]" value="#2563eb" style="width: 40px; height: 36px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                        <input type="text" value="#2563eb" class="button-color-hex" style="width: 80px; padding: 0.4rem 0.5rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px;">
                    </div>
                </div>
                <div>
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna Teks</label>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="color" name="button_colors[0][text_color]" value="#ffffff" class="button-text-color-picker" style="width: 40px; height: 36px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                        <input type="text" value="#ffffff" class="button-text-color-hex" style="width: 80px; padding: 0.4rem 0.5rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px;">
                    </div>
                </div>
                <button type="button" class="button-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>
            </div>
            @endif
        </div>
        <div style="margin-bottom: 1rem;">
            <button type="button" id="btn-tambah-button" class="btn btn-outline btn-sm">+ Tambah Tombol per class</button>
        </div>
        <div class="form-actions" style="margin-top: 1.25rem; border-top: 1px solid var(--border); padding-top: 1.25rem;">
            <button type="submit" class="btn btn-primary">Simpan Warna Tombol</button>
        </div>
    </form>
</div>

{{-- Card Khusus Class: nama class + warna --}}
<div class="card admin-account-card" style="margin-bottom: 1.5rem;">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <h2 class="admin-account-title">Warna Khusus Class</h2>
            <p class="admin-account-desc">Atur warna teks untuk class CSS bebas (mis. <code>.hero-label</code>, <code>.section-label</code>). Berlaku untuk elemen apapun dengan class tersebut.</p>
        </div>
    </div>
    <form action="{{ route('dashboard.web-settings.save-custom-class-colors') }}" method="POST" style="padding-top: 0;">
        @csrf
        <div style="margin-bottom: 0.75rem; font-weight: 600;">Class per warna</div>
        <div id="custom-class-colors-container">
            @foreach(($settings['custom_class_colors'] ?? []) as $idx => $item)
            <div class="custom-class-color-row" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <div style="min-width: 180px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label>
                    <input type="text" name="custom_class_colors[{{ $idx }}][class]" value="{{ $item['class'] ?? '' }}" placeholder="contoh: hero-label" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; min-width: 180px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna</label>
                    <input type="color" name="custom_class_colors[{{ $idx }}][color]" value="{{ $item['color'] ?? '#ffffff' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="{{ $item['color'] ?? '#ffffff' }}" class="custom-class-color-hex" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 90px;">
                </div>
                <button type="button" class="custom-class-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>
            </div>
            @endforeach
            @if(empty($settings['custom_class_colors']))
            <div class="custom-class-color-row" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <div style="min-width: 180px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label>
                    <input type="text" name="custom_class_colors[0][class]" placeholder="contoh: hero-label" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; min-width: 180px;">
                    <label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna</label>
                    <input type="color" name="custom_class_colors[0][color]" value="#ffffff" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" value="#ffffff" class="custom-class-color-hex" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 90px;">
                </div>
                <button type="button" class="custom-class-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>
            </div>
            @endif
        </div>
        <div style="margin-bottom: 1rem;">
            <button type="button" id="btn-tambah-custom-class" class="btn btn-outline btn-sm">+ Tambah Class</button>
        </div>
        <div class="form-actions" style="margin-top: 1.25rem; border-top: 1px solid var(--border); padding-top: 1.25rem;">
            <button type="submit" class="btn btn-primary">Simpan Warna Khusus Class</button>
        </div>
    </form>
</div>

<div class="card admin-account-card">
    <div class="admin-account-header">
        <div class="admin-account-header-text">
            <h2 class="admin-account-title">Background Halaman Web</h2>
            <p class="admin-account-desc">Pilih menggunakan warna solid atau gambar sebagai background halaman publik.</p>
        </div>
    </div>
    <form action="{{ route('dashboard.web-settings.save-background') }}" method="POST" enctype="multipart/form-data" style="padding-top: 0;">
        @csrf
        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Jenis Background</label>
            <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="radio" name="background_type" value="warna" {{ ($settings['background_type'] ?? 'gambar') === 'warna' ? 'checked' : '' }}>
                    Warna
                </label>
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="radio" name="background_type" value="gambar" {{ ($settings['background_type'] ?? 'gambar') === 'gambar' ? 'checked' : '' }}>
                    Gambar
                </label>
            </div>
        </div>
        <div id="bg-warna-section" class="form-group" style="margin-bottom: 1rem; {{ ($settings['background_type'] ?? 'gambar') !== 'warna' ? 'display: none;' : '' }}">
            <div class="form-group" style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Mode Tema Warna</label>
                <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="radio" name="background_color_mode" value="global" {{ ($settings['background_color_mode'] ?? 'global') === 'global' ? 'checked' : '' }}>
                        1 tema warna untuk semua halaman publik
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="radio" name="background_color_mode" value="per_page" {{ ($settings['background_color_mode'] ?? 'global') === 'per_page' ? 'checked' : '' }}>
                        1 tema warna per halaman
                    </label>
                </div>
            </div>
            <div id="bg-warna-global-section" class="form-group" style="margin-bottom: 1rem; {{ ($settings['background_color_mode'] ?? 'global') !== 'global' ? 'display: none;' : '' }}">
                <label for="background_color">Warna Background (semua halaman)</label>
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.25rem;">
                    <input type="color" id="background_color" name="background_color" value="{{ ($settings['background_color'] ?? '') ?: '#0f172a' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                    <input type="text" id="background_color_text" value="{{ $settings['background_color'] ?? '#0f172a' }}" placeholder="#0f172a" style="padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px; width: 120px;">
                </div>
            </div>
            <div id="bg-warna-per-page-section" class="form-group" style="margin-bottom: 1rem; {{ ($settings['background_color_mode'] ?? 'global') !== 'per_page' ? 'display: none;' : '' }}">
                <label style="display: block; margin-bottom: 0.75rem;">Warna per halaman</label>
                @php $bgColors = $settings['background_colors'] ?? []; @endphp
                <div style="display: grid; gap: 1rem; max-height: 400px; overflow-y: auto; padding-right: 0.5rem;">
                    @foreach($publicPageSlugs ?? [] as $slug => $label)
                    <div style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem; background: var(--card-bg); border: 1px solid var(--border); border-radius: 10px; flex-wrap: wrap;">
                        <div style="min-width: 140px;"><label style="font-size: 0.9rem; font-weight: 600;">{{ $label }}</label></div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="color" id="bg_color_{{ $slug }}" name="background_color_{{ $slug }}" value="{{ $bgColors[$slug] ?? '#0f172a' }}" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">
                            <input type="text" class="bg-color-hex" data-slug="{{ $slug }}" value="{{ $bgColors[$slug] ?? '#0f172a' }}" placeholder="#0f172a" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 100px;">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div id="bg-gambar-section" class="form-group" style="margin-bottom: 1rem; {{ ($settings['background_type'] ?? 'gambar') !== 'gambar' ? 'display: none;' : '' }}">
            <div class="form-group" style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Mode Gambar</label>
                <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="radio" name="background_image_mode" value="global" {{ ($settings['background_image_mode'] ?? 'global') === 'global' ? 'checked' : '' }}>
                        1 gambar untuk semua halaman publik
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="radio" name="background_image_mode" value="per_page" {{ ($settings['background_image_mode'] ?? 'global') === 'per_page' ? 'checked' : '' }}>
                        1 gambar per halaman
                    </label>
                </div>
            </div>
            <div id="bg-global-section" class="form-group" style="margin-bottom: 1rem; {{ ($settings['background_image_mode'] ?? 'global') !== 'global' ? 'display: none;' : '' }}">
                <label for="background_image">Gambar Background (semua halaman)</label>
                <input type="file" id="background_image" name="background_image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="form-control">
                @if(!empty($settings['background_image']))
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.5rem;">Gambar saat ini: <a href="{{ asset('storage/' . $settings['background_image']) }}" target="_blank">Lihat</a></p>
                @endif
            </div>
            <div id="bg-per-page-section" class="form-group" style="margin-bottom: 1rem; {{ ($settings['background_image_mode'] ?? 'global') !== 'per_page' ? 'display: none;' : '' }}">
                <label style="display: block; margin-bottom: 0.75rem;">Gambar per halaman</label>
                <div style="display: grid; gap: 1rem; max-height: 400px; overflow-y: auto; padding-right: 0.5rem;">
                    @php $bgImages = $settings['background_images'] ?? []; @endphp
                    @foreach($publicPageSlugs ?? [] as $slug => $label)
                    <div style="display: flex; align-items: flex-start; gap: 1rem; padding: 0.75rem; background: var(--card-bg); border: 1px solid var(--border); border-radius: 10px;">
                        <div style="flex: 1; min-width: 0;">
                            <label style="font-size: 0.9rem; font-weight: 600; display: block; margin-bottom: 0.25rem;">{{ $label }}</label>
                            <input type="file" name="background_image_{{ $slug }}" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="form-control" style="font-size: 0.85rem;">
                            @if(!empty($bgImages[$slug]))
                                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.35rem;">Saat ini: <a href="{{ asset('storage/' . $bgImages[$slug]) }}" target="_blank">Lihat</a></p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div id="bg-overlay-section" class="form-group" style="margin-bottom: 1rem;">
            <label for="background_overlay_opacity">Tingkat Transparansi Filter Overlay (0 = tidak ada filter, 1 = sangat gelap) — berlaku untuk Warna &amp; Gambar</label>
            <input type="range" id="background_overlay_opacity" name="background_overlay_opacity" min="0" max="1" step="0.05" value="{{ $settings['background_overlay_opacity'] ?? '0.4' }}" style="width: 100%; max-width: 300px; margin-top: 0.25rem;">
            <span id="opacity_display" style="font-size: 0.9rem; margin-left: 0.5rem;">{{ $settings['background_overlay_opacity'] ?? '0.4' }}</span>
        </div>
        <div class="form-actions" style="margin-top: 1.25rem; border-top: 1px solid var(--border); padding-top: 1.25rem;">
            <button type="submit" class="btn btn-primary">Simpan Background</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function syncColorText(colorId, textId) {
        var colorEl = document.getElementById(colorId);
        var textEl = document.getElementById(textId);
        if (colorEl && textEl) {
            colorEl.addEventListener('input', function() { textEl.value = this.value; });
            textEl.addEventListener('input', function() {
                if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) colorEl.value = this.value;
            });
        }
    }
    ['1','2','3','4','5','6'].forEach(function(n) {
        syncColorText('h' + n + '_color', 'h' + n + '_color_text');
    });
    syncColorText('p_color', 'p_color_text');
    syncColorText('span_color', 'span_color_text');
    syncColorText('div_color', 'div_color_text');
    syncColorText('a_color', 'a_color_text');
    syncColorText('button_color', 'button_color_text');
    syncColorText('button_text_color', 'button_text_color_text');

    // p per class: tambah baris
    var pContainer = document.getElementById('p-colors-container');
    var btnTambahP = document.getElementById('btn-tambah-p');
    var pRowIndex = pContainer ? pContainer.querySelectorAll('.p-color-row').length : 0;
    function addPColorRow() {
        if (!pContainer) return;
        var row = document.createElement('div');
        row.className = 'p-color-row';
        row.style.cssText = 'display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;';
        row.innerHTML = '<div style="min-width: 160px;"><label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label><input type="text" name="p_colors[' + pRowIndex + '][class]" placeholder="contoh: intro" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;"></div>' +
            '<div style="display: flex; align-items: center; gap: 0.5rem; min-width: 160px;"><label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna</label>' +
            '<input type="color" name="p_colors[' + pRowIndex + '][color]" value="#ffffff" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">' +
            '<input type="text" value="#ffffff" class="p-color-hex" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 90px;"></div>' +
            '<button type="button" class="p-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>';
        pContainer.appendChild(row);
        pRowIndex++;
        var colorIn = row.querySelector('input[type="color"]');
        var hexIn = row.querySelector('.p-color-hex');
        if (colorIn && hexIn) {
            colorIn.addEventListener('input', function() { hexIn.value = this.value; });
            hexIn.addEventListener('input', function() { if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) colorIn.value = this.value; });
        }
        row.querySelector('.p-color-remove')?.addEventListener('click', function() { row.remove(); });
    }
    if (btnTambahP) btnTambahP.addEventListener('click', addPColorRow);
    document.querySelectorAll('#p-colors-container .p-color-row').forEach(function(row) {
        var colorIn = row.querySelector('input[type="color"]');
        var hexIn = row.querySelector('.p-color-hex');
        if (colorIn && hexIn) {
            colorIn.addEventListener('input', function() { hexIn.value = this.value; });
            hexIn.addEventListener('input', function() { if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) colorIn.value = this.value; });
        }
        row.querySelector('.p-color-remove')?.addEventListener('click', function() { row.remove(); });
    });

    // Span colors: tambah baris
    var spanContainer = document.getElementById('span-colors-container');
    var btnTambahSpan = document.getElementById('btn-tambah-span');
    var spanRowIndex = spanContainer ? spanContainer.querySelectorAll('.span-color-row').length : 0;

    function addSpanColorRow() {
        if (!spanContainer) return;
        var row = document.createElement('div');
        row.className = 'span-color-row';
        row.style.cssText = 'display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;';
        row.innerHTML = '<div style="min-width: 180px;"><label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label><input type="text" name="span_colors[' + spanRowIndex + '][class]" placeholder="contoh: highlight" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;"></div>' +
            '<div style="display: flex; align-items: center; gap: 0.5rem; min-width: 180px;"><label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna</label>' +
            '<input type="color" name="span_colors[' + spanRowIndex + '][color]" value="#ffffff" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">' +
            '<input type="text" value="#ffffff" class="span-color-hex" placeholder="#ffffff" style="flex: 1; padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; max-width: 100px;"></div>' +
            '<button type="button" class="span-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>';
        spanContainer.appendChild(row);
        spanRowIndex++;
        bindSpanRowEvents(row);
    }

    function bindSpanRowEvents(row) {
        var colorInput = row.querySelector('input[type="color"]');
        var hexInput = row.querySelector('.span-color-hex');
        if (colorInput && hexInput) {
            colorInput.addEventListener('input', function() { hexInput.value = this.value; });
            hexInput.addEventListener('input', function() {
                if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) colorInput.value = this.value;
            });
        }
        var removeBtn = row.querySelector('.span-color-remove');
        if (removeBtn) removeBtn.addEventListener('click', function() { row.remove(); });
    }

    if (btnTambahSpan) btnTambahSpan.addEventListener('click', addSpanColorRow);
    document.querySelectorAll('#span-colors-container .span-color-row').forEach(function(row) { bindSpanRowEvents(row); });

    // a per class: tambah baris
    var aContainer = document.getElementById('a-colors-container');
    var btnTambahA = document.getElementById('btn-tambah-a');
    var aRowIndex = aContainer ? aContainer.querySelectorAll('.a-color-row').length : 0;
    function addAColorRow() {
        if (!aContainer) return;
        var row = document.createElement('div');
        row.className = 'a-color-row';
        row.style.cssText = 'display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;';
        row.innerHTML = '<div style="min-width: 160px;"><label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label><input type="text" name="a_colors[' + aRowIndex + '][class]" placeholder="contoh: link-primary" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;"></div>' +
            '<div style="display: flex; align-items: center; gap: 0.5rem; min-width: 160px;"><label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna</label>' +
            '<input type="color" name="a_colors[' + aRowIndex + '][color]" value="#ffffff" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">' +
            '<input type="text" value="#ffffff" class="a-color-hex" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 90px;"></div>' +
            '<button type="button" class="a-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>';
        aContainer.appendChild(row);
        aRowIndex++;
        var colorIn = row.querySelector('input[type="color"]');
        var hexIn = row.querySelector('.a-color-hex');
        if (colorIn && hexIn) {
            colorIn.addEventListener('input', function() { hexIn.value = this.value; });
            hexIn.addEventListener('input', function() { if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) colorIn.value = this.value; });
        }
        row.querySelector('.a-color-remove')?.addEventListener('click', function() { row.remove(); });
    }
    if (btnTambahA) btnTambahA.addEventListener('click', addAColorRow);
    document.querySelectorAll('#a-colors-container .a-color-row').forEach(function(row) {
        var colorIn = row.querySelector('input[type="color"]');
        var hexIn = row.querySelector('.a-color-hex');
        if (colorIn && hexIn) {
            colorIn.addEventListener('input', function() { hexIn.value = this.value; });
            hexIn.addEventListener('input', function() { if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) colorIn.value = this.value; });
        }
        row.querySelector('.a-color-remove')?.addEventListener('click', function() { row.remove(); });
    });

    // Button colors: tambah baris (dengan warna tombol + warna teks)
    var btnContainer = document.getElementById('button-colors-container');
    var btnTambahButton = document.getElementById('btn-tambah-button');
    var buttonRowIndex = btnContainer ? btnContainer.querySelectorAll('.button-color-row').length : 0;

    function addButtonColorRow() {
        if (!btnContainer) return;
        var row = document.createElement('div');
        row.className = 'button-color-row';
        row.style.cssText = 'display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;';
        row.innerHTML = '<div style="min-width: 140px;"><label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label><input type="text" name="button_colors[' + buttonRowIndex + '][class]" placeholder="contoh: btn-hero-primary" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;"></div>' +
            '<div><label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna Tombol</label><div style="display: flex; align-items: center; gap: 0.5rem;"><input type="color" name="button_colors[' + buttonRowIndex + '][color]" value="#2563eb" style="width: 40px; height: 36px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;"><input type="text" value="#2563eb" class="button-color-hex" style="width: 80px; padding: 0.4rem 0.5rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px;"></div></div>' +
            '<div><label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna Teks</label><div style="display: flex; align-items: center; gap: 0.5rem;"><input type="color" name="button_colors[' + buttonRowIndex + '][text_color]" value="#ffffff" class="button-text-color-picker" style="width: 40px; height: 36px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;"><input type="text" value="#ffffff" class="button-text-color-hex" style="width: 80px; padding: 0.4rem 0.5rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px;"></div></div>' +
            '<button type="button" class="button-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>';
        btnContainer.appendChild(row);
        buttonRowIndex++;
        bindButtonRowEvents(row);
    }

    function bindButtonRowEvents(row) {
        var colorInput = row.querySelector('input[name*="[color]"]');
        var hexInput = row.querySelector('.button-color-hex');
        if (colorInput && hexInput) {
            colorInput.addEventListener('input', function() { hexInput.value = this.value; });
            hexInput.addEventListener('input', function() { if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) colorInput.value = this.value; });
        }
        var textColorInput = row.querySelector('.button-text-color-picker');
        var textHexInput = row.querySelector('.button-text-color-hex');
        if (textColorInput && textHexInput) {
            textColorInput.addEventListener('input', function() { textHexInput.value = this.value; });
            textHexInput.addEventListener('input', function() { if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) textColorInput.value = this.value; });
        }
        row.querySelector('.button-color-remove')?.addEventListener('click', function() { row.remove(); });
    }

    if (btnTambahButton) btnTambahButton.addEventListener('click', addButtonColorRow);
    document.querySelectorAll('#button-colors-container .button-color-row').forEach(function(row) { bindButtonRowEvents(row); });

    // Div colors: tambah baris
    var divContainer = document.getElementById('div-colors-container');
    var btnTambahDiv = document.getElementById('btn-tambah-div');
    var divRowIndex = divContainer ? divContainer.querySelectorAll('.div-color-row').length : 0;

    function addDivColorRow() {
        if (!divContainer) return;
        var row = document.createElement('div');
        row.className = 'div-color-row';
        row.style.cssText = 'display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;';
        row.innerHTML = '<div style="min-width: 180px;"><label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label><input type="text" name="div_colors[' + divRowIndex + '][class]" placeholder="contoh: section-label" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;"></div>' +
            '<div style="display: flex; align-items: center; gap: 0.5rem; min-width: 180px;"><label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna</label>' +
            '<input type="color" name="div_colors[' + divRowIndex + '][color]" value="#ffffff" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">' +
            '<input type="text" value="#ffffff" class="div-color-hex" placeholder="#ffffff" style="flex: 1; padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; max-width: 100px;"></div>' +
            '<button type="button" class="div-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>';
        divContainer.appendChild(row);
        divRowIndex++;
        bindDivRowEvents(row);
    }

    function bindDivRowEvents(row) {
        var colorInput = row.querySelector('input[type="color"]');
        var hexInput = row.querySelector('.div-color-hex');
        if (colorInput && hexInput) {
            colorInput.addEventListener('input', function() { hexInput.value = this.value; });
            hexInput.addEventListener('input', function() {
                if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) colorInput.value = this.value;
            });
        }
        var removeBtn = row.querySelector('.div-color-remove');
        if (removeBtn) removeBtn.addEventListener('click', function() { row.remove(); });
    }

    if (btnTambahDiv) btnTambahDiv.addEventListener('click', addDivColorRow);
    document.querySelectorAll('#div-colors-container .div-color-row').forEach(function(row) { bindDivRowEvents(row); });

    // Custom class colors: tambah baris
    var customClassContainer = document.getElementById('custom-class-colors-container');
    var btnTambahCustomClass = document.getElementById('btn-tambah-custom-class');
    var customClassRowIndex = customClassContainer ? customClassContainer.querySelectorAll('.custom-class-color-row').length : 0;

    function addCustomClassColorRow() {
        if (!customClassContainer) return;
        var row = document.createElement('div');
        row.className = 'custom-class-color-row';
        row.style.cssText = 'display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;';
        row.innerHTML = '<div style="min-width: 180px;"><label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Nama Class</label><input type="text" name="custom_class_colors[' + customClassRowIndex + '][class]" placeholder="contoh: hero-label" style="width: 100%; padding: 0.5rem 0.75rem; font-size: 0.9rem; border: 1px solid var(--border); border-radius: 8px;"></div>' +
            '<div style="display: flex; align-items: center; gap: 0.5rem; min-width: 180px;"><label style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Warna</label>' +
            '<input type="color" name="custom_class_colors[' + customClassRowIndex + '][color]" value="#ffffff" style="width: 48px; height: 40px; padding: 2px; border-radius: 8px; border: 1px solid var(--border); cursor: pointer;">' +
            '<input type="text" value="#ffffff" class="custom-class-color-hex" style="padding: 0.5rem 0.75rem; font-size: 0.85rem; border: 1px solid var(--border); border-radius: 8px; width: 90px;"></div>' +
            '<button type="button" class="custom-class-color-remove btn btn-outline btn-sm" style="margin-top: 1.5rem;">Hapus</button>';
        customClassContainer.appendChild(row);
        customClassRowIndex++;
        bindCustomClassRowEvents(row);
    }

    function bindCustomClassRowEvents(row) {
        var colorInput = row.querySelector('input[type="color"]');
        var hexInput = row.querySelector('.custom-class-color-hex');
        if (colorInput && hexInput) {
            colorInput.addEventListener('input', function() { hexInput.value = this.value; });
            hexInput.addEventListener('input', function() {
                if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) colorInput.value = this.value;
            });
        }
        var removeBtn = row.querySelector('.custom-class-color-remove');
        if (removeBtn) removeBtn.addEventListener('click', function() { row.remove(); });
    }

    if (btnTambahCustomClass) btnTambahCustomClass.addEventListener('click', addCustomClassColorRow);
    document.querySelectorAll('#custom-class-colors-container .custom-class-color-row').forEach(function(row) { bindCustomClassRowEvents(row); });

    // Opacity slider display
    var opacityEl = document.getElementById('background_overlay_opacity');
    var opacityDisplay = document.getElementById('opacity_display');
    if (opacityEl && opacityDisplay) {
        opacityEl.addEventListener('input', function() {
            opacityDisplay.textContent = this.value;
        });
    }

    // Background type: tampilkan/sembunyikan bagian sesuai pilihan
    var bgTypeRadios = document.querySelectorAll('input[name="background_type"]');
    var bgWarnaSection = document.getElementById('bg-warna-section');
    var bgGambarSection = document.getElementById('bg-gambar-section');
    var bgOverlaySection = document.getElementById('bg-overlay-section');
    var bgGlobalSection = document.getElementById('bg-global-section');
    var bgPerPageSection = document.getElementById('bg-per-page-section');
    var bgColorEl = document.getElementById('background_color');
    var bgColorTextEl = document.getElementById('background_color_text');
    var bgModeRadios = document.querySelectorAll('input[name="background_image_mode"]');
    var bgWarnaGlobalSection = document.getElementById('bg-warna-global-section');
    var bgWarnaPerPageSection = document.getElementById('bg-warna-per-page-section');
    var bgColorModeRadios = document.querySelectorAll('input[name="background_color_mode"]');
    function toggleBackgroundSections() {
        var val = document.querySelector('input[name="background_type"]:checked')?.value || 'gambar';
        if (bgWarnaSection) bgWarnaSection.style.display = val === 'warna' ? 'block' : 'none';
        if (bgGambarSection) bgGambarSection.style.display = val === 'gambar' ? 'block' : 'none';
    }
    function toggleBackgroundImageMode() {
        var mode = document.querySelector('input[name="background_image_mode"]:checked')?.value || 'global';
        if (bgGlobalSection) bgGlobalSection.style.display = mode === 'global' ? 'block' : 'none';
        if (bgPerPageSection) bgPerPageSection.style.display = mode === 'per_page' ? 'block' : 'none';
    }
    function toggleBackgroundColorMode() {
        var mode = document.querySelector('input[name="background_color_mode"]:checked')?.value || 'global';
        if (bgWarnaGlobalSection) bgWarnaGlobalSection.style.display = mode === 'global' ? 'block' : 'none';
        if (bgWarnaPerPageSection) bgWarnaPerPageSection.style.display = mode === 'per_page' ? 'block' : 'none';
    }
    bgTypeRadios.forEach(function(r) { r.addEventListener('change', toggleBackgroundSections); });
    if (bgModeRadios.length) bgModeRadios.forEach(function(r) { r.addEventListener('change', toggleBackgroundImageMode); });
    if (bgColorModeRadios.length) bgColorModeRadios.forEach(function(r) { r.addEventListener('change', toggleBackgroundColorMode); });
    document.querySelectorAll('#bg-warna-per-page-section .bg-color-hex').forEach(function(hexEl) {
        var slug = hexEl.dataset.slug;
        var colorEl = document.getElementById('bg_color_' + slug);
        if (colorEl && hexEl) {
            colorEl.addEventListener('input', function() { hexEl.value = this.value; });
            hexEl.addEventListener('input', function() {
                if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) colorEl.value = this.value;
            });
        }
    });

    if (bgColorEl && bgColorTextEl) {
        bgColorEl.addEventListener('input', function() { bgColorTextEl.value = this.value; });
        bgColorTextEl.addEventListener('input', function() {
            if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) bgColorEl.value = this.value;
        });
    }
});
</script>
@endsection
