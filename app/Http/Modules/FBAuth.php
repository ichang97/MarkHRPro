<?php

namespace App\Http\Modules;
use GuzzleHttp\Client;
use stdClass;

class FBAuth{
    public function __construct(){
        $this->fb_api_endpoint = config('app.fb_api_endpoint');
    }

    public function test(){
        return true;
    }

    public function getFbAccount(){
        $client = new Client;
        $res = $client->get(config('app.fb_api_endpoint') . 'me?fields=id,name,email');

        $result = json_decode($res->getBody()->getContents(), true);
        
        return $result;
    }
}
