<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SleepHourlyData extends Model
{
    use HasFactory;

    protected $fillable = [
        'sleep_pattern_id',
        'hour_00', 'hour_01', 'hour_02', 'hour_03', 'hour_04', 'hour_05',
        'hour_06', 'hour_07', 'hour_08', 'hour_09', 'hour_10', 'hour_11',
        'hour_12', 'hour_13', 'hour_14', 'hour_15', 'hour_16', 'hour_17',
        'hour_18', 'hour_19', 'hour_20', 'hour_21', 'hour_22', 'hour_23',
    ];

    protected $casts = [
        'hour_00' => 'decimal:2', 'hour_01' => 'decimal:2', 'hour_02' => 'decimal:2', 'hour_03' => 'decimal:2',
        'hour_04' => 'decimal:2', 'hour_05' => 'decimal:2', 'hour_06' => 'decimal:2', 'hour_07' => 'decimal:2',
        'hour_08' => 'decimal:2', 'hour_09' => 'decimal:2', 'hour_10' => 'decimal:2', 'hour_11' => 'decimal:2',
        'hour_12' => 'decimal:2', 'hour_13' => 'decimal:2', 'hour_14' => 'decimal:2', 'hour_15' => 'decimal:2',
        'hour_16' => 'decimal:2', 'hour_17' => 'decimal:2', 'hour_18' => 'decimal:2', 'hour_19' => 'decimal:2',
        'hour_20' => 'decimal:2', 'hour_21' => 'decimal:2', 'hour_22' => 'decimal:2', 'hour_23' => 'decimal:2',
    ];

    // Relationships
    public function sleepPattern()
    {
        return $this->belongsTo(SleepPattern::class);
    }

    // Helper methods
    public function getHourValue($hour)
    {
        $attribute = 'hour_' . str_pad($hour, 2, '0', STR_PAD_LEFT);
        return $this->$attribute ?? 0;
    }

    public function getHourlyDataArray()
    {
        $data = [];
        for ($i = 0; $i < 24; $i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $data[$hour] = $this->{"hour_$hour"} ?? 0;
        }
        return $data;
    }

    public function getTotalSleepHours()
    {
        $total = 0;
        for ($i = 0; $i < 24; $i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $total += $this->{"hour_$hour"} ?? 0;
        }
        return $total;
    }
}
