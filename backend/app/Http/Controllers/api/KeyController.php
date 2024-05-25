<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Key;
use App\Http\Resources\KeyResource;

class KeyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return KeyResource::collection(Key::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required',
            'value' => 'required',
            'game_ds_id' => 'required|exists:game__ds,id',
        ]);
        $key = Key::create($validated);
        return new KeyResource($key);
    }

    /**
     * Display the specified resource.
     */
    public function show(Key $key)
    {
        return new KeyResource($key);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Key $key)
    {
        $validated = $request->validate([
            'key' => 'required',
            'value' => 'required',
            'game_ds_id' => 'required|exists:game_ds,id',
        ]);
        $key->update($validated);
        return new KeyResource($key);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Key $key)
    {
        $key->delete();
        return new KeyResource($key);
    }
}
