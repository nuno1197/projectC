<?php

use App\Models\Game;
use App\Models\Practice;
use App\Models\Season;
use Carbon\Carbon;

if (!function_exists('getSeasonString')) {
    function getSeasonString($seasonID)
    {
        $string=Season::find($seasonID);

        return $string->season_string;
    }
}

if (!function_exists('getStateGame')) {
    function getStateGame($gameID):bool
    {
        $game=Game::find($gameID);
        $aux=Carbon::parse($game->end_date);

        if($aux->isPast()){
            return true;
        }
        else{
            return false;
        }

    }
}


if (!function_exists('getStatePractice')) {
    function getStatePractice($practiceID):bool
    {
        $practice=Practice::find($practiceID);
        $aux=Carbon::parse($practice->end_time);

        if($aux->isPast()){
            return true;
        }
        else{
            return false;
        }

    }
}
