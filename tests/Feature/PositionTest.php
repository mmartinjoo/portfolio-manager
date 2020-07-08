<?php

namespace Tests\Feature;

use App\Position;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PositionTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_positions_group_by_ticker_with_avg_prices()
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

        $data = Position::getDashboardData();

        $this->assertEquals($data['positions']['KO']['ticker'], 'KO');
        $this->assertEquals($data['positions']['KO']['company_name'], 'Coca Cola');
        $this->assertEquals($data['positions']['KO']['average_purchase_price_unit'], 103.33);
        $this->assertEquals($data['positions']['KO']['purchase_price_sum'], 310);
        $this->assertEquals($data['positions']['KO']['quantity'], 3);

        $this->assertEquals(460, $data['portfolioValue']);
    }

    /** @test */
    public function it_only_returns_dividend_type_as_portolio_value()
    {
        $position = new Position;
        $position->ticker = 'KO';
        $position->company_name = 'Coca Cola';
        $position->purchase_price_unit = 100;
        $position->quantity = 2;
        $position->purchase_price_sum = 200;
        $position->fee = 7.99;
        $position->type = 'dividend';
        $position->save();

        $position = new Position;
        $position->ticker = 'IBM';
        $position->company_name = 'IBM';
        $position->purchase_price_unit = 200;
        $position->quantity = 2;
        $position->purchase_price_sum = 400;
        $position->fee = 7.99;
        $position->type = 'dividend';
        $position->save();

        $position = new Position;
        $position->ticker = 'SPY5';
        $position->company_name = 'SPDR SP500 ETF';
        $position->purchase_price_unit = 100;
        $position->quantity = 10;
        $position->purchase_price_sum = 1000;
        $position->fee = 7.99;
        $position->type = 'etf';
        $position->save();

        $sum = Position::getSumBySubtype('dividend');

        $this->assertEquals(600.00, $sum);
    }
}
