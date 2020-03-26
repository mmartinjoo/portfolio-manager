<?php

namespace App\Http\Controllers;

use App\Dividend;
use App\Position;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', ['data' => Position::getDashboardData()]);
    }

    public function dividend()
    {
        return view('dividend', ['data' => Dividend::getDashboardData()]);
    }
}
