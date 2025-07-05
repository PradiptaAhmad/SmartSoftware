<?php

namespace App\Http\Responses;


class LoginResponse implements \Filament\Http\Responses\Auth\Contracts\LoginResponse
{
    public function toResponse($request)
    {
        $action = session('action');
        if ($action === 'administrasi') {
            return redirect()->to(filament()->getPanel('smartsoftware')->getUrl());
        }

        return redirect()->to(
            filament()->getPanel('monitoring')->getUrl()
        );
    }
}
