<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\MedicationAdministration;
use Carbon\Carbon;

class MedicationComplianceWidget extends Widget
{
    protected static string $view = 'filament.widgets.medication-compliance-widget';
    
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $totalScheduled = MedicationAdministration::where('administered_at', '>=', Carbon::now()->subDays(30))->count();
        $completed = MedicationAdministration::where('status', 'completed')
            ->where('administered_at', '>=', Carbon::now()->subDays(30))
            ->count();
        $missed = MedicationAdministration::where('status', 'missed')
            ->where('administered_at', '>=', Carbon::now()->subDays(30))
            ->count();

        $complianceRate = $totalScheduled > 0 ? round(($completed / $totalScheduled) * 100, 1) : 0;

        return [
            'compliance_rate' => $complianceRate,
            'total_scheduled' => $totalScheduled,
            'completed' => $completed,
            'missed' => $missed,
        ];
    }
}
