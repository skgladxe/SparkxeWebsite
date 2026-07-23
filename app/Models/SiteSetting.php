<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, ?string $default = null): ?string
    {
        return Cache::rememberForever('site_setting_'.$key, function () use ($key, $default) {
            return static::query()->where('key', $key)->value('value') ?? $default;
        });
    }

    public static function set(string $key, ?string $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site_setting_'.$key);
    }

    public static function assetUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset('storage/'.$path);
    }

    public static function logoUrl(): string
    {
        return static::websiteNavLogoUrl();
    }

    public static function websiteNavLogoUrl(): string
    {
        return static::assetUrl(static::get('website_nav_logo'))
            ?? static::assetUrl(static::get('logo'))
            ?? asset('website/assets/images/logo.svg');
    }

    public static function websiteFooterLogoUrl(): string
    {
        return static::assetUrl(static::get('website_footer_logo'))
            ?? static::websiteNavLogoUrl();
    }

    public static function websiteFaviconUrl(): string
    {
        return static::assetUrl(static::get('website_favicon'))
            ?? asset('website/assets/images/logo.svg');
    }

    public static function adminLogoUrl(): string
    {
        return static::assetUrl(static::get('admin_logo'))
            ?? asset(config('webadmin.images.logo'));
    }

    public static function adminFaviconUrl(): string
    {
        return static::assetUrl(static::get('admin_favicon'))
            ?? asset(config('webadmin.images.favicon'));
    }

    public static function adminLogoText(): string
    {
        return static::get('admin_logo_text') ?? config('webadmin.name');
    }

    public static function adminLogoTextImageUrl(): ?string
    {
        return static::assetUrl(static::get('admin_logo_text_image'));
    }

    public static function websiteSettings(): array
    {
        $themeMode = static::get('theme_mode', 'preset');
        $themePreset = static::get('theme_preset', config('website.default_theme'));

        return [
            'themeMode' => $themeMode,
            'themePreset' => $themePreset,
            'bodyTheme' => $themeMode === 'custom' ? 'custom' : $themePreset,
            'heroVisible' => static::get('section_hero_visible', '1') === '1',
            'productsVisible' => static::get('section_products_visible', '1') === '1',
            'hideThemePicker' => static::get('hide_theme_picker', '0') === '1',
            'themeAccentColor' => static::get('theme_accent_color', '#F0FF6C'),
            'themeAccentSecondaryColor' => static::get('theme_accent_secondary_color', '#6BFDD9'),
            'themeBlackColor' => static::get('theme_black_color', '#163031'),
            'themePrimaryColor' => static::get('theme_primary_color', '#F8F8F8'),
        ];
    }

    public static function defaultPageHeaderImageUrl(): ?string
    {
        $path = static::get('default_page_header_image');

        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset('storage/'.$path);
    }

    public static function servicesSection(): array
    {
        return [
            'eyebrow' => static::get('services_section_eyebrow', 'Our Services'),
            'title' => static::get('services_section_title', 'Everything your business needs to win online'),
            'highlight' => static::get('services_section_title_highlight', 'win online'),
        ];
    }
}
