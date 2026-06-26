<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:newsletter_subscribers,email'],
        ]);

        NewsletterSubscriber::create([
            'email' => $validated['email'],
            'subscribed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Thanks for subscribing! You will receive digital tips from Sparkxe.',
        ]);
    }
}
