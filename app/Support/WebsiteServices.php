<?php

namespace App\Support;

use App\Models\Service;

class WebsiteServices
{
    public static function all(): array
    {
        return Service::query()->active()->get()->map(fn (Service $service) => [
            'slug' => $service->slug,
            'title' => $service->title,
            'subtitle' => $service->subtitle,
            'icon' => $service->iconClass(),
        ])->all();
    }

    public static function find(string $slug): ?array
    {
        foreach (self::all() as $service) {
            if ($service['slug'] === $slug) {
                return $service;
            }
        }

        return null;
    }

    public static function footerServices(int $limit = 5): array
    {
        return array_slice(self::all(), 0, $limit);
    }

    public static function mobileMenuServices(int $limit = 8): array
    {
        return array_slice(self::all(), 0, $limit);
    }
}
