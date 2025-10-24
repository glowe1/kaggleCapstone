<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class ChartReports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';
    protected static string $view = 'filament.pages.chart-reports';
    protected static ?string $title = 'Chart Reports';
    protected static ?string $navigationLabel = 'Chart Reports';
    protected static ?string $navigationGroup = 'Reports';
    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return Auth::check() && (Auth::user()->hasRole('administrator') || Auth::user()->hasRole('super_admin'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::check() && (Auth::user()->hasRole('administrator') || Auth::user()->hasRole('super_admin'));
    }
}
