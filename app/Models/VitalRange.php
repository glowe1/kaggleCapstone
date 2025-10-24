<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VitalRange extends Model
{
    use HasFactory;

    protected $fillable = [
        'parameter',
        'min_normal',
        'max_normal',
        'min_warning',
        'max_warning',
        'min_critical',
        'max_critical',
        'unit',
        'description',
        'is_active',
    ];

    protected $casts = [
        'min_normal' => 'decimal:2',
        'max_normal' => 'decimal:2',
        'min_warning' => 'decimal:2',
        'max_warning' => 'decimal:2',
        'min_critical' => 'decimal:2',
        'max_critical' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeParameter($query, $parameter)
    {
        return $query->where('parameter', $parameter);
    }

    // Helper methods
    public function getNormalRangeAttribute()
    {
        return $this->min_normal . ' - ' . $this->max_normal . ' ' . $this->unit;
    }

    public function getWarningRangeAttribute()
    {
        if ($this->min_warning && $this->max_warning) {
            return $this->min_warning . ' - ' . $this->max_warning . ' ' . $this->unit;
        }
        return null;
    }

    public function getCriticalRangeAttribute()
    {
        if ($this->min_critical && $this->max_critical) {
            return $this->min_critical . ' - ' . $this->max_critical . ' ' . $this->unit;
        }
        return null;
    }

    // Static method to get range for a parameter
    public static function getRangeForParameter($parameter)
    {
        return static::active()->parameter($parameter)->first();
    }
}
