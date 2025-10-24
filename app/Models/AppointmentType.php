<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'color_code',
        'default_duration',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'default_duration' => 'integer',
    ];

    // Relationships
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Static methods for dropdown options
    public static function getOptions()
    {
        return self::active()->pluck('name', 'id')->toArray();
    }
}
