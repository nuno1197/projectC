<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Players>
 */
class PlayersFactory extends Factory
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
            'birth_date' =>fake()->date('Y-m-d'),
            'position' => fake()->randomElement(['PG', 'SG' , 'SF' , 'PF' , 'C']),
            'jersey_number' => fake()->numberBetween(0,99),
            'player_notes' => fake()->text(),
            'roster_id'=> 3,
        ];
    }
}
