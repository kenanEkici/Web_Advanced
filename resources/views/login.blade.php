<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <title>Login</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
</head>
<body>
{{ HTML::style('css/login.css') }}
<div class="table-title">
    <h3>Events</h3>
</div>
<table id="table">
    <tr>
        <th>Start</th>
        <th>End</th>
        <th>Location</th>
    </tr>
    @foreach($eventList as $event)
        <tr><td>{{$event->start_date}}</td><td>{{$event->end_date}}</td><td>{{$event->location}}</td></tr>
    @endforeach
</table>

</body>
</html>
