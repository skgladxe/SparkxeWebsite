<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('website.pages.about');
    }

    public function team(): View
    {
        return view('website.pages.team');
    }

    public function contact(): View
    {
        return view('website.pages.contact');
    }

    public function pricing(): View
    {
        return view('website.pages.pricing');
    }

    public function faq(): View
    {
        return view('website.pages.faq');
    }

    public function portfolio(): View
    {
        return view('website.pages.portfolio');
    }
}
