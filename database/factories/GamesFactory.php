<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GamesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'opp_name' => fake()->name(),
            'comp_name' =>fake()->name(),
            'local' => fake()->locale(),
            'start_date' => fake()->dateTime(),
            'end_date' => fake()->text(),
            'roster_id'=> 3,
        ];
    }
}
