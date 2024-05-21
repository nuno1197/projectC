<?php

namespace Database\Factories;

use App\Models\Roster;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Roster>
 */
class RosterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'roster_name' => fake()->name(),
            'age_squad' => "under " . fake()->numberBetween(6,23),
            'gender' => fake()->randomElement(['male', 'female']),
            'user_id'=> 1,
            'seasons_id' => 1,

        ];
    }


}
