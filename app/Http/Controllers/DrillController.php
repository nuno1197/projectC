<?php

namespace App\Http\Controllers;

use App\Models\Drill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DrillController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function drillMenu()
    {
        return view('drill.menu');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drills = Drill::where('user_id', Auth::id())->paginate(10); // Paginate with 10 items per page

        return view('drill.index', [
            'drills' => $drills,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('drill.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $public=0;

        if(request('public'))
        {
            $public=1;
        }
        request()->validate([
            'drill_name' => ['required', 'min:3'],
            'objective' => ['required'],
            'rules' => ['required'],
        ]);



        $drill = Drill::create([
            'drill_name' => request('drill_name'),
            'objective' => request('objective'),
            'rules'=> request('rules'),
            'public'=> $public,
            'number_players'=> request('number_players'),
            'material'=> request('material'),
            'age_squad'=> request('age_squad'),
            'user_id' => Auth::user()->id
        ]);


        return redirect(route('drill.index'))->withSuccess('Drill created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Drill $drill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Drill $drill)
    {
        return view('drill.edit', ['drill' => $drill]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Drill $drill)
    {
        $public=0;

        if(request('public'))
        {
            $public=1;
        }
        request()->validate([
            'drill_name' => ['required', 'min:3'],
            'objective' => ['required'],
            'rules' => ['required'],
        ]);



        $drill->update([
            'drill_name' => request('drill_name'),
            'objective' => request('objective'),
            'rules'=> request('rules'),
            'public'=> $public,
            'number_players'=> request('number_players'),
            'material'=> request('material'),
            'age_squad'=> request('age_squad'),
            'user_id' => Auth::user()->id
        ]);


        return redirect(route('drill.index'))->withSuccess('Drill updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Drill $drill)
    {
        //
    }
}
