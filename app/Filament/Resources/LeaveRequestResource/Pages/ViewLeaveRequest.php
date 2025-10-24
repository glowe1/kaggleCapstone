<?php

namespace App\Filament\Resources\LeaveRequestResource\Pages;

use App\Filament\Resources\LeaveRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewLeaveRequest extends ViewRecord
{
    protected static string $resource = LeaveRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Take Action')
                ->color('primary')
                ->icon('heroicon-o-check-circle')
                ->visible(fn ($record) => $record->status === 'pending'),
            Actions\EditAction::make()
                ->label('Edit Request')
                ->color('warning')
                ->icon('heroicon-o-pencil'),
            Actions\DeleteAction::make()
                ->label('Delete Request')
                ->color('danger')
                ->icon('heroicon-o-trash'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Leave Request Information')
                    ->schema([
                        Infolists\Components\Split::make([
                            Infolists\Components\Grid::make(2)
                                ->schema([
                                    Infolists\Components\TextEntry::make('staff.name')
                                        ->label('Staff Member')
                                        ->weight('bold')
                                        ->size('lg')
                                        ->formatStateUsing(fn ($record) => $record->staff?->name ?? $record->staff?->email ?? 'Unknown User'),
                                    Infolists\Components\TextEntry::make('status')
                                        ->label('Status')
                                        ->badge()
                                        ->color(fn (string $state): string => match ($state) {
                                            'pending' => 'warning',
                                            'approved' => 'success',
                                            'declined' => 'danger',
                                            default => 'gray',
                                        })
                                        ->formatStateUsing(fn (string $state): string => match ($state) {
                                            'pending' => 'Pending',
                                            'approved' => 'Approved',
                                            'declined' => 'Declined',
                                            default => ucfirst($state),
                                        }),
                                ]),
                            Infolists\Components\Group::make([
                                Infolists\Components\TextEntry::make('start_date')
                                    ->label('Start Date')
                                    ->date('M j, Y')
                                    ->icon('heroicon-o-calendar'),
                                Infolists\Components\TextEntry::make('end_date')
                                    ->label('End Date')
                                    ->date('M j, Y')
                                    ->icon('heroicon-o-calendar'),
                                Infolists\Components\TextEntry::make('duration')
                                    ->label('Duration')
                                    ->getStateUsing(fn ($record) => $record->duration . ' day' . ($record->duration > 1 ? 's' : ''))
                                    ->badge()
                                    ->color('info'),
                            ]),
                        ]),
                        Infolists\Components\TextEntry::make('reason')
                            ->label('Reason for Leave')
                            ->columnSpanFull()
                            ->markdown()
                            ->placeholder('No reason provided'),
                    ])
                    ->columns(1),

                Infolists\Components\Section::make('Approval Details')
                    ->schema([
                        Infolists\Components\Split::make([
                            Infolists\Components\TextEntry::make('approvedBy.name')
                                ->label('Approved By')
                                ->placeholder('Not yet approved')
                                ->icon('heroicon-o-user')
                                ->formatStateUsing(fn ($record) => $record->approvedBy?->name ?? $record->approvedBy?->email ?? 'Not yet approved'),
                            Infolists\Components\TextEntry::make('approved_at')
                                ->label('Approved At')
                                ->dateTime('M j, Y g:i A')
                                ->placeholder('Not yet approved')
                                ->icon('heroicon-o-clock'),
                        ]),
                        Infolists\Components\TextEntry::make('decline_reason')
                            ->label('Decline Reason')
                            ->columnSpanFull()
                            ->placeholder('Not declined')
                            ->markdown()
                            ->visible(fn ($record) => $record->status === 'declined'),
                    ])
                    ->columns(1)
                    ->visible(fn ($record) => in_array($record->status, ['approved', 'declined'])),

                Infolists\Components\Section::make('Request Details')
                    ->schema([
                        Infolists\Components\Split::make([
                            Infolists\Components\TextEntry::make('created_at')
                                ->label('Requested At')
                                ->dateTime('M j, Y g:i A')
                                ->icon('heroicon-o-calendar'),
                            Infolists\Components\TextEntry::make('updated_at')
                                ->label('Last Updated')
                                ->dateTime('M j, Y g:i A')
                                ->icon('heroicon-o-clock'),
                        ]),
                    ])
                    ->columns(1),
            ]);
    }
}
