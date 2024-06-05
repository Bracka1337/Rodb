<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Game;
use App\Models\Game_ds;

class RobloxController extends Controller
{
    public function getDatastores(Request $request)
    {
        $game = Game::find($request->input('game_id'));
        $universeId = $game->universeId;
        $apikey = $game->roblox_api_key;

        $uri = sprintf("https://apis.roblox.com/datastores/v1/universes/%d/standard-datastores", $universeId);

        $client = new Client();
        $response = $client->request('GET', $uri, [
            'headers' => [
                'x-api-key' => $apikey
            ]
        ]);

        $dataFromRoblox = json_decode($response->getBody()->getContents(), true);

        foreach ($dataFromRoblox['data']?? [] as $datastoreData) {
            Game_ds::create([
                'name' => $datastoreData['name'],
                'game_id' => $game->id,
            ]);
        }

        $savedDatastores = Game_ds::where('game_id', $game->id)->get();
    
        return response()->json($savedDatastores);
    }

    public function getKeysAndValues(Request $request)
    {
        $game = Game::find($request->input('game_id'));
        $universeId = $game->universeId;
        $apikey = $game->roblox_api_key;

        $uri = sprintf("https://apis.roblox.com/datastores/v1/universes/%d/standard-datastores/datastore/entries", $universeId);
        $dsName = $request->input('datastoreName');

        $client = new Client();
        $initialResponse = $client->request('GET', $uri, [
            'headers' => [
                'x-api-key' => $apikey
            ],
            'query' => [
                'datastoreName' => $dsName
            ]
        ]);
        $initialData = json_decode($initialResponse->getBody(), true);
        $keys = $initialData['keys'];

        $values = [];
        foreach ($keys as $key) {
            $valueUri = sprintf("https://apis.roblox.com/datastores/v1/universes/%d/standard-datastores/datastore/entries/entry", $universeId);
            $valueResponse = $client->request('GET', $valueUri, [
                'headers' => [
                    'x-api-key' => $apikey
                ],
                'query' => [
                    'datastoreName' => $dsName,
                    'entryKey' => $key['key']
                ]
            ]);

            $valueData = json_decode($valueResponse->getBody(), true);
            $values[] = ['key' => $key['key'], 'value' => $valueData];
        }

        return response()->json(['keysAndValues' => $values]);
    }
}
