<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Roster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{

    public function index(Roster $roster){

        $games= Game::where('roster_id' , $roster->id)->get();


        return view('games.index', ['roster' => $roster]);

    }

    public function indexGameplan(Game $game){

        $roster=Roster::find($game->roster_id);


        return view('games.plan_game', ['roster'=>$roster,'game' => $game]);

    }

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

        return redirect(url()->previous())->withSuccess('Game added successfully!');
    }

    /**
     * Edit a Game View
     */
    public function edit($roster_id,$gameID){

        $roster = Roster::find($roster_id);
        $game =  Game::find($gameID);

        return view('games.edit',compact('roster','game'));
    }

    /**
     * Update Game
     */
    public function update(Request $request, Game $game){


        $game->update([
            'opp_name' => $request->opp_name,
            'comp_name' => $request->comp_name,
            'local'=> $request->local,
            'start_date'=> $request->start_date,
            'end_date'=> $request->end_date,
            'roster_id' => $game->roster_id,
            'user_id' => Auth::user()->id
        ]);

        return redirect(route('games.index' , ['roster' => $game->roster_id]))->withSuccess('Game updated successfully!');

    }

    public function updateGamePlan(Request $request, Game $game){


        $game->update([
            'opp_name' => $game->opp_name,
            'comp_name' => $game->comp_name,
            'local'=> $game->local,
            'start_date'=> $game->start_date,
            'end_date'=> $game->end_date,
            'off_keys'=> $request->off_keys,
            'def_keys'=> $request->def_keys,
            'notes' => $request->notes,
            'roster_id' => $game->roster_id,
            'user_id' => Auth::user()->id
        ]);

        return redirect(route('games.index' , ['roster' => $game->roster_id]))->withSuccess('Game updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {

//        $players= Player::where('roster_id',$roster->id)->get();
//        $players->each->delete();
//        $roster->delete();
//
//
//        return redirect('/roster/' . $roster->id)->withSuccess('Roster deleted successfully!');
    }


}
