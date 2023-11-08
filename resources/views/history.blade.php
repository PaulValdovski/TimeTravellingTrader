@extends('layout')
@section('title','History')
<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }


        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
            flex: 1;
            margin: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
@section('content')
<table style="color: #fff;" >
    <tr>
        <th>Query Time</th>
        <th>Buy Date</th>
        <th>Sell Date</th>
        <th>Stock</th>
        <th>Return</th>
    </tr>
    @foreach($History as $record)
        <tr>
            <td>{{ $record->query_date }}</td>
            <td>{{ $record->start_date }}</td>
            <td>{{ $record->end_date }}</td>
            <td>{{ $record->stock }}</td>
            <td>{{ $record->return }}%</td>
        </tr>
    @endforeach
</table>

{{ $History->links() }}

@endsection