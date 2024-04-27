<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'username' => Str::random('10'),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $this->faker->password(),
            'phone' => $this->faker->phoneNumber(),
            'administrator' => "false",
        ];
    }
}
