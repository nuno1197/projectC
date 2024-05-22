<?php

namespace App\Http\Controllers;

use App\Models\Practice;
use Illuminate\Http\Request;
use App\Models\Roster;
use Illuminate\Support\Facades\Auth;

class PracticeController extends Controller
{

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

        $practice = Practice::create([
            'pratice_number' => request('pratice_number'),
            'pratice_location' => request('pratice_location'),
            'start_time'=> request('start_time'),
            'end_time' => request('end_time'),
            'user_id' => Auth::user()->id,
            'roster_id' => request('roster_id'),
        ]);

        return redirect(route('events.index', ['roster' => request('roster_id')]))->withSuccess('Practice created successfully!');
    }

    /**
     * Edit Practice
     */
    public function edit(Practice $practice){

        $rosters=Roster::find($practice->roster_id);

        return view('practices.edit',[
            'practices' => $practice,
            'rosters' => $rosters
        ]);

    }

    /**
     * Update Practice
     */
    public function update(Request $request, Practice $practice){

        dd($request->all());

        $practice->update([
            'pratice_number' => $request->pratice_number,
            'pratice_location' => $request->pratice_location,
            'start_time'=> $request->start_time,
            'end_time'=> $request->end_time,
            'comments'=> $request->comments,
            'roster_id' => $request->roster_id,
            'user_id' => Auth::user()->id
        ]);

        return redirect('/events/' . $request->roster_id)->withSuccess('Practice updated successfully!');

    }
}
