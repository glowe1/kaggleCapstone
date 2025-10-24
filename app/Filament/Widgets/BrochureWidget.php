<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class BrochureWidget extends Widget
{
    protected static string $view = 'filament.widgets.brochure';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 2;
    
    public function getViewData(): array
    {
        return [
            'facilities' => \App\Models\Facility::where('is_active', true)->get(),
        ];
    }
}



