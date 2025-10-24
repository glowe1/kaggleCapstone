<?php

namespace App\Filament\Pages;

use App\Models\Appointment;
use App\Models\Resident;
use App\Models\Branch;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class AppointmentHistory extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Appointment';
    protected static ?string $title = 'Appointment History';
    protected static ?int $navigationSort = 35;
    protected static ?string $navigationGroup = null;
    protected static string $view = 'filament.pages.appointment-history';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('administrator') || auth()->user()->hasRole('super_admin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole('administrator') || auth()->user()->hasRole('super_admin');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Appointment::query()
                    ->with(['resident', 'branch', 'appointmentType', 'healthcareProvider', 'createdBy'])
                    ->orderBy('appointment_date', 'desc')
            )
            ->columns([
                TextColumn::make('resident.name')
                    ->label('Resident Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('appointment_date')
                    ->label('Date')
                    ->date('M j, Y')
                    ->sortable(),

                TextColumn::make('appointmentType.name')
                    ->label('Type')
                    ->badge(),

                TextColumn::make('description')
                    ->label('Details')
                    ->limit(50),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'scheduled' => 'warning',
                        'cancelled' => 'danger',
                        'rescheduled' => 'info',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('resident_id')
                    ->label('Resident')
                    ->relationship('resident', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('branch_id')
                    ->label('Branch')
                    ->relationship('branch', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                        'rescheduled' => 'Rescheduled',
                        'pending' => 'Pending',
                    ]),
            ])
            ->actions([
                TableAction::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->url(fn ($record) => route('filament.admin.resources.appointments.edit', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('appointment_date', 'desc')
            ->paginated([10, 25, 50, 100]);
    }
}
