<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'seasons_id'=>1,
            'birth_date' => fake()->date(),
            'position' => fake()->colorName(),
            'number' => fake()->numberBetween(0,99),
            'license' => fake()->phoneNumber()
        ];
    }

}
