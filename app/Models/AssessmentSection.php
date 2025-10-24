<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentSection extends Model
{
    protected $fillable = [
        'assessment_id',
        'section_type',
        'score',
        'notes',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(AssessmentQuestion::class);
    }

    // Accessors
    public function getSectionTitleAttribute()
    {
        return match($this->section_type) {
            'demographic' => 'Demographic Information',
            'medical_history' => 'Medical History',
            'functional' => 'Functional Assessment',
            'cognitive' => 'Cognitive Assessment',
            'behavioral' => 'Behavioral Assessment',
            'nutritional' => 'Nutritional Assessment',
            'environmental' => 'Environmental Assessment',
            'risk' => 'Risk Assessment',
            default => ucfirst(str_replace('_', ' ', $this->section_type))
        };
    }
}
