<?php

namespace App\Filament\Pages;

use App\Models\Appointment;
use App\Models\Resident;
use App\Models\Branch;
use App\Models\AppointmentType;
use App\Models\HealthcareProvider;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
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
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class ResidentAppointments extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Resident Appointments';
    protected static ?string $title = 'Resident Appointments';
    protected static bool $shouldRegisterNavigation = false; // Hide from navigation
    protected static string $view = 'filament.pages.resident-appointments';

    public ?array $data = [];
    public ?int $residentId = null;
    public ?Resident $resident = null;

    public function mount(): void
    {
        $resident_id = request()->get('resident_id');
        
        if ($resident_id) {
            $this->residentId = (int) $resident_id;
            $this->resident = Resident::find($this->residentId);
            
            if ($this->resident) {
                $this->form->fill([
                    'resident_id' => $this->residentId,
                    'branch_id' => $this->resident->branch_id ?? null,
                    'created_by' => auth()->id(),
                ]);
            }
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('notes')
                    ->label('Additional Details')
                    ->placeholder('Enter any additional details...')
                    ->rows(3)
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Appointment::query()
                    ->where('resident_id', $this->residentId ?? 0)
                    ->with(['resident', 'branch', 'appointmentType', 'healthcareProvider', 'createdBy'])
                    ->orderBy('appointment_date', 'desc')
            )
            ->columns([
                TextColumn::make('resident.name')
                    ->label('Resident Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('appointment_date')
                    ->label('Date Taken')
                    ->date('M j, Y')
                    ->sortable(),

                TextColumn::make('appointmentType.name')
                    ->label('Type')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('description')
                    ->label('Other Details')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('next_appointment_date')
                    ->label('Next Appointment Date')
                    ->date('M j, Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'scheduled' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        'rescheduled' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                        'rescheduled' => 'Rescheduled',
                    ])
                    ->placeholder('All Statuses'),
            ])
            ->actions([
                TableAction::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->url(fn ($record) => route('filament.admin.resources.appointments.edit', $record))
                    ->openUrlInNewTab()
                    ->color('primary'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('appointment_date', 'desc')
            ->paginated([10, 25, 50, 100])
            ->striped();
    }

    public function submit(): void
    {
        $data = $this->data;
        
        // Create new appointment
        Appointment::create([
            'resident_id' => $this->residentId,
            'branch_id' => $this->resident->branch_id,
            'appointment_type_id' => $data['appointment_type_id'] ?? 1,
            'healthcare_provider_id' => $data['healthcare_provider_id'] ?? null,
            'appointment_date' => $data['appointment_date'] ?? now()->addDays(7),
            'appointment_time' => $data['appointment_time'] ?? '10:00:00',
            'location' => $data['location'] ?? '',
            'description' => $data['description'] ?? '',
            'notes' => $data['notes'] ?? '',
            'status' => $data['status'] ?? 'scheduled',
            'created_by' => auth()->id(),
        ]);

        // Reset form
        $this->data = [
            'resident_id' => $this->residentId,
            'branch_id' => $this->resident->branch_id ?? null,
            'created_by' => auth()->id(),
        ];

        $this->dispatch('$refresh');
        
        // Show success message
        session()->flash('success', 'Appointment created successfully!');
    }
}
