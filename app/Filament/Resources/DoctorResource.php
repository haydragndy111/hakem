<?php

namespace App\Filament\Resources;

use App\Constants\BloodGroupConstants;
use App\Constants\DoctorConstants;
use App\Filament\Resources\DoctorResource\Pages;
use App\Filament\Resources\DoctorResource\RelationManagers\AppointmentsRelationManager;
use App\Models\Doctor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\FileUpload::make('image')
                        ->label('Profile Image')
                        ->image(),
                    Forms\Components\TextInput::make('first_name')
                        ->label('First Name')
                        ->required(),
                    Forms\Components\TextInput::make('middle_name')
                        ->label('Middle Name')
                        ->required(),
                    Forms\Components\TextInput::make('last_name')
                        ->label('Last Name')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required(),
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->required(),
                    Forms\Components\TextInput::make('age')
                        ->numeric()
                        ->minValue(26)
                        ->maxValue(120)
                        ->required(),
                    Forms\Components\TextInput::make('experience')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(80)
                        ->required(),
                    Forms\Components\Select::make('specialization_id')
                        ->relationship(name: 'specialization', titleAttribute: 'name'),
                    Forms\Components\Select::make('gender')
                        ->options(
                            DoctorConstants::getUserGenders()
                        )
                        ->required(),
                    Forms\Components\Select::make('blood_group')
                        ->options(
                            BloodGroupConstants::getBloodGroupsValues()
                        )
                        ->required(),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->autocomplete(false)
                        ->dehydrateStateUsing(fn($state) => Hash::make($state))
                        ->dehydrated(fn($state) => filled($state))
                        ->required(fn(string $context): bool => $context === 'create'),
                    Forms\Components\Checkbox::make('is_featured')->default(false)->label('Is Featured ?'),
                    Forms\Components\Select::make('status')
                        ->options(
                            DoctorConstants::getDoctorStatus()
                        )->hidden(fn(string $operation): bool => $operation === 'create'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Profile Image')
                    ->default('doctors/doctor-avatar.jpg')
                    ->circular(),
                Tables\Columns\TextColumn::make('specialization.name')
                    ->label('Specialization')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->label('First Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->label('Middle Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Last Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_featured'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        // '1' => 'green',
                        // '2' => 'warning',
                        'active' => 'green',
                        'in-active' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->sortable()
                    ->label('Gender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('blood_group')
                    ->sortable()
                    ->label('Blood Group')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('M d Y h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Contact Info')
                    ->schema([
                        TextEntry::make('first_name'),
                        TextEntry::make('middle_name'),
                        TextEntry::make('last_name'),
                        TextEntry::make('email'),
                        ImageEntry::make('image')
                            ->label('Profile Picture')
                            ->default('/doctors/doctor-avatar.jpg'),
                    ])->columns(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AppointmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'view' => Pages\ViewDoctor::route('/{record}/view'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}
