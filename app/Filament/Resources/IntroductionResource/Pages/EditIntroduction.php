<?php

namespace App\Filament\Resources\IntroductionResource\Pages;

use App\Filament\Resources\IntroductionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIntroduction extends EditRecord
{
    protected static string $resource = IntroductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
