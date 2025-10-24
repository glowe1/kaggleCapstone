<?php

namespace App\Filament\Widgets;

use App\Models\Medication;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Widgets\TableWidget;

class RecentMedicationsWidget extends TableWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Recent Medications';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Medication::with(['resident', 'createdBy'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('resident.name')
                    ->label('Resident')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('name')
                    ->label('Medication')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('instructions')
                    ->label('Instructions')
                    ->formatStateUsing(fn (string $state): string => Medication::getInstructionOptions()[$state] ?? $state)
                    ->badge()
                    ->color('primary'),
                
                TextColumn::make('is_active')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray'),
                
                TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->sortable(),
                
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Medication $record): string => route('filament.admin.resources.medications.view', $record))
                    ->openUrlInNewTab(),
            ]);
    }
}








