<?php

namespace App\Services\MarketDataProvider;

class ExchangeRatePriceData extends PriceData
{
    public function getCurrentPrice(): float
    {
        return $this->priceData['rates']['USD'];
    }
}
