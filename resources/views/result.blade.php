@extends('layout')
@section('title','Result')
@section('content')

<div class="container" style="text-align: center;">
    <h1 style="color: #fff; font-size: 25px;">Best performing stock between {{ $startDate }} and {{ $endDate }}:</h1>
    <p style="color: #fff; font-size: 20px;" >Stock ticker symbol: {{ $stock }}</p>
    <p style="color: #fff; font-size: 20px;" >Buy date: {{ $earliestDate }}</p>
    <p style="color: #fff; font-size: 20px;" >Start Date Price: ${{ number_format($startPrice, 2) }}</p>
    <p style="color: #fff; font-size: 20px;" >Sell date: {{ $latestDate }}</p>
    <p style="color: #fff; font-size: 20px;" >End Date Price: ${{ number_format($endPrice, 2) }}</p>
    <p style="color: #fff; font-size: 20px;" >Profit: {{ number_format($priceIncrease, 2) }}%</p>

    <a href="{{ route('home') }}" style="text-align: center; color: #fff; font-size: 35px;">Try another interval</a>
</div>

@endsection