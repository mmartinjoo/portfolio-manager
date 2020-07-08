<?php

namespace App;

use App\Services\MarketDataProvider\MarketDataProviderFactory;
use App\Services\MarketDataService;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public static function getDashboardData(MarketDataProviderFactory $factory)
    {
        $positions = Position::all();
        $hashMap = [];
        $portfolioValue = 0;

        foreach ($positions as $position) {
            $provider = $factory->create($position);

            if (!isset($hashMap[$position->ticker])) {
                $hashMap[$position->ticker] = [
                    'ticker'                => $position->ticker,
                    'company_name'          => $position->company_name,
                    'quantity'              => 0,
                    'purchase_price_sum'    => 0,
                    'market_price'          => ($provider->getPriceData($position->ticker))->getCurrentPrice()
                ];
            }

            $hashMap[$position->ticker]['quantity'] += $position->quantity;
            $hashMap[$position->ticker]['purchase_price_sum'] += ($position->quantity * $position->purchase_price_unit);
        }

        foreach ($hashMap as $ticker => $data) {
            $hashMap[$ticker]['average_purchase_price_unit'] =
                number_format($data['purchase_price_sum'] / $data['quantity'], 2);

            $portfolioValue += $data['purchase_price_sum'];
        }

        return [
            'positions'         => $hashMap,
            'portfolioValue'    => number_format($portfolioValue, 2, '.', '')
        ];
    }

    public static function getSumBySubtype($subtype)
    {
        return Position::where('subtype', $subtype)->get()->pluck('purchase_price_sum')->sum();
    }
}
