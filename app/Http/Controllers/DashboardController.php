<?php

namespace App\Http\Controllers;

use App\Dividend;
use App\Position;
use App\Services\MarketDataProvider\MarketDataProviderFactory;
use GuzzleHttp\Client;

class DashboardController extends Controller
{
    protected $marketDataProviderFactory;

    function __construct(MarketDataProviderFactory $marketDataproviderFactory)
    {
        $this->marketDataProviderFactory = $marketDataproviderFactory;
    }

    public function index()
    {
        return view('dashboard', ['data' => Position::getDashboardData($this->marketDataProviderFactory)]);
    }

    public function dividend()
    {
        return view('dividend', ['data' => Dividend::getDashboardData()]);
    }
}
