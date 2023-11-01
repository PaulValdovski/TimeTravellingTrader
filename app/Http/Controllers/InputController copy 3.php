<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class InputController extends Controller
{
    public function processDateInterval(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|date_format:Y-m-d|after_or_equal:1962-01-03|before_or_equal:2023-10-27',
            'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date|before_or_equal:2023-10-27',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');


            // Query the "stock" table to get the prices for start_date and end_date
    $startPrice = DB::table('stock')->where('date', $startDate)->value('price');
    $endPrice = DB::table('stock')->where('date', $endDate)->value('price');

    // Calculate the price difference
    if ($startPrice != 0) {
        $priceIncrease = ($endPrice / $startPrice) * 100;
    } else {
        $priceIncrease = 0; 
    }


    // Query the "stock" table to get a list of unique stocks
    $uniqueStocks = DB::table('stock')->select('stock')->distinct()->pluck('stock');

    $maxStartPrice = 0;
    $maxEndPrice = 0;
    $maxPriceIncrease = 0;
    $maxStock='';
    $earliestDate=$startDate;
    $latestDate=$endDate;


    foreach ($uniqueStocks as $stock) {
        // Query the "stock" table for each stock to get the prices for start_date and end_date
        $earliestDate = DB::table('stock')
            ->where('stock', $stock)
            ->where('date', '>=', $startDate)
            ->orderBy('price', 'asc') 
            ->value('date');
            
        $latestDate = DB::table('stock')
            ->where('stock', $stock)
            ->where('date', '>', $earliestDate)
            ->where('date', '<=', $endDate)
            ->orderBy('price', 'desc') 
            ->value('date');



        $startPrice = DB::table('stock')
            ->where('stock', $stock)
            ->where('date', $earliestDate)
            ->value('price');

        $endPrice = DB::table('stock')
            ->where('stock', $stock)
            ->where('date', $latestDate)
            ->value('price');


        // Calculate the price difference (with safeguards against division by zero)
        if ($startPrice != 0) {
            $priceIncrease = ($endPrice / $startPrice) * 100 - 100;
        } else {
            $priceIncrease = 0;
        }

        if ($priceIncrease > $maxPriceIncrease) {
            $maxStartPrice = $startPrice;
            $maxEndPrice = $endPrice;
            $maxPriceIncrease = $priceIncrease;
            $maxStock=$stock;
            $maxEarliestDate=$earliestDate;
            $maxLatestDate=$latestDate;
        }
        $earliestDate=$startDate;
        $latestDate=$endDate;
        
    }

        // Insert data into the "history" table for authenticated users
        if (Auth::check()) {
            $userId = Auth::id();
            $queryDate = Carbon::now()->toDateTimeString();

            DB::table('history')->insert([
                'user_id' => $userId,
                'query_date' => $queryDate,
                'start_date' => $maxEarliestDate,
                'end_date' => $maxLatestDate,
                'stock' => $maxStock,
                'return' => $maxPriceIncrease,
            ]);
        }

    // Pass the data to the "result" view
    return view('result', [
        'startDate' => $startDate,
        'endDate' => $endDate,
        'startPrice' => $maxStartPrice,
        'endPrice' => $maxEndPrice,
        'stock' => $maxStock,
        'priceIncrease' => $maxPriceIncrease,
        'earliestDate' => $maxEarliestDate,
        'latestDate' => $maxLatestDate,
    ]);

    }
}
