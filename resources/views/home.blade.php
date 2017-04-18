<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <title>Welkom</title>
    <!-- Fonts -->
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
        <tr><td>{{$user->username}}</td><td>{{$user->first_name}}</td><td>{{$user->last_name}}</td><td>{{$user->role}}</td><td>{{$user->address}}</td></tr>
    @endforeach



</table>
<div class="table-title">
    <h3>Voeg een gebruiker toe</h3>
</div>
<form name="userform" method="post" action="/users">
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

    <tr><td><input name="username" type="text"></td><td><input name="first_name" type="text"></td><td><input name="last_name" type="text"></td><td><input name="hash" type="password"></td><td><select name="role" id="soflow-color"><option>CEO</option><option>Extern employee</option><option>Intern employee</option></select></td><td><input name="address" type="text"></td></tr>

</table>
<br>
<input class="magicButton" type="submit" value="Toevoegen">
</form>
</body>
</html>
