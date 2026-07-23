<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\View\View;

class NewsletterSubscriberController extends Controller
{
    public function index(): View
    {
        return view('webadmin.newsletter-subscribers.index', [
            'subscribers' => NewsletterSubscriber::query()->latest('subscribed_at')->paginate(15),
        ]);
    }
}
