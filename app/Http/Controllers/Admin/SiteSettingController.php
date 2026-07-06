<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        return view('webadmin.settings.edit', [
            'logoUrl' => SiteSetting::logoUrl(),
            'settings' => $this->currentSettings(),
            'themes' => config('website.themes'),
            'defaultHeaderImageUrl' => SiteSetting::defaultPageHeaderImageUrl(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'logo' => ['nullable', 'image', 'max:5120'],
            'default_page_header_image' => ['nullable', 'image', 'max:5120'],
            'theme_mode' => ['required', 'in:preset,custom'],
            'theme_preset' => ['required_if:theme_mode,preset', 'string', 'in:'.implode(',', array_keys(config('website.themes')))],
            'theme_accent_color' => ['required_if:theme_mode,custom', 'nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_accent_secondary_color' => ['required_if:theme_mode,custom', 'nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_black_color' => ['required_if:theme_mode,custom', 'nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_primary_color' => ['required_if:theme_mode,custom', 'nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'services_section_eyebrow' => ['nullable', 'string', 'max:255'],
            'services_section_title' => ['nullable', 'string', 'max:500'],
            'services_section_title_highlight' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('logo')) {
            SiteSetting::set('logo', $request->file('logo')->store('settings', 'public'));
        }

        if ($request->hasFile('default_page_header_image')) {
            SiteSetting::set('default_page_header_image', $request->file('default_page_header_image')->store('settings', 'public'));
        }

        SiteSetting::set('theme_mode', $request->input('theme_mode', 'preset'));
        SiteSetting::set('theme_preset', $request->input('theme_preset', config('website.default_theme')));
        SiteSetting::set('theme_accent_color', $request->input('theme_accent_color', '#F0FF6C'));
        SiteSetting::set('theme_accent_secondary_color', $request->input('theme_accent_secondary_color', '#6BFDD9'));
        SiteSetting::set('theme_black_color', $request->input('theme_black_color', '#163031'));
        SiteSetting::set('theme_primary_color', $request->input('theme_primary_color', '#F8F8F8'));
        SiteSetting::set('section_hero_visible', $request->boolean('section_hero_visible') ? '1' : '0');
        SiteSetting::set('section_products_visible', $request->boolean('section_products_visible') ? '1' : '0');
        SiteSetting::set('hide_theme_picker', $request->boolean('hide_theme_picker') ? '1' : '0');
        SiteSetting::set('services_section_eyebrow', $request->input('services_section_eyebrow', 'Our Services'));
        SiteSetting::set('services_section_title', $request->input('services_section_title', 'Everything your business needs to win online'));
        SiteSetting::set('services_section_title_highlight', $request->input('services_section_title_highlight', 'win online'));

        return redirect()->route('admin.settings.edit')->with('success', 'Settings updated.');
    }

    private function currentSettings(): array
    {
        return [
            'theme_mode' => SiteSetting::get('theme_mode', 'preset'),
            'theme_preset' => SiteSetting::get('theme_preset', config('website.default_theme')),
            'theme_accent_color' => SiteSetting::get('theme_accent_color', '#F0FF6C'),
            'theme_accent_secondary_color' => SiteSetting::get('theme_accent_secondary_color', '#6BFDD9'),
            'theme_black_color' => SiteSetting::get('theme_black_color', '#163031'),
            'theme_primary_color' => SiteSetting::get('theme_primary_color', '#F8F8F8'),
            'section_hero_visible' => SiteSetting::get('section_hero_visible', '1') === '1',
            'section_products_visible' => SiteSetting::get('section_products_visible', '1') === '1',
            'hide_theme_picker' => SiteSetting::get('hide_theme_picker', '0') === '1',
            'services_section_eyebrow' => SiteSetting::get('services_section_eyebrow', 'Our Services'),
            'services_section_title' => SiteSetting::get('services_section_title', 'Everything your business needs to win online'),
            'services_section_title_highlight' => SiteSetting::get('services_section_title_highlight', 'win online'),
        ];
    }
}
