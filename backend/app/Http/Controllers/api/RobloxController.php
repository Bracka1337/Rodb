<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Game;

class RobloxController extends Controller
{
    public function getDatastores(Request $request)
    {
        $game = Game::find($request->input('game_id'));
        $universeId = $game->universeId;
        $apikey = $game->roblox_api_key;
        dd($universeId, $apikey);

        $uri = sprintf("https://apis.roblox.com/datastores/v1/universes/%d/standard-datastores", $universeId);

        $client = new Client();
        $response = $client->request('GET', $uri, [
            'headers' => [
                'x-api-key' => $apikey
            ]
        ]);

        $dataFromRoblox = json_decode($response->getBody()->getContents(), true);

        return response()->json($dataFromRoblox);
    }

    // public function getKeys(Request $request) {
    //     $client = new Client();
    //     $response = $client->request('GET', 'https://apis.roblox.com/datastores/v1/universes/5697506348/standard-datastores/datastore/entries', [
    //         'headers' => [
    //             'x-api-key' => 'RGZwK37KMEeGWQ/xn5gSZVHx6yrp8r3IBp38EMqHSNXhixUT'
    //         ],
    //         'query' => [
    //             'datastoreName' => 'PlayerInfoDev'
    //         ]
    //     ]);
    // }

    // public function getKeyValue(Request $request) {
    //     $client = new Client();
    //     $response = $client->request('GET', 'https://apis.roblox.com/datastores/v1/universes/5697506348/standard-datastores/datastore/entries', [
    //         'headers' => [
    //             'x-api-key' => 'RGZwK37KMEeGWQ/xn5gSZVHx6yrp8r3IBp38EMqHSNXhixUT'
    //         ],
    //         'query' => [
    //             'datastoreName' => 'PlayerInfoDev'
    //         ]
    //     ]);
    // }

    // public function fetchMultipleKeys() {
        
    // }


    // public function fetchData(Request $request) {

    // }
}
