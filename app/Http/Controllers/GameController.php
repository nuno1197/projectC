<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Roster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{


    /**
     * Create a Game View
     */
    public function create($roster_id){

        $rosters = Roster::find($roster_id);

        return view('games.create',compact('rosters'));
    }

    /**
     * Store Game
     */
    public function store(Request $request){

        request()->validate([
            'opp_name' => ['required'],
            'comp_name' => ['required'],
            'start_date' => ['required'|'date'],
            'end_date'=> ['required' | 'date'],
            'local' => ['required'],
        ]);

        $rosters = Roster::find(request('roster_id'));

        $game = Game::create([
            'opp_name' => request('opp_name'),
            'comp_name' => request('comp_name'),
            'local' => request('local'),
            'start_date'=> request('start_time'),
            'end_date' => request('end_time'),
            'user_id' => Auth::user()->id,
            'roster_id' => request('roster_id'),
        ]);

        return redirect(route('planning.events', ['roster' => request('roster_id')]))->withSuccess('Game added successfully!');
    }
}
