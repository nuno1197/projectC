<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Practice;
use App\Models\Roster;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index(Roster $roster)
    {
        // Obter os dados de diferentes fontes
        $practices = Practice::where('roster_id', $roster->id)->get();
        $games = Game::where('roster_id', $roster->id)->get();

        // Combinar os dados em um único array
        $events = [];

        foreach ($practices as $practice) {
            $events[] = [
                'title' => 'Practice Nr:'. $practice->pratice_number . " @ " .$practice->pratice_location,
                'start' => $practice->start_time,
                'end' => $practice->end_time,
                'description' => $practice->comments,
                'backgroundColor' => '#0EB1D2',
                'textColor' => '#111827',
                'url' => route('practice.edit',['practice' => $practice->id]),
            ];
        }

        foreach ($games as $game) {
            $events[] = [
                'title' => 'Game vs '. $game->opp_name . " @ " .$game->local,
                'start' => $game->start_date,
                'end' => $game->end_date,
                'description' => $game->comp_name,
                'backgroundColor' => '#E57A44',
                'textColor' => '#111827',
                'url' => '#',
            ];
        }


        return view('events.index', compact('events'),['roster'=>$roster]);
    }
}
