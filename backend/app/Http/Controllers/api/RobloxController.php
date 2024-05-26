<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class RobloxController extends Controller
{
    public function getData(Request $request)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://apis.roblox.com/datastores/v1/universes/5697506348/standard-datastores', [
            'headers' => [
                'x-api-key' => 'RGZwK37KMEeGWQ/xn5gSZVHx6yrp8r3IBp38EMqHSNXhixUT'
            ]
        ]);

        $dataFromRoblox = json_decode($response->getBody()->getContents(), true);

        return response()->json($dataFromRoblox);
    }
}
