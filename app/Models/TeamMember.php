<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'name', 'role', 'photo', 'linkedin', 'twitter', 'github', 'dribbble', 'instagram', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function photoUrl(): ?string
    {
        return filled($this->photo) ? asset('storage/'.$this->photo) : null;
    }

    public function initial(): string
    {
        return strtoupper(substr($this->name, 0, 1));
    }
}
