<?php

namespace App\Clients;

// use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class FdClient extends Client
{
    public function __construct()
    {
        return parent::__construct([

            'headers' => ['Ocp-Apim-Subscription-Key' => env('FANTASY_DATA_STATS_KEY')],

        ]);
    }
}
