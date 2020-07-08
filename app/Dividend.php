<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dividend extends Model
{
    public static function getDashboardData()
    {
        $positionData = Position::getDashboardData();

        $dividends = Dividend::all();
        $hashMap = [];
        $sumPayout = 0;

        foreach ($dividends as $dividend) {
            if (!isset($hashMap[$dividend->ticker])) {
                $hashMap[$dividend->ticker] = [
                    'ticker'                => $dividend->ticker,
                    'company_name'          => $dividend->company_name,
                    'purchase_price_sum'    => $positionData['positions'][$dividend->ticker]['purchase_price_sum'],
                    'payout'                => 0
                ];
            }

            $payout = $dividend->amount_sum && $dividend->amount_sum != 0
                ? $dividend->amount_sum
                : $dividend->amount_unit * $dividend->quantity;

            $hashMap[$dividend->ticker]['payout'] += $payout;
        }

        foreach ($hashMap as $ticker => $data) {
            $hashMap[$ticker]['yield'] = number_format(($data['payout'] / $data['purchase_price_sum']) * 100, 2, '.', '');
            $sumPayout += $data['payout'];
        }

        return [
            'dividends'         => $hashMap,
            'portfolioValue'    => number_format(Position::getSumBySubtype('dividend'), 2, '.', ''),
            'sumPayout'         => number_format($sumPayout, 2, '.', ''),
            'yield'             => number_format(($sumPayout / $positionData['portfolioValue']) * 100, 2, '.', '')
        ];
    }
}
