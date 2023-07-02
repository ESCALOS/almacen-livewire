<?php

namespace App\Filament\Resources\ReasonResource\Pages;

use App\Filament\Resources\ReasonResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageReasons extends ManageRecords
{
    protected static string $resource = ReasonResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
