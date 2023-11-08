
@extends('layout')
@section('title','About')
@section('content')

<div class="container" style="text-align: center;">
    <h1 style="color: #fff; font-size: 40px;">About Us</h1>
    <p style="color: #fff; font-size: 24px;">This web application was made for a university project. It allows the user to see which stock performed the best in a given time interval. It was created using the Laravel framework.</p>
    <p style="color: #fff; font-size: 24px;">The current algorithm for finding the best performing stock can be improved. Also the data from the database is limited to the S&P500 top 100 companies. Despite all that, it is still fun to use, at least for a few minutes. Enjoy!</p>

</div>

@endsection
