<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use App\Models\Assessment;

class RecentAssessmentsWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Recent Assessments';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Assessment::with(['resident', 'assessor'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('resident.name')
                    ->label('Resident')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('assessment_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'initial' => 'success',
                        'periodic' => 'info',
                        'focused' => 'warning',
                        'discharge' => 'danger',
                        default => 'gray',
                    }),
                
                TextColumn::make('completion_percentage')
                    ->label('Progress')
                    ->formatStateUsing(fn ($state) => $state . '%')
                    ->color(fn ($state) => $state < 50 ? 'danger' : ($state < 100 ? 'warning' : 'success')),
                
                TextColumn::make('assessor.name')
                    ->label('Assessor')
                    ->searchable(),
                
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Assessment $record): string => route('filament.admin.resources.assessments.edit', $record))
                    ->openUrlInNewTab(),
            ]);
    }
}