<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_reg' => fake()->name(),
            'aktif' => fake()->boolean(),
            'softid' => 'softid-' . Str::random(16),
            'kontak' => fake()->phoneNumber(),
            'tgl_backup' => now(),
            'versi' => '1.0.0',
            'saldo' => fake()->numberBetween(10000, 200000),
            'online' => fake()->boolean(),
            'upline' => fake()->numerify('###'),
            'lvl_akses' => fake()->numberBetween(0, 5),
            'allow_ip' => fake()->ipv4(),
            'last_ip' => fake()->ipv4(),
            'expired' => fake()->dateTime(now()->addYear()),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
