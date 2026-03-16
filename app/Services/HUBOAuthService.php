<?php

namespace App\Services;

use GuzzleHttp\Client;

class HUBOAuthService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env("HUB_BASE_URL"),
        ]);        
    }

    public function getAccessToken($scopes=array(0=>"RJ74", 1=>"RJ139", 2=>"RJ140"))
    {    
        $response = $this->client->post("auth/oauth/v2/token", [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => env('OAUTH_CLIENT_ID'),
                'client_secret' => env('OAUTH_CLIENT_SECRET'),
                'scope' => 'RJ74 RJ139 RJ140',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true)['access_token'];
    }
}