<?php

namespace App\Services\MarketDataProvider;

use App\Position;
use GuzzleHttp\Client;

class MarketDataProviderFactory
{
    private $httpClient;

    function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function create(Position $position): MarketDataProvider
    {
        if ($position->type == 'currency' && $position->subtype == 'currency') {
            return new ExchangeRate($this->httpClient);
        }

        switch ($position->type) {
            case 'stock': return new Finnhub($this->httpClient);
            case 'currency': return new Coindesk($this->httpClient);
        }
    }
}
