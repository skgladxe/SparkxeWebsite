<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'slug',
        'image',
        'title',
        'subtitle',
        'description',
        'notes',
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
        static::saving(function (Product $product) {
            if (blank($product->slug) && filled($product->title)) {
                $product->slug = Str::slug($product->title);
            }

            if (filled($product->icon)) {
                $product->icon = Service::normalizeIcon($product->icon);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function imageUrl(): ?string
    {
        return $this->storageUrl($this->image);
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

    private function storageUrl(?string $path): ?string
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
