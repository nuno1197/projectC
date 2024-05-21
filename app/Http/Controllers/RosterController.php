<?php

namespace App\Http\Controllers;

use App\Models\Players;
use App\Models\Roster;
use App\Models\Seasons;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RosterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($seasonsID)
    {

        $rosters = Roster::where('seasons_id', $seasonsID)->get();
        $seasons = Seasons::find($seasonsID);


        return view('roster.index',[
        'rosters' => $rosters,
        'seasons' => $seasons
        ]);
    }

    /**
     * Display a menu for manage this roster
     */
    public function indexRoster(Roster $roster)
    {
        return view('roster.roster-manage' , [
            'roster' => $roster,

        ]);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create($seasonsID)
    {
        $seasons = Seasons::find($seasonsID);

        return view('roster.create',[
            'seasons' => $seasons,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        request()->validate([
            'roster_name' => ['required', 'min:3'],
            'season' => ['required'],
            'age_squad' => ['required'],
            'gender'=> ['required'],
        ]);

        $season=Seasons::where('season_string',request('season'))->first();

        $roster = Roster::create([
            'roster_name' => request('roster_name'),
            'age_squad' => request('age_squad'),
            'gender'=> request('gender'),
            'seasons_id' => $season->id,
            'user_id' => Auth::user()->id
        ]);



//        Mail::to($job->employer->user)->queue(
//            new JobPosted($job)
//        );

        return redirect('/roster/'.$season->id)->withSuccess('Roster created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Roster $roster)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($seasonID,Roster $roster)
    {


        $seasons= Seasons::all();
        return view('roster.edit', [
            'roster' => $roster,
            'seasons' => $seasons
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Roster $roster)
    {

        $roster->update([
            'roster_name' => $request->roster_name,
            'age_squad' => $request->age_squad,
            'gender'=> $request->gender,
            'seasons_id' => Seasons::where('season_string',$request->season)->first()->id,
            'user_id' => Auth::user()->id
        ]);

        return redirect('/roster/' . $roster->id)->withSuccess('Roster updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Roster $roster)
    {

        $players= Players::where('roster_id',$roster->id)->get();
        $players->each->delete();
        $roster->delete();


        return redirect('/roster/' . $roster->id)->withSuccess('Roster deleted successfully!');
    }
}
