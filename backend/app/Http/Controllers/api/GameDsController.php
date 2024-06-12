<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gameds;
use App\Http\Resources\GameDsResource;

class GameDsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return GameDsResource::collection(Gameds::where('game_id', $request->input('game_id'))->get());
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

        $game_Ds = Gameds::create($validated);

        return new GameDsResource($game_Ds);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gameds $game_Ds)
    {
        return new GameDsResource($game_Ds);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gameds $game_Ds)
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
    public function destroy(Gameds $game_Ds)
    {
        $game_Ds->delete();
        return new GameDsResource($game_Ds);
    }
}
