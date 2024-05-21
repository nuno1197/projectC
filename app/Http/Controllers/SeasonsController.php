<?php

namespace App\Http\Controllers;

use App\Models\Seasons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeasonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seasons=Seasons::all();

        return view('landing',[
            'seasons' => $seasons,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Seasons $seasons)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seasons $seasons)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seasons $seasons)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seasons $seasons)
    {
        //
    }
}
