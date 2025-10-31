<?php

namespace App\Filament\Resources\InsuranceSolutionResource\Pages;

use App\Filament\Resources\InsuranceSolutionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInsuranceSolutions extends ListRecords
{
    protected static string $resource = InsuranceSolutionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
