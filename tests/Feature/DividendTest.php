<?php

namespace Tests\Feature;

use App\Dividend;
use App\Position;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DividendTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_dividend_payout_group_by_ticker()
    {
        $position = new Position;
        $position->ticker = 'KO';
        $position->company_name = 'Coca Cola';
        $position->purchase_price_unit = 100;
        $position->quantity = 2;
        $position->purchase_price_sum = 200;
        $position->fee = 7.99;
        $position->save();

        $position1 = new Position;
        $position1->ticker = 'KO';
        $position1->company_name = 'Coca Cola';
        $position1->purchase_price_unit = 110;
        $position1->quantity = 1;
        $position1->purchase_price_sum = 110;
        $position1->fee = 7.99;
        $position1->save();

        $position2 = new Position;
        $position2->ticker = 'IBM';
        $position2->company_name = 'INternational Business Machine';
        $position2->purchase_price_unit = 150;
        $position2->quantity = 1;
        $position2->purchase_price_sum = 150;
        $position2->fee = 7.99;
        $position2->save();

        $dividend = new Dividend;
        $dividend->ticker = 'KO';
        $dividend->amount_unit = 1;
        $dividend->quantity = 3;
        $dividend->amount_sum = 3;
        $dividend->company_name = 'Coca Cola';
        $dividend->save();

        $dividend = new Dividend;
        $dividend->ticker = 'IBM';
        $dividend->amount_unit = 2;
        $dividend->quantity = 1;
        $dividend->amount_sum = 2;
        $dividend->company_name = 'IBM';
        $dividend->save();

        $data = Dividend::getDashboardData();

        $this->assertEquals($data['sumPayout'], 5);

        $this->assertEquals($data['dividends']['KO']['purchase_price_sum'], 310);
        $this->assertEquals($data['dividends']['KO']['payout'], 3);
        $this->assertEquals($data['dividends']['KO']['yield'], 0.97);

        $this->assertEquals($data['dividends']['IBM']['purchase_price_sum'], 150);
        $this->assertEquals($data['dividends']['IBM']['payout'], 2);
        $this->assertEquals($data['dividends']['IBM']['yield'], 1.33);
    }
}
