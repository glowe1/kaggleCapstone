<?php

namespace App\Filament\Navigation;

use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationBuilder;
use Filament\Facades\Filament;

class CustomNavigationProvider
{
    public function __invoke(NavigationBuilder $builder): NavigationBuilder
    {
        return $builder
            ->groups([
                // Dashboard Group
                NavigationGroup::make('Dashboard')
                    ->icon('heroicon-o-home')
                    ->items([
                        NavigationItem::make('Dashboard')
                            ->icon('heroicon-o-home')
                            ->url(route('filament.admin.pages.dashboard'))
                            ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                            ->sort(-1000),
                    ]),

                // Resident Care Group
                NavigationGroup::make('Resident Care')
                    ->icon('heroicon-o-heart')
                    ->items([
                        NavigationItem::make('Residents')
                            ->icon('heroicon-o-users')
                            ->url(route('filament.admin.resources.residents.index'))
                            ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.residents.*')),
                        
                        NavigationItem::make('View Vitals')
                            ->icon('heroicon-o-heart')
                            ->url(route('filament.admin.pages.view-vitals'))
                            ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.view-vitals'))
                            ->sort(20),
                        
                        NavigationItem::make('Resident Appointments')
                            ->icon('heroicon-o-calendar-days')
                            ->url(route('filament.admin.resources.appointments.index'))
                            ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.appointments.*'))
                            ->sort(30),
                        
                        NavigationItem::make('Assessments')
                            ->icon('heroicon-o-clipboard-document-list')
                            ->url(route('filament.admin.resources.assessments.index'))
                            ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.assessments.*'))
                            ->sort(40),
                        
                        NavigationItem::make('Medications')
                            ->icon('heroicon-o-beaker')
                            ->url(route('filament.admin.resources.medications.index'))
                            ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.medications.*'))
                            ->sort(50),
                    ]),

                // Staff Management Group
                NavigationGroup::make('Staff Management')
                    ->icon('heroicon-o-user-group')
                    ->items([
                        NavigationItem::make('Manage Users')
                            ->icon('heroicon-o-users')
                            ->url(route('filament.admin.resources.users.index'))
                            ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.users.*')),
                        
                        NavigationItem::make('Roles & Permissions')
                            ->icon('heroicon-o-shield-check')
                            ->url(route('filament.admin.resources.roles.index'))
                            ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.roles.*')),
                        
                        NavigationItem::make('Leave Requests')
                            ->icon('heroicon-o-calendar')
                            ->url(route('filament.admin.resources.leave-requests.index'))
                            ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.leave-requests.*')),
                    ]),

                // System Administration Group
                NavigationGroup::make('Administration')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->items([
                        NavigationItem::make('Facilities')
                            ->icon('heroicon-o-building-office')
                            ->url(route('filament.admin.resources.facilities.index'))
                            ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.facilities.*'))
                            ->sort(60),
                        
                        NavigationItem::make('Branches')
                            ->icon('heroicon-o-building-office-2')
                            ->url(route('filament.admin.resources.branches.index'))
                            ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.branches.*'))
                            ->sort(70),
                        
                        NavigationItem::make('Vital Ranges')
                            ->icon('heroicon-o-scale')
                            ->url(route('filament.admin.resources.vital-ranges.index'))
                            ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.vital-ranges.*'))
                            ->sort(80),
                    ]),
            ]);
    }
}





