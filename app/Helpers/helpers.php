<?php

use App\Models\Game;
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
