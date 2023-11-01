@extends('layout')
@section('title','About')
@section('content')

<div class="container">
    <h1>About us</h1>
    <p>This web application was made for a university project. It allows the user to see which stock performed the best in a given time interval.</p>
    <p>It was created using the Laravel framework. To make it run, you will have to install Laravel and import the DATABASE FILE.sql as the database "ttt".</p>
    <p>The current algorithm for finding the best performing stock can be improved. Also the data from the database is limited to the S&P500 top 100 companies. Despite all that, it is still fun to use, at least for a few minutes. Enjoy!</p>
</div>            

@endsection
