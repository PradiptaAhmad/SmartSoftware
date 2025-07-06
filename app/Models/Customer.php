<?php

namespace App\Models;

use App\Services\ApiService;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Customer extends Model
{
    use Sushi;

    public function getRows()
    {
        $apiService = new ApiService();
        $customers = collect(
            value: $apiService->get(
                endpoint: '/c',
                authToken: auth()->user()->auth_token,
            )->json()
        );

        return $customers->toArray();
    }

    public function resellers()
    {
        $apiService = new ApiService();
        return collect(
            value: $apiService->get(
                endpoint: '/r',
                authToken: auth()->user()->auth_token,
            )->json()
        );

    }

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }
}
