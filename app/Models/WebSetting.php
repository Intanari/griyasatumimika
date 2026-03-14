<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
                'background_images' => static::getBackgroundImages(),
                'background_colors' => static::getBackgroundColors(),
                default => $rows->get($k)?->value,
            };
        }
        return $result;
    }
}
