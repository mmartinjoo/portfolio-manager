<?php

namespace App\Services\MarketDataProvider;

use GuzzleHttp\Client;

abstract class MarketDataProvider
{
    protected $httpClient;

    function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    abstract public function getPriceData(string $ticker): PriceData;
}
