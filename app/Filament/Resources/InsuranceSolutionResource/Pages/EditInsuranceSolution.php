<?php

namespace App\Filament\Resources\InsuranceSolutionResource\Pages;

use App\Filament\Resources\InsuranceSolutionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInsuranceSolution extends EditRecord
{
    protected static string $resource = InsuranceSolutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
