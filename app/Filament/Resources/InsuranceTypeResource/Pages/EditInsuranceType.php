<?php

namespace App\Filament\Resources\InsuranceTypeResource\Pages;

use App\Filament\Resources\InsuranceTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInsuranceType extends EditRecord
{
    protected static string $resource = InsuranceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
