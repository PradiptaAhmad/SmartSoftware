<?php

namespace App\Filament\Resources\LogUploadResource\Pages;

use App\Filament\Resources\LogUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLogUpload extends EditRecord
{
    protected static string $resource = LogUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
