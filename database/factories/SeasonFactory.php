<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SeasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Definir a data inicial padrão
        static $startYear = 2023;
        static $endYear = 2024;

        $start_date_season = Carbon::create($startYear, 9, 1); // 01/09/2023
        $end_date_season = Carbon::create($endYear, 6, 10);   // 10/06/2024

        // Incrementar o ano para a próxima execução
        $startYear++;
        $endYear++;

        return [
            'start_date_season' => $start_date_season->format('Y-m-d'),
            'end_date_season' => $end_date_season->format('Y-m-d'),
            'season_string' => $startYear . '/' . str_pad($endYear, 2, 0, STR_PAD_LEFT),
        ];
    }
}
