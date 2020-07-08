<?php

namespace App\Services\MarketDataProvider;

use GuzzleHttp\Client;

class ExchangeRate extends MarketDataProvider
{
    const BASE_URL = 'https://api.exchangeratesapi.io/';

    public function getPriceData(string $ticker): PriceData
    {
        $response = $this->httpClient->get(static::BASE_URL . 'latest');
        $priceData = json_decode($response->getBody(), true);

        return new ExchangeRatePriceData($priceData);
    }
}
