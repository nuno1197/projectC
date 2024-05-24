<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $start_date = fake()->dateTimeBetween('now', '+4 month')->format('Y-m-d H:i:s');
        $end_date = (new DateTime($start_date))->modify('+1 hour 30 minutes')->format('Y-m-d H:i:s');

        return [
            'opp_name' => fake()->randomElement(['BC Barcelos' , 'SC Maria da Fonte' , 'FAC' ,'Famabasket' , 'GDAS']),
            'comp_name' =>fake()->randomElement(['Taça ABB S14F' , 'Campeonato Distrital S14F']),
            'local' => fake()->randomElement(['Barcelos' , 'Famalicão' , 'Braga', 'Póvoa de Lanhoso']),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'roster_id'=> 1,
            'user_id' => 1,
        ];
    }
}
