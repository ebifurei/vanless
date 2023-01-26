<?php

namespace App\Services\Chirpstack;

use GuzzleHttp\Client;

class BaseClient
{
    public $client;
    public $token;

    public function __construct()
    {
        $this->token = env('CHIRPSTACK_API_KEY');
        $this->client = new Client([
            'base_uri' => 'http://45.32.120.146:8080/',
            'headers' => [
                'Grpc-Metadata-Authorization' => "Bearer {$this->token}"
            ],
            'timeout' => 10,
        ]);
    }
}
