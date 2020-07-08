<?php

namespace App\Services\MarketDataProvider;

class CoindeskPriceData extends PriceData
{
    public function getCurrentPrice(): float
    {
        return number_format($this->priceData['bpi']['USD']['rate_float'], 2, '.', '');
    }
}
