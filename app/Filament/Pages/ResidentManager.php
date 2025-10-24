<?php

namespace App\Filament\Pages;

use App\Models\Branch;
use App\Models\User;
use App\Models\Resident;
use App\Models\Assignment;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class ResidentManager extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Resident Manager';
    protected static ?string $title = 'Resident Manager';
    protected static ?string $navigationGroup = 'Administration';
    protected static string $view = 'filament.pages.resident-manager';

    public static function canAccess(): bool
    {
        return auth()->user()->hasPermission('view_resident_manager');
    }

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Assignment Form')
                    ->description('Assign caregivers to residents across branches')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('selectedBranch')
                                    ->label('Select a Branch')
                                    ->options(Branch::where('is_active', true)->pluck('name', 'id')->toArray())
                                    ->searchable()
                                    ->live()
                                    ->required()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('selectedResident', null);
                                        $set('selectedCaregiver', null);
                                    }),

                                Select::make('selectedResident')
                                    ->label('Select a Resident')
                                    ->options(function (callable $get) {
                                        $branchId = $get('selectedBranch');
                                        if (!$branchId) {
                                            return [];
                                        }
                                        return Resident::where('branch_id', $branchId)
                                            ->where('is_active', true)
                                            ->whereNotNull('name')
                                            ->where('name', '!=', '')
                                            ->pluck('name', 'id')
                                            ->filter(function ($name, $id) {
                                                return !empty($name) && !is_null($name);
                                            })
                                            ->toArray();
                                    })
                                    ->searchable()
                                    ->live()
                                    ->required()
                                    ->placeholder('Select a resident...')
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('selectedCaregiver', null);
                                    }),

                                Select::make('selectedCaregiver')
                                    ->label('Select a Caregiver')
                                    ->options(function (callable $get) {
                                        $branchId = $get('selectedBranch');
                                        if (!$branchId) {
                                            return [];
                                        }
                                        return User::where('assigned_branch_id', $branchId)
                                            ->where('is_active', true)
                                            ->whereIn('role', ['caregiver', 'registered_nurse', 'nurse'])
                                            ->whereNotNull('name')
                                            ->where('name', '!=', '')
                                            ->pluck('name', 'id')
                                            ->filter(function ($name, $id) {
                                                return !empty($name) && !is_null($name);
                                            })
                                            ->toArray();
                                    })
                                    ->searchable()
                                    ->live()
                                    ->required()
                                    ->placeholder('Select a caregiver...'),

                                Textarea::make('notes')
                                    ->label('Assignment Notes (Optional)')
                                    ->rows(3)
                                    ->placeholder('Add any notes about this assignment...'),
                            ]),
                        
                        \Filament\Forms\Components\Actions::make([
                            \Filament\Forms\Components\Actions\Action::make('assign')
                                ->label('Assign')
                                ->color('primary')
                                ->size('lg')
                                ->action(function () {
                                    $data = $this->form->getState();

                                    // Validate
                                    if (empty($data['selectedBranch']) || empty($data['selectedResident']) || empty($data['selectedCaregiver'])) {
                                        Notification::make()
                                            ->title('Validation Error')
                                            ->body('Please select a branch, resident, and caregiver.')
                                            ->danger()
                                            ->send();
                                        return;
                                    }

                                    // Check if assignment already exists
                                    $existingAssignment = Assignment::where('caregiver_id', $data['selectedCaregiver'])
                                        ->where('resident_id', $data['selectedResident'])
                                        ->where('is_active', true)
                                        ->first();

                                    if ($existingAssignment) {
                                        Notification::make()
                                            ->title('Assignment Already Exists')
                                            ->body('This caregiver is already assigned to this resident.')
                                            ->warning()
                                            ->send();
                                        return;
                                    }

                                    // Create new assignment
                                    Assignment::create([
                                        'caregiver_id' => $data['selectedCaregiver'],
                                        'resident_id' => $data['selectedResident'],
                                        'branch_id' => $data['selectedBranch'],
                                        'assigned_at' => now(),
                                        'assigned_by' => Auth::id(),
                                        'notes' => $data['notes'] ?? null,
                                        'is_active' => true,
                                    ]);

                                    Notification::make()
                                        ->title('Assignment Created')
                                        ->body('Caregiver has been successfully assigned to the resident.')
                                        ->success()
                                        ->send();

                                    // Reset form
                                    $this->form->fill();
                                }),
                        ])
                        ->alignEnd(),
                    ]),
            ])
            ->statePath('data');
    }


    public function getAssignments(): Collection
    {
        return Assignment::with(['resident', 'caregiver', 'branch'])
            ->where('is_active', true)
            ->orderBy('assigned_at', 'desc')
            ->get();
    }

}