<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Player;
use App\Models\Roster;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Vite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{

    public function index(Roster $roster){

        $games= Game::where('roster_id' , $roster->id)->get();


        return view('games.index', ['roster' => $roster]);

    }

    public function indexGameplan(Game $game){

        $roster=Roster::find($game->roster_id);

        $players=Player::where('roster_id',$game->roster_id)->get();

        $selected_players=Game::find($game->id)->players;



        return view('games.plan_game', ['roster'=>$roster,'game' => $game , 'players' => $players, 'selected_players' => $selected_players]);

    }

    public function createPDF(Game $game){

        $players=Game::find($game->id)->players;
        $data=['players' => $players , 'game' => $game];

        $pdf=Pdf::loadView('games.pdf.game_plan_pdf', $data);

        $pdf->setOptions(['isRemoteEnabled' => true]);
        $pdf->getDomPDF()->setProtocol($_SERVER['DOCUMENT_ROOT']);

        return $pdf->download('game_plan_vs_'.$game->opp_name);
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

        $player_ids=$request->selected_players;
        $player_ids= explode(",", $player_ids);
        //$gameAux = Game::find($game->id);
        // IDs dos jogadores atuais do jogo
        $currentPlayerIds = $game->players()->pluck('player_id')->toArray();
        // IDs dos jogadores que precisam ser removidos (presentes no BD, mas não na request)
        $playersToRemove = array_diff($currentPlayerIds, $player_ids);
        // Remover os jogadores do jogo
        $game->players()->detach($playersToRemove);
        $game->players()->sync($player_ids);


        return redirect(route('games.indexplangame' , ['game' => $game]))->withSuccess('Game updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {

        //eliminar plano de jogo (tabela game_player)
        $players_plan=DB::table('game_player')->where('game_id', '=', $game->id)->delete();
        $game->delete();


        return redirect(route('games.index', ['roster' => $game->roster_id]))->withSuccess('Game deleted successfully!');
    }


}
