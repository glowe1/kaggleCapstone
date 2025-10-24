<?php

namespace App\Filament\Resources\VitalSignResource\Pages;

use App\Filament\Resources\VitalSignResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;

class ViewVitalSign extends ViewRecord
{
    protected static string $resource = VitalSignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('vitals_history')
                ->label('Vitals History')
                ->icon('heroicon-o-heart')
                ->color('info')
                ->url(fn () => route('filament.admin.pages.vitals-history', ['resident' => $this->record->resident_id]))
                ->openUrlInNewTab(),
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Resident Information')
                    ->schema([
                        TextEntry::make('resident.name')
                            ->label('Resident')
                            ->icon('heroicon-o-user'),
                        TextEntry::make('measurement_date')
                            ->label('Measurement Date')
                            ->date('M j, Y')
                            ->icon('heroicon-o-calendar'),
                        TextEntry::make('takenBy.name')
                            ->label('Taken By')
                            ->icon('heroicon-o-user-circle')
                            ->placeholder('Unknown'),
                    ])
                    ->columns(3),

                Section::make('Vital Signs Measurements')
                    ->schema([
                        TextEntry::make('systolic')
                            ->label('Systolic (mmHg)')
                            ->formatStateUsing(fn ($state) => $state ? $state . ' mmHg' : 'Not recorded')
                            ->icon('heroicon-o-heart')
                            ->badge()
                            ->color(fn ($record) => $record->checkBloodPressureRange() === 'critical' ? 'danger' : 
                                               ($record->checkBloodPressureRange() === 'warning' ? 'warning' : 'success')),
                        TextEntry::make('diastolic')
                            ->label('Diastolic (mmHg)')
                            ->formatStateUsing(fn ($state) => $state ? $state . ' mmHg' : 'Not recorded')
                            ->icon('heroicon-o-heart')
                            ->badge()
                            ->color(fn ($record) => $record->checkBloodPressureRange() === 'critical' ? 'danger' : 
                                               ($record->checkBloodPressureRange() === 'warning' ? 'warning' : 'success')),
                        TextEntry::make('temperature')
                            ->label('Temperature')
                            ->formatStateUsing(fn ($record) => $record->formatted_temperature ?? 'Not recorded')
                            ->icon('heroicon-o-fire')
                            ->badge()
                            ->color(fn ($record) => $record->checkTemperatureRange() === 'critical' ? 'danger' : 
                                               ($record->checkTemperatureRange() === 'warning' ? 'warning' : 'success')),
                        TextEntry::make('pulse')
                            ->label('Pulse')
                            ->formatStateUsing(fn ($record) => $record->formatted_pulse ?? 'Not recorded')
                            ->icon('heroicon-o-heart')
                            ->badge()
                            ->color(fn ($record) => $record->checkPulseRange() === 'critical' ? 'danger' : 
                                               ($record->checkPulseRange() === 'warning' ? 'warning' : 'success')),
                        TextEntry::make('oxygen_saturation')
                            ->label('Oxygen Saturation')
                            ->formatStateUsing(fn ($record) => $record->formatted_oxygen_saturation ?? 'Not recorded')
                            ->icon('heroicon-o-wind')
                            ->badge()
                            ->color(fn ($record) => $record->checkOxygenSaturationRange() === 'critical' ? 'danger' : 
                                               ($record->checkOxygenSaturationRange() === 'warning' ? 'warning' : 'success')),
                        TextEntry::make('pain_level')
                            ->label('Pain Level')
                            ->formatStateUsing(fn ($record) => $record->pain_level ? $record->pain_level . '/10' : 'Not recorded')
                            ->icon('heroicon-o-face-frown')
                            ->badge()
                            ->color(fn ($record) => $record->pain_level > 7 ? 'danger' : 
                                               ($record->pain_level > 4 ? 'warning' : 'success')),
                    ])
                    ->columns(3),

                Section::make('Additional Information')
                    ->schema([
                        TextEntry::make('pain_description')
                            ->label('Pain Description')
                            ->placeholder('No pain description provided')
                            ->columnSpanFull(),
                        TextEntry::make('notes')
                            ->label('Notes')
                            ->placeholder('No notes provided')
                            ->columnSpanFull(),
                        IconEntry::make('status')
                            ->label('Status')
                            ->formatStateUsing(fn (string $state): string => match($state) {
                                'approved' => 'Approved',
                                'pending_review' => 'Pending Review',
                                'critical' => 'Critical',
                                'declined' => 'Declined',
                                default => ucfirst($state),
                            })
                            ->icons([
                                'heroicon-o-check-circle' => 'approved',
                                'heroicon-o-clock' => 'pending_review',
                                'heroicon-o-exclamation-triangle' => 'critical',
                                'heroicon-o-x-circle' => 'declined',
                            ])
                            ->colors([
                                'success' => 'approved',
                                'warning' => 'pending_review',
                                'danger' => 'critical',
                                'gray' => 'declined',
                            ]),
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime('M j, Y H:i')
                            ->icon('heroicon-o-clock'),
                    ])
                    ->columns(2),
            ]);
    }
}
