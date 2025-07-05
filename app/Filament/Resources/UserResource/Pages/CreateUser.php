<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Actions;
use Illuminate\Support\Str;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function mount(): void
    {
        $software_id = '';
        do {
            $software_id = 'softid-' . Str::random(16);
        } while (User::where('software_id', $software_id)->exists());
        $this->form->fill([
            'software_id' => $software_id,
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['expired'] = now()->addYear() ;
    $data['status'] = true;
    return $data;
}
}
