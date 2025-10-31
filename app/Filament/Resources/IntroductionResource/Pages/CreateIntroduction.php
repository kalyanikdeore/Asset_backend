<?php

namespace App\Filament\Resources\IntroductionResource\Pages;

use App\Filament\Resources\IntroductionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIntroduction extends CreateRecord
{
    protected static string $resource = IntroductionResource::class;
}
