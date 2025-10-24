<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Resident;
use App\Models\User;
use App\Models\Branch;

class FinancialSummaryWidget extends Widget
{
    protected static string $view = 'filament.widgets.financial-summary-widget';
    
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        // Mock financial data - in a real app, this would come from financial records
        return [
            'monthly_revenue' => 125000,
            'monthly_expenses' => 85000,
            'net_profit' => 40000,
            'resident_fees' => 95000,
            'staff_costs' => 45000,
            'facility_costs' => 25000,
            'other_expenses' => 15000,
        ];
    }
}
