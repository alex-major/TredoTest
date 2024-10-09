<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use Kreait\Laravel\Firebase\Facades\Firebase;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserDevice>
 */
class UserDeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
			'user_id' => User::factory(),
			'fcm_token' => FireBase::auth()->createCustomToken(Str::uuid())->toString(),
        ];
    }
}
