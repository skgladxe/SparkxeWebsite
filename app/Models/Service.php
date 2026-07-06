<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'description',
        'notes',
        'image',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    protected static function booted(): void
    {
        static::saving(function (Service $service) {
            if (blank($service->slug) && filled($service->title)) {
                $service->slug = Str::slug($service->title);
            }

            if (filled($service->icon)) {
                $service->icon = static::normalizeIcon($service->icon);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function imageUrl(): ?string
    {
        return static::storageUrl($this->image);
    }

    public function iconClass(): ?string
    {
        return $this->icon;
    }

    public function renderedNotes(): ?string
    {
        if (blank($this->notes)) {
            return null;
        }

        return preg_replace(
            [
                '/\sstyle=("|\')(.*?)\1/i',
                '/\scontenteditable=("|\')(.*?)\1/i',
                '/\sspellcheck=("|\')(.*?)\1/i',
                '/\sid=("|\')(.*?)\1/i',
                '/\sdata-[a-z0-9\-_]+=("|\\\')(.*?)\1/i',
            ],
            '',
            $this->notes
        );
    }

    public static function normalizeIcon(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $value = trim($value);

        if (preg_match('/class=["\']([^"\']+)["\']/', $value, $matches)) {
            return $matches[1];
        }

        return $value;
    }

    private static function storageUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset('storage/'.$path);
    }
}
