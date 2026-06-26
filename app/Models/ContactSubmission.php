<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    public const STATUSES = ['pending', 'followup', 'completed', 'hold'];

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'service', 'message', 'status', 'admin_notes',
    ];

    public function fullName(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }
}
