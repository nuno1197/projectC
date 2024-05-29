<?php

namespace App\Http\Controllers;

use App\Models\Practice;
use Illuminate\Http\Request;
use App\Models\Roster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            'practice_number' => ['required'],
            'practice_location' => ['required'],
            'start_time' => 'required|date',
            'end_time'=> 'required|date',
        ]);


        $practice = Practice::create([
            'practice_number' => request('practice_number'),
            'practice_location' => request('practice_location'),
            'start_time'=> request('start_time'),
            'end_time' => request('end_time'),
            'user_id' => Auth::user()->id,
            'roster_id' => request('roster_id'),
        ]);

        return redirect(route('planning.events', ['roster' => request('roster_id')]))->withSuccess('Practice created successfully!');
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


        $practice->update([
            'practice_number' => $request->pratice_number,
            'practice_location' => $request->pratice_location,
            'start_time'=> $request->start_time,
            'end_time'=> $request->end_time,
            'comments'=> $request->comments,
            'roster_id' => $request->roster_id,
            'user_id' => Auth::user()->id
        ]);

        return redirect('/events/' . $request->roster_id)->withSuccess('Practice updated successfully!');

    }
}
