<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    protected $fillable = [
        'blog_category_id', 'title', 'slug', 'excerpt', 'content',
        'featured_image', 'read_time', 'published_at', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function imageUrl(): string
    {
        if (blank($this->featured_image)) {
            return asset('website/assets/images/logo.svg');
        }

        return asset('storage/'.$this->featured_image);
    }

    public function seoRouteKey(?string $slug = null): string
    {
        return 'blog:'.($slug ?? $this->slug);
    }

    public function seoUrlSlug(?string $slug = null): string
    {
        return '/blog/'.($slug ?? $this->slug);
    }

    public function seoMeta(?string $slug = null): ?SeoMeta
    {
        $slug ??= $this->slug;

        return SeoMeta::query()->forRouteKey($this->seoRouteKey($slug))->first()
            ?? SeoMeta::query()->forUrlSlug($this->seoUrlSlug($slug))->first();
    }
}
