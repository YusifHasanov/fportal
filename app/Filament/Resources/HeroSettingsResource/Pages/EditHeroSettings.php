<?php

namespace App\Filament\Resources\HeroSettingsResource\Pages;

use App\Filament\Resources\HeroSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHeroSettings extends EditRecord
{
    protected static string $resource = HeroSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
