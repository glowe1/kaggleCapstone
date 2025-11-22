<?php

namespace App\Filament\Resources\FacilityResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('staff@serenityafh.com')
                            ->helperText('This will be used for login'),
                        
                        Forms\Components\Hidden::make('name')
                            ->afterStateUpdated(function ($state, $set, $get) {
                                $firstName = $get('first_name') ?? '';
                                $middleNames = $get('middle_names') ?? '';
                                $lastName = $get('last_name') ?? '';
                                
                                $fullName = trim(implode(' ', array_filter([$firstName, $middleNames, $lastName])));
                                $set('name', $fullName);
                            }),
                        Forms\Components\TextInput::make('first_name')
                            ->label('First Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter first name')
                            ->live()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                $firstName = $state ?? '';
                                $middleNames = $get('middle_names') ?? '';
                                $lastName = $get('last_name') ?? '';
                                
                                $fullName = trim(implode(' ', array_filter([$firstName, $middleNames, $lastName])));
                                $set('name', $fullName);
                            }),
                        Forms\Components\TextInput::make('middle_names')
                            ->label('Middle Names')
                            ->maxLength(255)
                            ->placeholder('Enter middle names (optional)')
                            ->live()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                $firstName = $get('first_name') ?? '';
                                $middleNames = $state ?? '';
                                $lastName = $get('last_name') ?? '';
                                
                                $fullName = trim(implode(' ', array_filter([$firstName, $middleNames, $lastName])));
                                $set('name', $fullName);
                            }),
                        Forms\Components\TextInput::make('last_name')
                            ->label('Last Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter last name')
                            ->live()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                $firstName = $get('first_name') ?? '';
                                $middleNames = $get('middle_names') ?? '';
                                $lastName = $state ?? '';
                                
                                $fullName = trim(implode(' ', array_filter([$firstName, $middleNames, $lastName])));
                                $set('name', $fullName);
                            }),
                        Forms\Components\TextInput::make('phone_number')
                            ->label('Phone Number')
                            ->tel()
                            ->required()
                            ->placeholder('+1 (425) 555-0123'),
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->label('Date of Birth')
                            ->required()
                            ->native(false)
                            ->displayFormat('m/d/Y')
                            ->maxDate(now()->subYears(18)),
                        Forms\Components\Select::make('marital_status')
                            ->label('Select Marital Status')
                            ->options(User::getMaritalStatusOptions())
                            ->searchable(),
                        Forms\Components\Radio::make('sex')
                            ->label('Sex')
                            ->options(User::getSexOptions())
                            ->required()
                            ->inline(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Employment Details')
                    ->schema([
                        Forms\Components\TextInput::make('credentials')
                            ->label('State the Credentials')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('date_employed')
                            ->native(false)
                            ->label('Date Employed')
                            ->required()
                            ->displayFormat('m/d/Y')
                            ->default(fn ($operation) => $operation === 'create' ? now() : null)
                            ->maxDate(now()),
                        Forms\Components\TextInput::make('supervisor_name')
                            ->label('Name of Supervisor')
                            ->maxLength(255),
                        Forms\Components\Select::make('role')
                            ->label('Role')
                            ->options(User::getRoleOptions())
                            ->searchable()
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active Employee')
                            ->default(true),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Account Security')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->placeholder('Enter secure password'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('User Name')
                    ->searchable(['first_name', 'middle_names', 'last_name', 'email'])
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'administrator' => 'danger',
                        'manager' => 'warning',
                        'registered_nurse' => 'info',
                        'care_giver' => 'success',
                        'superuser' => 'primary',
                        'support_staff' => 'secondary',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'administrator' => 'Administrator',
                        'manager' => 'Manager',
                        'registered_nurse' => 'Registered Nurse',
                        'care_giver' => 'Care Giver',
                        'superuser' => 'Superuser',
                        'support_staff' => 'Support Staff',
                        default => ucwords(str_replace('_', ' ', $state)),
                    }),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Phone')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status'),
                Tables\Filters\SelectFilter::make('role')
                    ->options(User::getRoleOptions()),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
