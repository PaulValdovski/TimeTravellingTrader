@extends('layout')
@section('title','Time Travelling Trader')
@section('content')
<div class="container" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh;">
    <div>
        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Select Date Interval</h1>
    </div>
    <form action="{{ route('process-date-interval') }}" method="post" style="display: flex; flex-direction: column; align-items: center;">
        @csrf
        <div class="form-group" style="margin-top: 10px;">
            <label for="start_date" class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Start Date:</label>
            <input type="text" id="start_date" name="start_date" class="form-control" required>
        </div>
        <div class="form-group" style="margin-top: 10px;">
            <label for="end_date" class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">End Date:</label>
            <input type="text" id="end_date" name="end_date" class="form-control" style="margin-left: 7px;" required>
        </div>
        <button type="submit" class="text-xl font-semibold text-gray-900 dark:text-white btn btn-primary" style="margin-top: 5px; margin-left: 20%;">Submit</button>
    </form>
</div>




<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    flatpickr("#start_date", {
        enableTime: false,
        dateFormat: "Y-m-d",
        minDate: "1962-01-03",
        maxDate: "2023-10-26",
        disable: [
            function(date) {
                return date.getDay() === 6 || date.getDay() === 0;
            }
        ],
        onChange: function(selectedDates, dateStr, instance) {
            const minEndDate = new Date(dateStr);
            minEndDate.setDate(minEndDate.getDate() + 1);
            flatpickr("#end_date", {
                enableTime: false,
                dateFormat: "Y-m-d",
                minDate:  minEndDate.toISOString().split('T')[0],
                maxDate: "2023-10-27",
                disable: [
                    function(date) {
                        return date.getDay() === 6 || date.getDay() === 0;
                    }
                ]
            });
        }
    });
</script>
@endsection

