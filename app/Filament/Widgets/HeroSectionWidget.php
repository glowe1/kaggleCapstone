<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class HeroSectionWidget extends Widget
{
    protected static string $view = 'filament.widgets.hero-section';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 1;
}



