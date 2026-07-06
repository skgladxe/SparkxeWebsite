<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'name',
        'role',
        'description',
        'notes',
        'photo',
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

    public function photoUrl(): ?string
    {
        return filled($this->photo) ? asset('storage/'.$this->photo) : null;
    }

    public function initial(): string
    {
        return strtoupper(substr($this->name, 0, 1));
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
}
