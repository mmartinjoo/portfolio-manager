<?php

namespace App\Services\MarketDataProvider;

abstract class PriceData
{
    protected $priceData;

    function __construct(array $priceData)
    {
        $this->priceData = $priceData;
    }

    abstract public function getCurrentPrice(): float;
}
