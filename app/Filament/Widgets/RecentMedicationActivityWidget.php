<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\MedicationAdministration;
use Illuminate\Database\Eloquent\Builder;

class RecentMedicationActivityWidget extends Widget
{
    protected static string $view = 'filament.widgets.recent-medication-activity-widget';
    
    protected int | string | array $columnSpan = 'full';

    public ?int $selectedResident = null;

    public function getViewData(): array
    {
        $recentAdministrations = MedicationAdministration::with(['medication', 'resident', 'administeredBy'])
            ->when($this->selectedResident, function (Builder $query) {
                $query->where('resident_id', $this->selectedResident);
            })
            ->when(auth()->user()->hasRole('caregiver'), function (Builder $query) {
                $query->whereHas('resident', function ($q) {
                    $q->where('branch_id', auth()->user()->assigned_branch_id);
                });
            })
            ->orderBy('administered_at', 'desc')
            ->limit(5)
            ->get();

        return [
            'recentAdministrations' => $recentAdministrations,
        ];
    }

    public function setSelectedResident(?int $residentId): void
    {
        $this->selectedResident = $residentId;
    }
}
