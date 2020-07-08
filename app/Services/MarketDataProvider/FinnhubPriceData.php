<?php

namespace App\Services\MarketDataProvider;

use Illuminate\Support\Arr;

class FinnhubPriceData extends PriceData
{
    public function getCurrentPrice(): float
    {
        return Arr::get($this->priceData, 'c', 0);
    }
}
