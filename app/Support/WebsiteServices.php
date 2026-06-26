<?php

namespace App\Support;

class WebsiteServices
{
    public static function all(): array
    {
        return config('website.services', []);
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

    public static function related(string $slug, int $limit = 3): array
    {
        $current = self::find($slug);

        if ($current === null) {
            return [];
        }

        $sameCategory = array_values(array_filter(
            self::all(),
            fn (array $service) => $service['slug'] !== $slug && $service['category'] === $current['category']
        ));

        $others = array_values(array_filter(
            self::all(),
            fn (array $service) => $service['slug'] !== $slug && $service['category'] !== $current['category']
        ));

        return array_slice(array_merge($sameCategory, $others), 0, $limit);
    }

    public static function megaMenuGroups(): array
    {
        $groups = config('website.service_mega_menu', []);
        $result = [];

        foreach ($groups as $label => $categories) {
            $services = array_values(array_filter(
                self::all(),
                fn (array $service) => in_array($service['category'], $categories, true)
            ));

            if ($services !== []) {
                $result[$label] = $services;
            }
        }

        return $result;
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
