<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('website.pages.services.index', [
            'services' => Service::query()->active()->get(),
            'section' => \App\Models\SiteSetting::servicesSection(),
        ]);
    }

    public function show(string $slug): View
    {
        $service = Service::query()->active()->where('slug', $slug)->firstOrFail();

        return view('website.pages.services.show', [
            'service' => $service,
        ]);
    }
}
