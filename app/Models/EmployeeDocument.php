<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_name',
        'document_type',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'expiration_date',
        'is_expired',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'is_expired' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getIsExpiredAttribute(): bool
    {
        if (!$this->expiration_date) {
            return false;
        }
        
        return $this->expiration_date->isPast();
    }

    public function getDaysUntilExpirationAttribute(): ?int
    {
        if (!$this->expiration_date) {
            return null;
        }
        
        return now()->diffInDays($this->expiration_date, false);
    }
}
