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
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class AssignResident extends Page implements HasForms, HasActions
{
    use InteractsWithForms, InteractsWithActions;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationLabel = 'Assign Resident';
    protected static ?string $navigationGroup = 'Residents';
    protected static bool $shouldRegisterNavigation = false; // hide from sidebar
    protected static ?string $title = 'Assign Resident';
    protected static string $view = 'filament.pages.assign-resident';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
        $this->data = [];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Assignment Form')
                    ->description('Assign caregivers to residents across branches')
                    ->schema([
                        Select::make('selectedBranchId')
                            ->label('Select a Branch')
                            ->options(Branch::where('is_active', true)->pluck('name', 'id')->toArray())
                            ->searchable()
                            ->live()
                            ->required(),

                        Select::make('selectedCaregiverId')
                            ->label('Select a Caregiver')
                            ->options(function () {
                                $branchId = $this->data['selectedBranchId'] ?? null;
                                if (!$branchId) {
                                    return [];
                                }
                                return User::where('assigned_branch_id', $branchId)
                                    ->where('is_active', true)
                                    ->whereIn('role', ['caregiver', 'registered_nurse'])
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->required(),

                        Select::make('selectedResidentId')
                            ->label('Select a Resident')
                            ->options(function () {
                                $branchId = $this->data['selectedBranchId'] ?? null;
                                if (!$branchId) {
                                    return [];
                                }
                                return Resident::where('branch_id', $branchId)
                                    ->where('is_active', true)
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->required(),

                        Textarea::make('assignmentNotes')
                            ->label('Assignment Notes (Optional)')
                            ->rows(3)
                            ->placeholder('Add any notes about this assignment...'),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function assignAction(): Action
    {
        return Action::make('assign')
            ->label('Assign Resident')
            ->color('primary')
            ->size('lg')
            ->action(function () {
                $this->validate();

                $data = $this->form->getState();

                // Check if assignment already exists
                $existingAssignment = Assignment::where('caregiver_id', $data['selectedCaregiverId'])
                    ->where('resident_id', $data['selectedResidentId'])
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
                    'caregiver_id' => $data['selectedCaregiverId'],
                    'resident_id' => $data['selectedResidentId'],
                    'branch_id' => $data['selectedBranchId'],
                    'assigned_at' => now(),
                    'assigned_by' => Auth::id(),
                    'notes' => $data['assignmentNotes'],
                    'is_active' => true,
                ]);

                Notification::make()
                    ->title('Assignment Created')
                    ->body('Caregiver has been successfully assigned to the resident.')
                    ->success()
                    ->send();

                // Reset form
                $this->form->fill();
            });
    }

    public function getAssignments(): Collection
    {
        return Assignment::with(['caregiver', 'resident', 'branch'])
            ->active()
            ->orderBy('branch_id')
            ->orderBy('caregiver_id')
            ->get();
    }

    public function getBranches(): Collection
    {
        return Branch::active()->with(['caregivers', 'residents'])->get();
    }
}
