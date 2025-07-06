<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Services\ApiService;
use Filament\Actions;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('softid')
                    ->label('Software ID')
                    ->required(),
                TextInput::make('user_reg')
                    ->label('Nama')
                    ->required(),
                Checkbox::make('aktif')
                    ->label('Aktif')
                    ->default(true)
                    ->helperText('Centang jika customer ini masih aktif'),
            ]);
    }

    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {
        $apiService = new ApiService();
        $data = $this->form->getState();
        $response = $apiService->post(
            endpoint: '/c',
            authToken: auth()->user()->auth_token,
            data: [
                'id' => $this->record->id,
                'softid' => $data['softid'],
                'user_reg' => $data['user_reg'],
                'aktif' => $data['aktif'] ? 1 : 0,
            ]
        );
        dd($response->json(     ));
        if ($response->failed()) {
            Notification::make()
                ->title('Gagal menyimpan data')
                ->body('Terjadi kesalahan saat menyimpan data.')
                ->danger()
                ->send();
            return;
        } else {
            Notification::make()
                ->title('Berhasil')
                ->body('Data customer berhasil disimpan.')
                ->success()
                ->send();
            $this->redirect(
                url: url()->previous(),
            );
        }
    }
}
