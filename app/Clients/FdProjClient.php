<?php

namespace App\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FdProjClient extends Client
{
    public function __construct()
    {
        return parent::__construct([

            'headers' => ['Ocp-Apim-Subscription-Key' => 'e87658c9fd5845809a5687d36cebf49c'],

        ]);
    }
}
