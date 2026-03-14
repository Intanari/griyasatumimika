<?php

namespace App\Http\Controllers;

use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WebSettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $settings = [
            'h1_color' => WebSetting::get('h1_color', '#ffffff'),
            'h2_color' => WebSetting::get('h2_color', '#ffffff'),
            'h3_color' => WebSetting::get('h3_color', '#ffffff'),
            'h4_color' => WebSetting::get('h4_color', '#ffffff'),
            'h5_color' => WebSetting::get('h5_color', '#ffffff'),
            'h6_color' => WebSetting::get('h6_color', '#ffffff'),
            'p_color' => WebSetting::get('p_color', '#ffffff'),
            'p_colors' => WebSetting::getPColors(),
            'span_color' => WebSetting::get('span_color', '#ffffff'),
            'span_colors' => WebSetting::getSpanColors(),
            'div_color' => WebSetting::get('div_color', '#ffffff'),
            'div_colors' => WebSetting::getDivColors(),
            'a_color' => WebSetting::get('a_color', '#ffffff'),
            'a_colors' => WebSetting::getAColors(),
            'button_color' => WebSetting::get('button_color', '#2563eb'),
            'button_text_color' => WebSetting::get('button_text_color', '#ffffff'),
            'button_colors' => WebSetting::getButtonColors(),
            'custom_class_colors' => WebSetting::getCustomClassColors(),
            'background_type' => WebSetting::get('background_type', 'gambar'),
            'background_color' => WebSetting::get('background_color', '#0f172a'),
            'background_image' => WebSetting::get('background_image'),
            'background_image_mode' => WebSetting::get('background_image_mode', 'global'),
            'background_images' => WebSetting::getBackgroundImages(),
            'background_color_mode' => WebSetting::get('background_color_mode', 'global'),
            'background_colors' => WebSetting::getBackgroundColors(),
            'background_overlay_opacity' => WebSetting::get('background_overlay_opacity', '0.4'),
        ];
        $publicPageSlugs = $this->getPublicPageSlugs();

        return view('dashboard.web-settings.index', compact('settings', 'user', 'publicPageSlugs'));
    }

    public function saveColors(Request $request)
    {
        $request->validate([
            'h1_color' => 'nullable|string|max:50',
            'h2_color' => 'nullable|string|max:50',
            'h3_color' => 'nullable|string|max:50',
            'h4_color' => 'nullable|string|max:50',
            'h5_color' => 'nullable|string|max:50',
            'h6_color' => 'nullable|string|max:50',
        ]);

        foreach (['h1_color', 'h2_color', 'h3_color', 'h4_color', 'h5_color', 'h6_color'] as $key) {
            WebSetting::set($key, $request->input($key, ''));
        }

        return redirect()->route('dashboard.web-settings.index')
            ->with('success', 'Warna teks heading berhasil disimpan.');
    }

    public function savePColors(Request $request)
    {
        $request->validate([
            'p_color' => 'nullable|string|max:50',
            'p_colors' => 'nullable|array',
            'p_colors.*.class' => 'nullable|string|max:100',
            'p_colors.*.color' => 'nullable|string|max:50',
        ]);

        WebSetting::set('p_color', $request->input('p_color', ''));
        $items = collect($request->input('p_colors', []))
            ->filter(fn ($item) => !empty(trim($item['class'] ?? '')) && !empty(trim($item['color'] ?? '')))
            ->map(fn ($item) => [
                'class' => preg_replace('/[^a-zA-Z0-9_-]/', '', $item['class'] ?? ''),
                'color' => $item['color'] ?? '#ffffff',
            ])
            ->values()
            ->toArray();
        WebSetting::set('p_colors', $items);

        return redirect()->route('dashboard.web-settings.index')
            ->with('success', 'Warna paragraf berhasil disimpan.');
    }

    public function saveSpanColors(Request $request)
    {
        $request->validate([
            'span_color' => 'nullable|string|max:50',
            'span_colors' => 'nullable|array',
            'span_colors.*.class' => 'nullable|string|max:100',
            'span_colors.*.color' => 'nullable|string|max:50',
        ]);

        WebSetting::set('span_color', $request->input('span_color', ''));
        $items = collect($request->input('span_colors', []))
            ->filter(fn ($item) => !empty(trim($item['class'] ?? '')) && !empty(trim($item['color'] ?? '')))
            ->map(fn ($item) => [
                'class' => preg_replace('/[^a-zA-Z0-9_-]/', '', $item['class'] ?? ''),
                'color' => $item['color'] ?? '#ffffff',
            ])
            ->values()
            ->toArray();

        WebSetting::set('span_colors', $items);

        return redirect()->route('dashboard.web-settings.index')
            ->with('success', 'Warna span berhasil disimpan.');
    }

    public function saveDivColors(Request $request)
    {
        $request->validate([
            'div_color' => 'nullable|string|max:50',
            'div_colors' => 'nullable|array',
            'div_colors.*.class' => 'nullable|string|max:100',
            'div_colors.*.color' => 'nullable|string|max:50',
        ]);

        WebSetting::set('div_color', $request->input('div_color', ''));
        $items = collect($request->input('div_colors', []))
            ->filter(fn ($item) => !empty(trim($item['class'] ?? '')) && !empty(trim($item['color'] ?? '')))
            ->map(fn ($item) => [
                'class' => preg_replace('/[^a-zA-Z0-9_-]/', '', $item['class'] ?? ''),
                'color' => $item['color'] ?? '#ffffff',
            ])
            ->values()
            ->toArray();

        WebSetting::set('div_colors', $items);

        return redirect()->route('dashboard.web-settings.index')
            ->with('success', 'Warna div berhasil disimpan.');
    }

    public function saveLinkColors(Request $request)
    {
        $request->validate([
            'a_color' => 'nullable|string|max:50',
            'a_colors' => 'nullable|array',
            'a_colors.*.class' => 'nullable|string|max:100',
            'a_colors.*.color' => 'nullable|string|max:50',
        ]);

        WebSetting::set('a_color', $request->input('a_color', ''));
        $items = collect($request->input('a_colors', []))
            ->filter(fn ($item) => !empty(trim($item['class'] ?? '')) && !empty(trim($item['color'] ?? '')))
            ->map(fn ($item) => [
                'class' => preg_replace('/[^a-zA-Z0-9_-]/', '', $item['class'] ?? ''),
                'color' => $item['color'] ?? '#ffffff',
            ])
            ->values()
            ->toArray();
        WebSetting::set('a_colors', $items);

        return redirect()->route('dashboard.web-settings.index')
            ->with('success', 'Warna link berhasil disimpan.');
    }

    public function saveButtonColors(Request $request)
    {
        $request->validate([
            'button_color' => 'nullable|string|max:50',
            'button_text_color' => 'nullable|string|max:50',
            'button_colors' => 'nullable|array',
            'button_colors.*.class' => 'nullable|string|max:100',
            'button_colors.*.color' => 'nullable|string|max:50',
            'button_colors.*.text_color' => 'nullable|string|max:50',
        ]);

        WebSetting::set('button_color', $request->input('button_color', '#2563eb'));
        WebSetting::set('button_text_color', $request->input('button_text_color', '#ffffff'));
        $items = collect($request->input('button_colors', []))
            ->filter(fn ($item) => !empty(trim($item['class'] ?? '')) && !empty(trim($item['color'] ?? '')))
            ->map(fn ($item) => [
                'class' => preg_replace('/[^a-zA-Z0-9_-]/', '', $item['class'] ?? ''),
                'color' => $item['color'] ?? '#2563eb',
                'text_color' => $item['text_color'] ?? '#ffffff',
            ])
            ->values()
            ->toArray();
        WebSetting::set('button_colors', $items);

        return redirect()->route('dashboard.web-settings.index')
            ->with('success', 'Warna tombol berhasil disimpan.');
    }

    public function saveCustomClassColors(Request $request)
    {
        $request->validate([
            'custom_class_colors' => 'nullable|array',
            'custom_class_colors.*.class' => 'nullable|string|max:100',
            'custom_class_colors.*.color' => 'nullable|string|max:50',
        ]);

        $items = collect($request->input('custom_class_colors', []))
            ->filter(fn ($item) => !empty(trim($item['class'] ?? '')) && !empty(trim($item['color'] ?? '')))
            ->map(fn ($item) => [
                'class' => preg_replace('/[^a-zA-Z0-9_-]/', '', $item['class'] ?? ''),
                'color' => $item['color'] ?? '#ffffff',
            ])
            ->values()
            ->toArray();
        WebSetting::set('custom_class_colors', $items);

        return redirect()->route('dashboard.web-settings.index')
            ->with('success', 'Warna khusus class berhasil disimpan.');
    }

    public function saveBackground(Request $request)
    {
        $imgMode = $request->input('background_image_mode', 'global');
        $colorMode = $request->input('background_color_mode', 'global');
        $rules = [
            'background_type' => 'nullable|in:warna,gambar',
            'background_color' => 'nullable|string|max:50',
            'background_color_mode' => 'nullable|in:global,per_page',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'background_image_mode' => 'nullable|in:global,per_page',
            'background_overlay_opacity' => 'nullable|numeric|min:0|max:1',
        ];
        $perPageKeys = array_keys($this->getPublicPageSlugs());
        foreach ($perPageKeys as $key) {
            $rules["background_image_{$key}"] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
            $rules["background_color_{$key}"] = 'nullable|string|max:50';
        }
        $request->validate($rules);

        WebSetting::set('background_type', $request->input('background_type', 'gambar'));
        WebSetting::set('background_color', $request->input('background_color', '#0f172a'));
        WebSetting::set('background_image_mode', $imgMode);
        WebSetting::set('background_color_mode', $colorMode);

        if ($colorMode === 'per_page') {
            $colors = WebSetting::getBackgroundColors();
            foreach ($perPageKeys as $slug) {
                $val = $request->input("background_color_{$slug}");
                if (!empty($val)) {
                    $colors[$slug] = $val;
                }
            }
            WebSetting::set('background_colors', $colors);
        }

        if ($imgMode === 'global' && $request->hasFile('background_image')) {
            $oldPath = WebSetting::get('background_image');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('background_image')->store('web-settings', 'public');
            WebSetting::set('background_image', $path);
        }

        if ($imgMode === 'per_page') {
            $images = WebSetting::getBackgroundImages();
            foreach ($perPageKeys as $slug) {
                $key = "background_image_{$slug}";
                if ($request->hasFile($key)) {
                    $oldPath = $images[$slug] ?? null;
                    if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                    $path = $request->file($key)->store('web-settings', 'public');
                    $images[$slug] = $path;
                }
            }
            WebSetting::set('background_images', $images);
        }

        $opacity = $request->input('background_overlay_opacity', 0.4);
        WebSetting::set('background_overlay_opacity', $opacity);

        return redirect()->route('dashboard.web-settings.index')
            ->with('success', 'Background halaman web berhasil disimpan.');
    }

    protected function getPublicPageSlugs(): array
    {
        return [
            'home' => 'Beranda',
            'donasi' => 'Donasi - Form',
            'donasi-bayar' => 'Donasi - Pembayaran',
            'donasi-sukses' => 'Donasi - Sukses',
            'laporan-odgj' => 'Laporan ODGJ - Form',
            'laporan-odgj-sukses' => 'Laporan ODGJ - Sukses',
            'profil-struktur' => 'Profil - Struktur Organisasi',
            'profil-visi-misi' => 'Profil - Visi Misi',
            'profil-yayasan' => 'Profil - Yayasan',
            'galeri' => 'Galeri',
            'kontak' => 'Kontak',
            'layanan' => 'Layanan',
            'transparansi-donasi' => 'Transparansi Donasi',
            'pasien' => 'Halaman Pasien',
        ];
    }
}
