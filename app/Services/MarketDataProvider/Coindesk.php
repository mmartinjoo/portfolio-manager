<?php

namespace App\Services\MarketDataProvider;

class Coindesk extends MarketDataProvider
{
    const BASE_URL = 'https://api.coindesk.com/v1/';

    public function getPriceData(string $ticker): PriceData
    {
        $response = $this->httpClient->get(static::BASE_URL . 'bpi/currentprice.json');
        $priceData = json_decode($response->getBody(), true);

        return new CoindeskPriceData($priceData);
    }
}
