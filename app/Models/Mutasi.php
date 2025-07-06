<?php

namespace App\Models;

use Sushi\Sushi;
use App\Services\ApiService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mutasi extends Model
{
    use Sushi;
    protected $table = 'mutasi';

    protected $fillable = [
        'jumlah',
        'saldo',
        'keterangan',
        'kode_customer',
        'tipe',
    ];

    public function getRows()
    {
        $apiService = new ApiService();
        $response = $apiService->get(
            endpoint: '/m',
            authToken: auth()->user()->auth_token,
        );

        if ($response->failed()) {
            return [];
        }

        return collect(
            value: $response->json()
        )->toArray();
    }

    public static function create($data)
    {
        $apiService = new ApiService();
        $response = $apiService->post(
            endpoint: '/m',
            authToken: auth()->user()->auth_token,
            data: $data
        );

        if ($response->failed()) {
            throw new \Exception('Failed to create mutasi: ' . $response->json('message', 'Unknown error'));
        }

        return (new static)->fill(
            attributes: $response->json()
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kode_customer', 'id');
    }
}
