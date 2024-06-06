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
        dd($request->all());
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Drill $drill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Drill $drill)
    {
        //
    }
}
