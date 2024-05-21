<?php

use App\Models\Seasons;

if (!function_exists('getSeasonString')) {
    function getSeasonString($seasonID)
    {
        $string=Seasons::find($seasonID);

        return $string->season_string;
    }
}
