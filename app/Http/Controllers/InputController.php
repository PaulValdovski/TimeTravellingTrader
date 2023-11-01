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


        $startPrice = DB::table('stock')->where('date', $startDate)->value('price');
        $endPrice = DB::table('stock')->where('date', $endDate)->value('price');

        if ($startPrice != 0) {
            $priceIncrease = ($endPrice / $startPrice) * 100;
        } else {
            $priceIncrease = 0; 
        }


        $uniqueStocks = DB::table('stock')->select('stock')->distinct()->pluck('stock');

        $maxStartPrice = 0;
        $maxEndPrice = 0;
        $maxPriceIncrease = 0;
        $maxStock='';
        $earliestDate=$startDate;
        $latestDate=$endDate;


        foreach ($uniqueStocks as $stock) {
            $startPrice = DB::table('stock')
                ->where('date', $startDate)
                ->where('stock', $stock)
                ->value('price');

            if ($startPrice == 0) {
                $earliestDate = DB::table('stock')
                    ->where('stock', $stock) 
                    ->where('date', '>=', $startDate)
                    ->orderBy('date', 'asc')
                    ->value('date');

                $startPrice = DB::table('stock')
                    ->where('stock', $stock) 
                    ->where('date', $earliestDate)
                    ->value('price');
            }


            $endPrice = DB::table('stock')
                ->where('date', $endDate)
                ->where('stock', $stock)
                ->value('price');

            if ($endPrice == 0) {
                $latestDate = DB::table('stock')
                    ->where('stock', $stock) 
                    ->where('date', '<=', $endDate)
                    ->orderBy('date', 'desc')
                    ->value('date');

                $endPrice = DB::table('stock')
                    ->where('stock', $stock) 
                    ->where('date', $latestDate)
                    ->value('price');
            }


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
