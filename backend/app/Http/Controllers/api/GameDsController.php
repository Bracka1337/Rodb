<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game_Ds;
use App\Http\Resources\GameDsResource;

class GameDsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return GameDsResource::collection(Game_Ds::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'game_id' => 'required|exists:games,id',
        ]);

        $game_Ds = Game_Ds::create($validated);

        return new GameDsResource($game_Ds);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game_Ds $game_Ds)
    {
        return new GameDsResource($game_Ds);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game_Ds $game_Ds)
    {
        $validated = $request->validate([
            'name' => 'required',
            'game_id' => 'required|exists:games,id',
        ]);
        $game_Ds->update($validated);
        return new GameDsResource($game_Ds);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game_Ds $game_Ds)
    {
        $game_Ds->delete();
        return new GameDsResource($game_Ds);
    }
}
