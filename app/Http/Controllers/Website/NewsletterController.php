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
            'mobile_number' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255', 'unique:newsletter_subscribers,email'],
        ]);

        if (blank($validated['mobile_number'] ?? null) && blank($validated['email'] ?? null)) {
            return response()->json([
                'message' => 'Enter a mobile number or email address.',
                'errors' => [
                    'mobile_number' => ['Enter a mobile number or email address.'],
                ],
            ], 422);
        }

        NewsletterSubscriber::create([
            'mobile_number' => $validated['mobile_number'] ?? null,
            'email' => $validated['email'] ?? null,
            'subscribed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Thanks for subscribing! You will receive digital tips from Sparkxe.',
        ]);
    }
}
