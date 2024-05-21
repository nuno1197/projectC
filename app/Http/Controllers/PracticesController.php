<?php

namespace App\Http\Controllers;

use App\Models\Practices;
use Illuminate\Http\Request;
use App\Models\Roster;
use Illuminate\Support\Facades\Auth;

class PracticesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Roster $roster)
    {
        $events = [];

        $pratices = Practices::where("roster_id",$roster->id)
            ->get();

        foreach ($pratices as $pratice) {
            $events[] = [
                'title' => 'Practice Nr:'. $pratice->pratice_number . " @ " .$pratice->pratice_location,
                'start' => $pratice->start_time,
                'end' => $pratice->end_time,
                'url' => '#',
            ];
        }

        return view('practices.index', compact('events'),['roster'=>$roster]);
    }

    /**
     * Create a Practice View
     */
    public function create($roster_id){

        $rosters = Roster::find($roster_id);

        return view('practices.create',compact('rosters'));
    }

    /**
     * Store Practice
     */
    public function store(Request $request){

        request()->validate([
            'pratice_number' => ['required'],
            'pratice_location' => ['required'],
            'start_date' => ['required'|'date'],
            'end_date'=> ['required' | 'date'],
        ]);

        $rosters = Roster::find(request('roster_id'));

        $practice = Practices::create([
            'pratice_number' => request('pratice_number'),
            'pratice_location' => request('pratice_location'),
            'start_time'=> request('start_time'),
            'end_time' => request('end_time'),
            'user_id' => Auth::user()->id,
            'roster_id' => request('roster_id'),
        ]);

        return redirect(route('practices.index', ['roster' => request('roster_id')]))->withSuccess('Practice created successfully!');
    }
}
