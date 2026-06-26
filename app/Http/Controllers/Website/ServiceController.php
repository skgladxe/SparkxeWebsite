<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Support\WebsiteServices;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('website.pages.services.index', [
            'services' => WebsiteServices::all(),
        ]);
    }

    public function show(string $slug): View
    {
        $service = WebsiteServices::find($slug);

        if ($service === null) {
            abort(404);
        }

        return view('website.pages.services.show', [
            'service' => $service,
            'relatedServices' => WebsiteServices::related($slug),
        ]);
    }
}
