<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Facades\Filament;
use Filament\Pages\Auth\Login;
use Filament\Forms\Components\TextInput;
use Dotenv\Exception\ValidationException;
use Filament\Models\Contracts\FilamentUser;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Radio;

class CustomLogin extends Login
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('no_registrasi')
                    ->label('No Registrasi')
                    ->required()
                    ->numeric(),
                TextInput::make('nama')
                    ->label('Nama Server')
                    ->required()
                    ->maxLength(255),
                TextInput::make('software_id')
                    ->label('Software ID')
                    ->required()
                    ->maxLength(255),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }

    // protected function getCredentialsFromFormData(array $data): array
    // {
    //     return [
    //         'no_registrasi' => $data['no_registrasi'],
    //         'nama' => $data['nama'],
    //         'software_id' => $data['software_id'],
    //     ];
    // }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }


        $data = $this->form->getState();

        $user = User::where([
            'user_reg' => $data['no_registrasi'] ?? null,
            'nama' => $data['nama'] ?? null,
            'softid' => $data['software_id'] ?? null,
        ])->first();

        if (!$user) {
            $this->throwFailureValidationException();
        }
        Filament::auth()->login($user, $data['remember'] ?? false);
        $user = Filament::auth()->user();

        if (
            ($user instanceof FilamentUser) &&
            (!$user->canAccessPanel(Filament::getCurrentPanel()))
        ) {
            Filament::auth()->logout();

            $this->throwFailureValidationException();
        }


        session()->regenerate();

        return app(LoginResponse::class);
    }
}
