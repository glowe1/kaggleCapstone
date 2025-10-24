<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SleepPatternResource\Pages;
use App\Filament\Resources\SleepPatternResource\RelationManagers;
use App\Models\SleepPattern;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SleepPatternResource extends Resource
{
    protected static ?string $model = SleepPattern::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Sleep Patterns';
    protected static ?string $modelLabel = 'Sleep Pattern';
    protected static ?string $pluralModelLabel = 'Sleep Patterns';
    protected static ?string $navigationGroup = 'Resident Care';
    protected static bool $shouldRegisterNavigation = false;

    public static function canCreate(): bool
    {
        return false; // Sleep patterns are automatically generated
    }

    public static function canEdit($record): bool
    {
        return false; // Sleep patterns are automatically generated
    }

    public static function canDelete($record): bool
    {
        return false; // Sleep patterns are automatically generated
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        // If user is a caregiver, show sleep patterns for residents in their assigned branch only
        if (auth()->user()->hasRole('caregiver')) {
            $query->whereHas('resident', function ($q) {
                $q->where('branch_id', auth()->user()->assigned_branch_id);
            });
        }
        
        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Sleep Pattern Information')
                    ->schema([
                        Forms\Components\TextInput::make('resident.name')
                            ->label('Resident')
                            ->disabled(),
                        Forms\Components\TextInput::make('period')
                            ->label('Period')
                            ->disabled(),
                        Forms\Components\TextInput::make('avg_sleep_hours')
                            ->label('Average Sleep Hours')
                            ->suffix('hours')
                            ->disabled(),
                        Forms\Components\TextInput::make('days_with_records')
                            ->label('Days with Records')
                            ->suffix('days')
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Sleep Statistics')
                    ->schema([
                        Forms\Components\TextInput::make('total_sleep_hours')
                            ->label('Total Sleep Hours')
                            ->suffix('hours')
                            ->disabled(),
                        Forms\Components\TextInput::make('total_awake_hours')
                            ->label('Total Awake Hours')
                            ->suffix('hours')
                            ->disabled(),
                        Forms\Components\TextInput::make('common_sleep_time')
                            ->label('Common Sleep Time')
                            ->disabled(),
                        Forms\Components\TextInput::make('common_wake_time')
                            ->label('Common Wake Time')
                            ->disabled(),
                        Forms\Components\TextInput::make('sleep_quality_score')
                            ->label('Sleep Quality Score')
                            ->disabled(),
                        Forms\Components\Textarea::make('key_observations')
                            ->label('Key Observations')
                            ->disabled()
                            ->rows(3),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('resident.name')
                    ->label('Resident')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('period')
                    ->label('Period')
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('avg_sleep_hours')
                    ->label('Avg Sleep')
                    ->suffix(' hrs')
                    ->sortable()
                    ->color(fn ($state) => match (true) {
                        $state >= 8 => 'success',
                        $state >= 6 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('days_with_records')
                    ->label('Days Recorded')
                    ->suffix(' days')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sleep_quality_score')
                    ->label('Quality Score')
                    ->formatStateUsing(fn ($state) => $state ? $state . '/10' : 'N/A')
                    ->color(fn ($state) => match (true) {
                        $state >= 8 => 'success',
                        $state >= 6 => 'warning',
                        $state >= 1 => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('common_sleep_time')
                    ->label('Common Sleep Time')
                    ->time('h:i A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('common_wake_time')
                    ->label('Common Wake Time')
                    ->time('h:i A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('resident_id')
                    ->label('Resident')
                    ->relationship('resident', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('year')
                    ->label('Year')
                    ->options(function () {
                        $years = \App\Models\SleepPattern::distinct('year')
                            ->orderBy('year', 'desc')
                            ->pluck('year', 'year')
                            ->toArray();
                        return $years;
                    }),
                Tables\Filters\SelectFilter::make('month')
                    ->label('Month')
                    ->options([
                        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([])
            ->defaultSort('year', 'desc')
            ->defaultSort('month', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSleepPatterns::route('/'),
            'view' => Pages\ViewSleepPattern::route('/{record}'),
        ];
    }
}
