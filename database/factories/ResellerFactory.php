<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reseller>
 */
class ResellerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::all()->pluck('id');
        return [
            "nama" => fake()->name(),
            'saldo' => fake()->numberBetween(100000, 1000000),
            'alamat' => fake()->address(),
            'pin' => fake()->numerify('########'),
            'aktif' => fake()->boolean(),
            'kode_upline' => fake()->numerify('RS-#####'),
            'kode_level' => fake()->randomElement(['RS', 'CS', 'UP']),
            'keterangan' => fake()->sentence(),
            'tgl_daftar' => fake()->dateTimeBetween('-1 year', 'now'),
            'saldo_minimal' => fake()->numberBetween(10000, 500000),
            'tgl_aktivitas' => fake()->dateTimeBetween('-1 month', 'now'),
            'pengingat_saldo' => fake()->numberBetween(10000, 500000),
            'f_pengingat_saldo' => fake()->numberBetween(1, 30),
            'nama_pemilik' => fake()->name(),
            'kode_area' => fake()->numerify('AR-###'),
            'tgl_pengingat_saldo' => fake()->dateTimeBetween('-1 month', 'now'),
            'markup' => fake()->numberBetween(0, 1000),
            'markup_ril' => fake()->numberBetween(0, 10000),
            'pengirim' => fake()->name(),
            'komisi' => fake()->numberBetween(1000, 50000),
            'kode_mutasi' => (int) fake()->numerify('#####'),
            'kode_customer' => fake()->randomElement($userId->toArray()),
        ];
    }
}
