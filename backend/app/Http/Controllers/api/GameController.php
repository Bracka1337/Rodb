<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;

        return GameResource::collection(Game::where('user_id', $user_id)->get());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;


        $validated = $request->validate([
            'name' => 'required',
            'universeId' => 'required|integer',
            'roblox_api_key' => 'required',
        ]);


        $data = [
            'name' => $validated['name'],
            'universeId' => $validated['universeId'],
            'roblox_api_key' => $validated['roblox_api_key'],
            'user_id' => $user_id,
        ];

        $game = Game::create($data);

        return new GameResource($game);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        
        return new GameResource($game);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'name' => 'required',
            'universeId' => 'required|integer',
            'user_id' => 'required|exists:users,id',
        ]);

        $game->update($validated);

        return new GameResource($game);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();
        return new GameResource($game);
    }
}
