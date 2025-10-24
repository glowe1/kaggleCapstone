<?php

namespace App\Filament\PanelProviders;

use Filament\Panel;
use Filament\PanelProvider;
use App\Filament\Navigation\CustomNavigationProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('/admin')
            ->login()
            ->colors([
                'primary' => '#3B82F6',
                'gray' => '#6B7280',
            ])
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources',
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages',
            )
            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets',
            )
            ->navigationGroups([
                'Dashboard',
                'Resident Care', 
                'Staff Management',
                'System Administration',
            ])
            ->navigationBuilder(CustomNavigationProvider::class)
            ->topNavigation()
            ->sidebarCollapsibleOnDesktop()
            ->brandName('Edmond Serenity AFH')
            ->brandLogo(asset('images/logo.png'))
            ->favicon(asset('images/favicon.ico'))
            ->maxContentWidth('full')
            ->renderHook(
                'panels::topbar.end',
                fn (): string => view('filament.components.user-menu'),
            );
    }
}










