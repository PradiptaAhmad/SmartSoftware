<?php

namespace App\Filament\Pages;

use App\Models\User;
use App\Services\ApiService;
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
                TextInput::make('id')
                    ->label('No Registrasi')
                    ->required()
                    ->numeric(),
                TextInput::make('user_reg')
                    ->label('Nama Server')
                    ->required()
                    ->maxLength(255),
                TextInput::make('softid')
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
        $apiService = new ApiService();
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }


        $data = $this->form->getState();

        $login = $apiService->post(
            endpoint: '/login',
            data: [
                'id' => $data['id'],
                'user_reg' => $data['user_reg'],
                'softid' => $data['softid'],
                'fe' => 'web'
            ]
        );
        if ($login->failed()) {
            $this->throwFailureValidationException();
        }
        $user = User::where('user_reg', $login['data']['user_reg'])
            ->first();

        if (!$user) {
            $user = User::create([
                'user_reg' => $login['data']['user_reg'],
                'auth_token' => $login['token'] ?? null,
            ]);
        } else {
            $user->update([
                'user_reg' => $login['data']['user_reg'],
                'auth_token' => $login['token'] ?? null
            ]);
        }

        Filament::auth()->login($user, $data['remember'] ?? false);

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
