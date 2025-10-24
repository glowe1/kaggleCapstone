<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentQuestion extends Model
{
    protected $fillable = [
        'assessment_section_id',
        'question_text',
        'response_type',
        'response_options',
        'response_value',
        'notes',
        'weight',
    ];

    protected $casts = [
        'response_options' => 'array',
    ];

    // Relationships
    public function section(): BelongsTo
    {
        return $this->belongsTo(AssessmentSection::class);
    }
}
