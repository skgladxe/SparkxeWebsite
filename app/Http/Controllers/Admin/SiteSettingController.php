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
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'logo' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('logo')) {
            SiteSetting::set('logo', $request->file('logo')->store('settings', 'public'));
        }

        return redirect()->route('admin.settings.edit')->with('success', 'Settings updated.');
    }
}
