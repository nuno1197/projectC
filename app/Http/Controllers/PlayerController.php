<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Roster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Roster $roster)
    {
        $players= Player::where('roster_id',$roster->id)->get();


        return view('players.index',[
            'rosters' => $roster,
            'players' => $players
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($rosterID)
    {

        return view('players.create',[
            'rosters' => $roster,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $photo_path="";

        $rosterID=request('roster_id');
        request()->validate([
            'name' => ['required', 'min:3'],
            'birth_date' => ['required'],
            'jersey_number' => ['required'],
        ]);


        // Check if file is uploaded
        if ($request->hasFile('photo_path')) {
            $image = $request->file('photo_path');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Move the uploaded file to the destination folder
            $image->move(public_path('images/player_photos/'), $imageName);

            // Set the photo_path to the relative path
            $photo_path = 'images/player_photos/' . $imageName;
        } else {
            // No file uploaded
            $photo_path = null;
        }



        $players = Player::create([
            'name' => request('name'),
            'birth_date' => request('birth_date'),
            'position' => request('position'),
            'jersey_number' => request('jersey_number'),
            'photo_path' => $photo_path,
            'player_notes' => request('player_notes'),
            'roster_id' => $rosterID,
        ]);


        return redirect('/players/'. $rosterID)->withSuccess('Player created successfully!');


    }

    /**
     * Display the specified resource.
     */
    public function show(Player $players)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $players)
    {


        return view('players.edit',[
            'player' => $players
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $players)
    {

        $photo_path="";
        // Check if file is uploaded
        if ($request->hasFile('photo_path')) {
            $image = $request->file('photo_path');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Move the uploaded file to the destination folder
            $image->move(public_path('images/player_photos/'), $imageName);

            // Set the photo_path to the relative path
            $photo_path = 'images/player_photos/' . $imageName;
        } else {
            // No file uploaded
            $photo_path = $players->photo_path;
        }


        $players->update([
            'name' => request('name'),
            'birth_date' => request('birth_date'),
            'position' => request('position'),
            'jersey_number' => request('jersey_number'),
            'photo_path' => $photo_path,
            'player_notes' => request('player_notes'),
            'roster_id' => Player::where('roster_id',$players->roster_id)->first()->roster_id,
        ]);

        return redirect('/players/edit/' . $players->id)->withSuccess('Player Profile updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $players)
    {
        $rosterID= $players->roster_id;


        // Check if the file exists
        if (Storage::exists($players->photo_path)) {
            // Delete the file
            Storage::delete($players->photo_path);
        }
        $players->delete();
        return redirect('players/' .$rosterID)->withSuccess('Player deleted successfully!');
    }
}
