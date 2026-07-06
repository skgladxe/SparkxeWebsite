<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'subtitle',
        'title',
        'title_highlight',
        'description',
        'primary_button_text',
        'primary_button_url',
        'secondary_button_text',
        'secondary_button_url',
        'main_image',
        'left_image',
        'right_image',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function mainImageUrl(): string
    {
        return $this->imageUrl($this->main_image, 'website/assets/images/hero-main.jpg');
    }

    public function leftImageUrl(): ?string
    {
        return $this->imageUrl($this->left_image);
    }

    public function rightImageUrl(): ?string
    {
        return $this->imageUrl($this->right_image);
    }

    public function renderedTitle(): string
    {
        if (filled($this->title_highlight)) {
            return str_replace($this->title_highlight, '<span>'.$this->title_highlight.'</span>', $this->title);
        }

        return $this->title;
    }

    public function buttonUrl(string $url): string
    {
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, '#')) {
            return $url;
        }

        return url($url);
    }

    private function imageUrl(?string $path, ?string $fallback = null): ?string
    {
        if (filled($path)) {
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }

            return asset('storage/'.$path);
        }

        return $fallback ? asset($fallback) : null;
    }
}
