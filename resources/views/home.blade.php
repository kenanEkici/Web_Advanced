<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <title>Welkom</title>
    <script
            src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <script src="{!! asset('js/users.js') !!}"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
</head>
<body>

{{ HTML::style('css/login.css') }}

<table id="table">
    <div class="table-title">
        <h3>Bestaande gebruikers</h3>
    </div>
    <tr>
        <th>Name</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Role</th>
        <th>Address</th>
    </tr>
    @foreach($userList as $user)
        <tr><td>{{$user->username}}</td><td>{{$user->first_name}}</td><td>{{$user->last_name}}</td><td>{{$user->role}}</td><td>{{$user->address}}</td><td><input type="button" class="magicButton"  onclick="deleteUser(this.id)" id={{$user->user_id}} value="Verwijder"></td></tr>
    @endforeach

</table>
<div class="table-title">
    <h3>Voeg een gebruiker toe of update</h3>
</div>
<form name="userform" method="post" action="/users/data/crud">
    {{ csrf_field() }}
<table id="table2">
    <tr>
        <th>Name</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Password</th>
        <th>Role</th>
        <th>Address</th>
    </tr>
    <tr><td><input id="username" type="text"></td><td><input id="first_name" type="text"></td><td><input id="last_name" type="text"></td><td><input id="hash" type="password"></td><td><select id="role" id="soflow-color"><option>CEO</option><option>Extern employee</option><option>Intern employee</option></select></td><td><input id="address" type="text"></td></tr>
</table>
<br>
<input class="magicButton" type="button" onclick="postData()" id="postButton" value="Toevoegen">
</form>
</body>
</html>
