<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    protected $table = 'seo_meta';

    protected $fillable = [
        'route_key',
        'url_slug',
        'page_label',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'focus_keyword',
        'h1_heading',
        'og_title',
        'og_description',
        'og_image',
        'canonical_url',
        'robots_index',
        'robots_follow',
        'schema_type',
        'schema_json',
        'sitemap_priority',
    ];

    protected function casts(): array
    {
        return [
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
            'sitemap_priority' => 'decimal:1',
        ];
    }

    public function scopeForRouteKey($query, string $routeKey)
    {
        return $query->where('route_key', $routeKey);
    }

    public function scopeForUrlSlug($query, string $urlSlug)
    {
        return $query->where('url_slug', $urlSlug);
    }

    public function getRobotsContentAttribute(): string
    {
        $index = $this->robots_index ? 'index' : 'noindex';
        $follow = $this->robots_follow ? 'follow' : 'nofollow';

        return "{$index},{$follow}";
    }

    public function getOgImageUrlAttribute(): ?string
    {
        if (blank($this->og_image)) {
            return null;
        }

        if (str_starts_with($this->og_image, 'http://') || str_starts_with($this->og_image, 'https://')) {
            return $this->og_image;
        }

        return asset('storage/'.$this->og_image);
    }
}
