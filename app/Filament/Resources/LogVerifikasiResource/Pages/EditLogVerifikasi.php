<?php

namespace App\Filament\Resources\LogVerifikasiResource\Pages;

use App\Filament\Resources\LogVerifikasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLogVerifikasi extends EditRecord
{
    protected static string $resource = LogVerifikasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
