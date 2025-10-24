<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\VitalSign;

class RecentVitalsWidget extends Widget
{
    protected static string $view = 'filament.widgets.recent-vitals-widget';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 1;

    public function getRecentVitals(): array
    {
        $userId = auth()->id();
        
        $vitals = VitalSign::whereHas('resident.assignments', function($q) use ($userId) {
            $q->where('caregiver_id', $userId)->where('is_active', true);
        })->with('resident')
        ->orderBy('measurement_date', 'desc')
        ->limit(10)
        ->get();

        return $vitals->map(function($vital) {
            return [
                'id' => $vital->id,
                'resident' => $vital->resident->name,
                'recorded_at' => $vital->measurement_date,
                'blood_pressure' => $vital->systolic . '/' . $vital->diastolic,
                'heart_rate' => $vital->pulse,
                'temperature' => $vital->temperature,
                'oxygen_saturation' => $vital->oxygen_saturation,
                'status' => $this->getVitalStatus($vital),
            ];
        })->toArray();
    }

    private function getVitalStatus($vital): string
    {
        if ($vital->systolic > 140 || 
            $vital->diastolic > 90 ||
            $vital->pulse > 100) {
            return 'high';
        } elseif ($vital->systolic < 90 || 
                 $vital->diastolic < 60 ||
                 $vital->pulse < 50) {
            return 'low';
        }
        
        return 'normal';
    }
}