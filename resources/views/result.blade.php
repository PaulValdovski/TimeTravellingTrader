@extends('layout')
@section('title','Result')
@section('content')

<div class="container">
    <h1>Best performing stock between {{ $startDate }} and {{ $endDate }}:</h1>
    <p>Stock ticker symbol: {{ $stock }}</p>
    <p>Buy date: {{ $earliestDate }}</p>
    <p>Start Date Price: ${{ number_format($startPrice, 2) }}</p>
    <p>Sell date: {{ $latestDate }}</p>
    <p>End Date Price: ${{ number_format($endPrice, 2) }}</p>
    <p>Profit: {{ number_format($priceIncrease, 2) }}%</p>

    <a href="{{ route('home') }}" class="mt-6 text-xl font-semibold text-gray-900 dark:text-white btn btn-primary"  style="margin-top: 10px;">Try another interval</a>
</div>

@endsection