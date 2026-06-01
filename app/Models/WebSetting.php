<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class WebSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => is_array($value) || is_object($value) ? json_encode($value) : (string) $value]);
    }

    public static function getPColors(): array
    {
        $raw = static::get('p_colors', '[]');
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    public static function getSpanColors(): array
    {
        $raw = static::get('span_colors', '[]');
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    public static function getAColors(): array
    {
        $raw = static::get('a_colors', '[]');
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    public static function getButtonColors(): array
    {
        $raw = static::get('button_colors', '[]');
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    public static function getDivColors(): array
    {
        $raw = static::get('div_colors', '[]');
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    public static function getCustomClassColors(): array
    {
        $raw = static::get('custom_class_colors', '[]');
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    public static function getBackgroundImages(): array
    {
        $raw = static::get('background_images', '[]');
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    /** @return array<string, string> */
    public static function publicPageSlugs(): array
    {
        return config('public-pages.slugs', []);
    }

    /** @return array<string, string> */
    public static function routeToPageSlug(): array
    {
        return config('public-pages.routes', []);
    }

    /** @return list<string> Path relatif disk public, mis. web-settings/foo.png */
    public static function listStorageBackgroundImages(): array
    {
        if (! Storage::disk('public')->exists('web-settings')) {
            return [];
        }

        $paths = [];
        foreach (Storage::disk('public')->files('web-settings') as $path) {
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
                $paths[] = $path;
            }
        }

        sort($paths);

        return $paths;
    }

    /**
     * Gambar per halaman: dari DB, atau otomatis dari folder web-settings bila belum di-set.
     *
     * @return array<string, string>
     */
    public static function getResolvedBackgroundImages(): array
    {
        $saved = static::getBackgroundImages();
        $slugs = array_keys(static::publicPageSlugs());
        $images = static::listStorageBackgroundImages();

        if ($images === []) {
            return $saved;
        }

        $resolved = $saved;
        foreach ($slugs as $i => $slug) {
            if (empty($resolved[$slug])) {
                $resolved[$slug] = $images[$i % count($images)];
            }
        }

        return $resolved;
    }

    /**
     * Simpan pemetaan 1 gambar per halaman dari folder storage/app/public/web-settings.
     *
     * @return array<string, string>
     */
    public static function syncPerPageBackgroundsFromStorage(bool $overwrite = false): array
    {
        $slugs = array_keys(static::publicPageSlugs());
        $images = static::listStorageBackgroundImages();
        $existing = static::getBackgroundImages();
        $mapped = [];

        foreach ($slugs as $i => $slug) {
            if (! $overwrite && ! empty($existing[$slug])) {
                $mapped[$slug] = $existing[$slug];
            } elseif ($images !== []) {
                $mapped[$slug] = $images[$i % count($images)];
            }
        }

        static::set('background_images', $mapped);
        static::set('background_image_mode', 'per_page');
        static::set('background_type', 'gambar');

        return $mapped;
    }

    public static function resolveBackgroundImageForSlug(?string $slug): ?string
    {
        if ($slug === null || $slug === '') {
            return null;
        }

        $images = static::getResolvedBackgroundImages();

        return $images[$slug] ?? null;
    }

    public static function getBackgroundColors(): array
    {
        $raw = static::get('background_colors', '[]');
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    public static function getAllForPublic(): array
    {
        $keys = [
            'h1_color', 'h2_color', 'h3_color', 'h4_color', 'h5_color', 'h6_color',
            'p_color', 'p_colors', 'span_color', 'span_colors',
            'div_color', 'div_colors', 'a_color', 'a_colors',
            'button_color', 'button_text_color', 'button_colors',
            'custom_class_colors',
            'background_type', 'background_color', 'background_color_mode', 'background_colors', 'background_image', 'background_image_mode', 'background_images', 'background_overlay_opacity',
        ];
        $rows = static::whereIn('key', $keys)->get()->keyBy('key');
        $result = [];
        foreach ($keys as $k) {
            $result[$k] = match ($k) {
                'p_colors' => static::getPColors(),
                'span_colors' => static::getSpanColors(),
                'div_colors' => static::getDivColors(),
                'custom_class_colors' => static::getCustomClassColors(),
                'a_colors' => static::getAColors(),
                'button_colors' => static::getButtonColors(),
                'background_images' => (static::get('background_image_mode', 'global') === 'per_page')
                    ? static::getResolvedBackgroundImages()
                    : static::getBackgroundImages(),
                'background_colors' => static::getBackgroundColors(),
                default => $rows->get($k)?->value,
            };
        }
        return $result;
    }
}
