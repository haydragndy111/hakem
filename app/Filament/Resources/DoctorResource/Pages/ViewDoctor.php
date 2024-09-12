<?php

namespace App\Filament\Resources\DoctorResource\Pages;

use App\Filament\Resources\DoctorResource;
use App\Filament\Resources\DoctorResource\RelationManagers\AppointmentsRelationManager;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDoctor extends ViewRecord
{
    protected static string $resource = DoctorResource::class;

    protected static string $view = 'filament.resources.doctors.pages.view-doctor';

    public static function getRelations(): array
    {
        return [
            AppointmentsRelationManager::class
        ];
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
