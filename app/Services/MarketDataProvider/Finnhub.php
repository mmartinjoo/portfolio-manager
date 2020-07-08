<?php

namespace App\Services\MarketDataProvider;

use GuzzleHttp\Client;

class Finnhub extends MarketDataProvider
{
    const BASE_URL = 'https://finnhub.io/api/v1/';
    const API_KEY = 'bpufdk7rh5rbbhoiik70';

    public function getPriceData(string $ticker): PriceData
    {
        $response = $this->httpClient->get(static::BASE_URL . '/quote?symbol=' . $ticker . '&token=' . static::API_KEY);
        $priceData = json_decode($response->getBody(), true);

        return new FinnhubPriceData($priceData);
    }
}
