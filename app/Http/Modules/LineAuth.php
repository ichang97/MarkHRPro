<?php

namespace App\Http\Modules;
use GuzzleHttp\Client;
use stdClass;

class LineAuth {
    public function __construct(){
        $this->line_channel_id = config('app.line_channel_id');
        $this->line_channel_secret = config('app.line_channel_secret');

        $this->apiBaseUrl = 'https://access.line.me/oauth2/v2.1';
        $this->authorizeUrl = 'https://access.line.me/oauth2/v2.1/authorize';
        $this->accessTokenUrl = 'https://api.line.me/oauth2/v2.1/token';

    }

    public function test(){
        return true;
    }

    public function getAccessToken($auth){
        $client = new Client;
        $response = $client->request('POST', $this->accessTokenUrl, [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $auth,
                'redirect_uri' => config('app.line_callback_url'),
                'client_id' => config('app.line_channel_id'),
                'client_secret' => config('app.line_channel_secret')
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        
        return $result;
    }
}
