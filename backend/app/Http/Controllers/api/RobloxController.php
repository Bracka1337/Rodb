<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Game;
use App\Models\Gameds;
use App\Models\Key;


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

        foreach ($dataFromRoblox['datastores'] as $datastore) {
            $existingDatastore = Gameds::firstOrCreate(
                ['name' => $datastore['name'], 'game_id' => $request->input('game_id')],
                ['name' => $datastore['name'], 'game_id' => $request->input('game_id')]
            );
        }

        $dataFromDB = Gameds::where('game_id', $request->input('game_id'))->get();

        return response()->json($dataFromDB);
    }


    public function getKeysAndValues(Request $request)
    {
        $game = Game::find($request->input('game_id'));
        $universeId = $game->universeId;
        $apikey = $game->roblox_api_key;

        
        $uri = sprintf("https://apis.roblox.com/datastores/v1/universes/%d/standard-datastores/datastore/entries", $universeId);
        $dsName = $request->input('datastoreName');
        
        $gamedsRecord = Gameds::where('name', $dsName)->where('game_id', $request->input('game_id'))->first();
        $gamedsId = $gamedsRecord->id?? null;

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

            $existingDatastore = Key::firstOrCreate(
                ['key' => $key['key'], 'game_ds_id' => $gamedsId],
                ['key' => $key['key'], 'value' => $valueData, 'game_ds_id' => $gamedsId]
            );

        }

        $dataFromDB = Key::where('game_ds_id', $gamedsId)->get();

        return response()->json($dataFromDB);
    }
}
