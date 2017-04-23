<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <script
            src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{!! asset('js/events.js') !!}"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
</head>
<body>
{{ HTML::style('magicLayout.css') }}
<div class="table-title">
    <h3>Events</h3>
</div>
<table id="table">
    <tr>
        <th>Organiser</th>
        <th>Title</th>
        <th>Description</th>
        <th>Start</th>
        <th>End</th>
        <th>Location</th>
        <th>Guests</th>
    </tr>
    @foreach($eventList as $event)
        <tr><td>{{$event->organiser}}</td><td>{{$event->title}}</td><td>{{$event->description}}</td><td>{{$event->start_date}}</td><td>{{$event->end_date}}</td><td>{{$event->location}}</td><td>{{$event->invited}}</td><td><input type="button" class="magicButton"  onclick="deleteEvent(this.id)" id={{$event->event_id}} value="Verwijder"></td></tr>
    @endforeach
</table>

</table>
<div class="table-title">
    <h3>Voeg een event toe of update</h3>
</div>
    {{ csrf_field() }}
    <table id="table2">
        <tr>
            <th>Organiser</th>
            <th>Title</th>
            <th>Description</th>
            <th>Start date</th>
            <th>End date</th>
            <th>Location</th>
            <th>Guests</th>
        </tr>
        <tr><td><input id="organiser" type="text"></td><td><input id="title" type="text"></td><td><input id="description" type="text"></td><td><input id="start" type="date"></td><td><input id="end" type="date"></td><td><input id="location" type="text"></td><td><input id="invited" type="text"></td></tr>
    </table>
    <br>
    <input class="magicButton" type="button" onclick="postData()" id="postButton" value="Toevoegen">
</body>
</html>
