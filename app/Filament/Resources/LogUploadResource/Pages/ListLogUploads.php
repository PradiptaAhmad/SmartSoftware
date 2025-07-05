<?php

namespace App\Filament\Resources\LogUploadResource\Pages;

use App\Filament\Resources\LogUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLogUploads extends ListRecords
{
    protected static string $resource = LogUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
